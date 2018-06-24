(function ($) {
    $.fn.editable = function(csrf, packName) {

        var currentField;
        var packIn = packName ? packName : "";
        var _csrf = csrf ? csrf : "";
        var groupUpdateTimeout = {};

        function saveData(element) {
            var name = $(element).attr("name");
            var type = $("[data-name=" + name + "]").attr("data-type");
            console.log("[saveData] ", name, type);
            if (
                type != "selectbox" &&
                type != "colorpicker" &&
                type != "number" &&
                type != "autocomplete" &&
                type != "textarea" &&
                type != "tel" &&
                type != undefined &&
                type != "" &&
                (groupUpdateTimeout[name] !== undefined || groupUpdateTimeout[name] === 0)) {
                if (groupUpdateTimeout[name] > 0) {
                    clearTimeout(groupUpdateTimeout[name]);
                }
                groupUpdateTimeout[name] = setTimeout(saveData, 1000, element);
                console.log("[saveData] set in query");
                return;
            } else {
                groupUpdateTimeout[name] = 0;
            }
            var val = $(element).prop("type") != "checkbox" ? $(element).val() : ($(element).prop("checked") ? $(element).val() : 0);
            if ($(element).attr("pattern") && !val.match($(element).attr("pattern"))) {
                console.log("[saveData] val",val,"not valid for pattern",$(element).attr("pattern"));
                return;
            }
            var sendName = name;
            var data = { "hasEditable":1, "_csrf":_csrf };
            if (packIn !== "") {
                sendName = packIn + "[" + name + "]";
                data[packIn] = {};
                data[packIn][name] = val;
            } else {
                data[name] = val;
            }
            // if ($("[data-name=" + name + "]").length > 0) {
            //     editOff(element);
            // }
            var orgVal = $("[data-name=" + name + "]").attr("data-origin");
            if (val == orgVal) {
                console.log("[saveData] Data not changed in " + name + ". Skip save");
                editOff(element);
                return;
            }
            $(".error-msg").hide();
            $.post("#", data, function(data) {
                groupUpdateTimeout[name] = undefined;
                if (data && data["message"] != "") {
                    var error = $("#error-" + name);
                    if (error.length == 0) {
                      error = $("<span>").attr("id", "error-" + name).addClass("error-msg");
                      if ($("[data-name=" + name + "]").length > 0) {
                          $("[data-name=" + name + "]").parent().parent().append(error);
                      }
                    }
                    error.text(data["message"]).show();
                } else if ($("[data-name=" + name + "]").length > 0) {
                    $("[data-name=" + name + "]").attr("data-origin", val);
                    updateViewFromData(name);
                    editOff(element);
                }
            });
        }

        function onKeyPress(event) {
            if (currentField) {
                if (event.which == 13) { // enter
                    saveData(currentField);
                }
            }
        }

        function updateViewFromData(name) {
            // return;
            // console.log("updateViewFromData", name);
            var el = $("[data-name=" + name + "]");
            if (el) {
                if (el.hasClass("required") && !el.attr("data-origin")) {
                    // console.log("Required fill. Skip hide");
                    return;
                }
                var data_list, id;
                switch (el.attr("data-type")) {
                    case "autocomplete":
                    case "linkbox":
                        // data_list = window[el.attr("data-list")];
                        id = el.attr("data-origin");
                        var a = $("<a>").attr("src", "#").text(id);
                        el.html(a);
                        if ($(".copy-" + name).length > 0) {
                            $(".copy-" + name).html(id);
                        }
                        break;
                    case "selectbox":
                        data_list = window[el.attr("data-list")];
                        id = el.attr("data-origin");
                        var data = data_list[id];
                        if (undefined === data) {
                            data = id;
                        }
                        el.html(data);
                        break;
                    case "colorpicker":
                        data_list = window[el.attr("data-list")];
                        id = el.attr("data-origin");
                        el.html("<span class=\"color " + (data_list[id]["class"] !== undefined ? data_list[id]["class"] : "color" + id)  + "\"></span>" + (data_list[id]["name"] !== undefined ? data_list[id]["name"] : data_list[id]));
                        break;
                    default:
                        el.html(el.attr("data-origin"));
                        if ($(".copy-" + name).length > 0) {
                            $(".copy-" + name).html(el.attr("data-origin"));
                        }
                        break;
                }
            }
        }

        function editOff(element) {
            // return;
            $(".error-msg").hide();
            var name = $(element).attr("name");
            // console.log("editOff", $("[data-name=" + name + "]", $(element).val()));
            if ($("[data-name=" + name + "]").hasClass("required") && !$(element).val()) {
                // console.log("[editOff] Required fill. Skip hide");
                return;
            }
            $(element).hide();
            if ($("[data-edit-name=" + name + "]").attr("data-state") !== undefined) {
                $("[data-edit-name=" + name + "]").show();
            }
            updateViewFromData(name);
            currentField = false;
        }

        function onEditFieldFocusLost()
        {
            console.log("onEditFieldFocusLost");
            saveData(this);
            // editOff(this);
        }

        function showInputIn(name, type)
        {
            var dataContainer = $("[data-name=" + name + "]");
            currentField = $("<input>").attr({
                "type": type,
                "name": name
            }).addClass("t-inp")
              .val(dataContainer.attr("data-origin"))
              .focusout(onEditFieldFocusLost)
              .keypress(onKeyPress);
            if ("number" == type) {
                currentField.attr("min", 0);
            }
            if (dataContainer.attr("data-placeholder")) {
                currentField.attr("placeholder", dataContainer.attr("data-placeholder"));
            }
            if (dataContainer.attr("data-pattern")) {
                currentField.attr("pattern", dataContainer.attr("data-pattern"));
            }
            if (dataContainer.attr("data-title")) {
                currentField.attr("title", dataContainer.attr("data-title"));
            }
            dataContainer.html(currentField);
            if ($("[data-edit-name=" + name + "]").length > 0 && $("[data-edit-name=" + name + "]").is(":visible")) {
                $("[data-edit-name=" + name + "]").attr("data-state", "needshow").hide();
            }
            currentField.focus(onFocus);
        }

        function saveSelect() {
            saveData(this);
        }

        function showSelectBox(name) {
            var parent = $("[data-name=" + name+ "]");
            parent.empty();
            var select = $("<select>").attr("name", name);
            var data_list = window[parent.attr("data-list")];
            var use_val_as_key = false;
            for (var i in data_list) {
               if (!use_val_as_key && i === 0) {
                   use_val_as_key = true;
               }
               $("<option>").val(use_val_as_key ? data_list[i] : i).text(data_list[i]["name"] !== undefined ? data_list[i]["name"] : data_list[i]).appendTo(select);
            }
            select
              .val(parent.attr("data-origin"))
              .appendTo(parent)
              .bind("change", saveSelect)
              .focusout(onEditFieldFocusLost);
            currentField = select;
            if ($("[data-edit-name=" + name + "]").length > 0 && $("[data-edit-name=" + name + "]").is(":visible")) {
                $("[data-edit-name=" + name + "]").attr("data-state", "needshow").hide();
            }
        }

        function onRadiogroupChanged() {
          // console.log(this);
          //var value = this.value;
          saveData(this);
        }

        function onCheckboxChanged() {
            if ($(this).prop("checked")) {
                $(this).parent().addClass("checked");
            } else {
                $(this).parent().removeClass("checked");
            }
            var container = $(this).parent().parent();
            if (container && container.attr("name") !== undefined) {
                var checkedValues = $("input:checkbox:checked", container).map(function() {
                    return this.value;
                }).get();
                container.val(checkedValues);
                saveData(container);
            } else {
                saveData(this);
            }
        }

        function showTextarea(name)
        {
            var dataContainer = $("[data-name=" + name + "]");
            currentField = $("<textarea>").attr({
                "name": name
            }).text(dataContainer.attr("data-origin"))
              .focusout(onEditFieldFocusLost)
              .keypress(onKeyPress);
            dataContainer.html(currentField);
            if ($("[data-edit-name=" + name + "]").length > 0 && $("[data-edit-name=" + name + "]").is(":visible")) {
                $("[data-edit-name=" + name + "]").attr("data-state", "needshow").hide();
            }
            if (dataContainer.attr("data-placeholder")) {
                currentField.attr("placeholder", dataContainer.attr("data-placeholder"));
            }
            currentField.focus(onFocus);
        }

        function onFocus(event)
        {
            console.log("onFocus", event.target);
            currentField = event.target;
        }

        function onEditClick(event) {
            if ($("[type=checkbox]", event.target).length === 0 && $("[type=radio]", event.target).length === 0 && !$(event.target).prop("type")) {
                var name = $(this).attr("data-edit-name");
                if (name === undefined) {
                    name = $(this).attr("data-name");
                }
                if (name !== undefined) {
                    switch ($("[data-name=" + name+ "]").attr("data-type")) {
                        default:
                            showInputIn(name, "text");
                            break;
                        case "number":
                            showInputIn(name, "number");
                            break;
                        case "autocomplete":
                            showInputIn(name, "text");
                            currentField.autocomplete({
                                source: function (request, response) {
                                  // console.log("autocomplete", $(currentField).parent().attr("data-list"));
                                    $.get($(currentField).parent().attr("data-list"), {
                                        city: request.term
                                    }, function (data) {
                                        response(data);
                                    });
                                },
                                minLength:3
                            });
                            break;
                        case "linkbox":
                        case "colorpicker":
                        case "selectbox":
                            showSelectBox(name);
                            break;
                        case "textarea":
                            showTextarea(name);
                            break;
                    }
                }
                if (currentField) {
                    $(currentField).focus();
                }
                return false;
            }
        }

        this.bind("click", onEditClick);
        if ($("[type=checkbox]", this).length > 0) {
            $("[type=checkbox]", this).bind("change", onCheckboxChanged);
        }
        if ($("[type=radio]", this).length > 0) {
            $("[type=radio]", this).bind("change", onRadiogroupChanged);
        }
        $(document).keyup(function(e) {
            if (currentField && e.keyCode == 27) { // escape key maps to keycode `27`
                editOff(currentField);
            }
            if (currentField && e.keyCode == 13) {
                saveData(currentField);
                e.stopPropagation();
            }
        });
        $(".required").each(function() {
            this.click();
        });
    };
} (jQuery));
