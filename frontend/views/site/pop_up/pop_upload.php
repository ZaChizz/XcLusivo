<?php
/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 06.06.2016
 * Time: 2:54
 */

 use yii\web\View;
 use frontend\assets\CropperAsset;
 use frontend\models\AdvertiserMedia;

 CropperAsset::register($this);

 $ratio = AdvertiserMedia::RATIO;
 $isMobile = mobile_detect();
?>
<div class="pop-up" id="pop-upload">
    <div class="pop-title title-photo"><?=Yii::t('app', 'Take photo');?><?php if (!$isMobile) { ?> <a href="#" id="snap" class="btn btn-gray first-run"><?=Yii::t('app', 'Run webcam');?></a><?php } ?></div>
    <div class="mess-form">
<?php if ($isMobile) { ?>
        <input type="file" accept="image/*" id="mobPhotoTake">
        <div>
            <img id="photoImage">
        </div>
<?php } else { ?>
        <video id="camStream" width="95%" height="450px"></video>
        <canvas id="photoCanvas"></canvas>
<?php } ?>
    </div>
    <div class="mess-submit">
        <a href="#" class="btn btn-gray"><?=Yii::t('app', 'Cancel');?></a>
        <input type="submit" value="<?=Yii::t('app', 'Upload this photos');?>" class="btn" id="upload_photo">
    </div>
</div>

<?php
    ob_start();
    if (!$isMobile) {
?>
        var canvas = document.getElementById("photoCanvas"),
            video = document.getElementById("camStream"),
            videoObj = { "video": { mandatory: {
                minWidth:<?=AdvertiserMedia::WEBCAM_WIDTH;?>,
                minHeight:<?=AdvertiserMedia::WEBCAM_HEIGHT;?>,
                maxWidth:<?=AdvertiserMedia::WEBCAM_WIDTH;?>,
                maxHeight:<?=AdvertiserMedia::WEBCAM_HEIGHT;?>
            } } };
        function errBack(error) {
            stopPlay();
            if (error && error.name == "ConstraintNotSatisfiedError") {
              videoObj["video"]["mandatory"] = {
                minWidth:videoObj["video"]["mandatory"]["minWidth"] / 2,
                minHeight:videoObj["video"]["mandatory"]["minHeight"] / 2,
                maxWidth:videoObj["video"]["mandatory"]["maxWidth"] / 2,
                maxHeight:videoObj["video"]["mandatory"]["maxHeight"] / 2
              };
              playCamera();
              return;
            }
            console.log("Video capture error: ", error);
        };
        var cameraPlayed = false;
        var localStream;
<?php } else { ?>
        var canvas;
<?php } ?>
        var loadUrl = "<?=Yii::getAlias('@frontendWeb');?>/advertiser/upload",
            displayContainer = document.getElementById("photoImage");

        // load file

        function onFileReaded(e) {
            if (e) {
              loadImageTo(displayContainer, e.target.result);
            }
        }

        function onFileSelected(data) {
            if (displayContainer) {
                var input = data.currentTarget;
                if (input && input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = onFileReaded;
                  reader.readAsDataURL(input.files[0]);
                }
            }
        }

        function loadImageTo(container, src) {
            $(container).attr("src", src);
        }

        function uploadPhotoFromCanvas(canvas) {
            uploadImage(canvas.toDataURL("image/jpeg", <?=AdvertiserMedia::JPEG_RATIO;?>));
        }

        function uploadPhotoFromImage(img) {
            uploadImage(img.src);
        }

        function uploadImage(imgData) {
            $.ajax({
              type: "POST",
              url:loadUrl,
              data: {
                 imgBase64:imgData
              }
            }).done(function(o) {
                console.log("Photo uploaded!", o);
                if (o != "") {
                    needPageReloadOnClose = false;
                    $.fancybox.close();
                    setTimeout(runImageEditor, 1000, o);
                } else {
                    needPageReloadOnClose = true;
                }
                // playCamera();
            });
        }

        // webcam

        function playCamera() {
            console.log("playCamera");
            $("#photoCanvas").hide();
            $("#camStream").addClass("cam-play").show();
            $("#upload_photo").hide();
            $("#snap").removeClass("first-run").blur();

            if(navigator.getUserMedia) { // Standard
                navigator.getUserMedia(videoObj, function(stream) {
                    localStream = stream;
                    video.src = stream;
                    video.play();
                }, errBack);
            } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
                navigator.webkitGetUserMedia(videoObj, function(stream){
                    localStream = stream;
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                }, errBack);
            } else if(navigator.mozGetUserMedia) { // WebKit-prefixed
                navigator.mozGetUserMedia(videoObj, function(stream){
                    localStream = stream;
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                }, errBack);
            }
            cameraPlayed = true;
            $("#snap").text("Take photo");
        }

        function stopPlay() {
            console.log("stopPlay");
            if (localStream) {
                localStream.getVideoTracks()[0].stop();
            }
            $("#camStream").removeClass("cam-play").hide();
            $("#photoCanvas").show();
            $("#snap").blur();
            cameraPlayed = false;
            $("#snap").text("Run webcam");
            $("#upload_photo").show();
        }

        // -----------

        $('.fancy').fancybox({
           'afterClose': function() {
               console.log("fancybox close");
<?php if (!$isMobile) { ?>
                stopPlay();
<?php } ?>
           }
        });
        if ($("#mobPhotoTake").length > 0) {
            console.log("bind mobPhotoTake change");
            $("#mobPhotoTake").change(onFileSelected);
        }

        $("#pop-upload .mess-submit a").bind("click", function() {
            $.fancybox.close();
        });

        $("#upload_photo").bind("click", function() {
            console.log("Try save");
            <?php if ($isMobile) { ?>
            uploadPhotoFromImage(displayContainer);
            <?php } else { ?>
            $(canvas).css("width", orgVideoWidth).css("height", orgVideoHeight);
            uploadPhotoFromCanvas(canvas);
            <?php } ?>
        });

        var orgVideoWidth, orgVideoHeight;

        $("#snap").bind("click", function() {
            if (cameraPlayed) {
                orgVideoWidth = video.videoWidth;
                orgVideoHeight = video.videoHeight;
                canvas.width = orgVideoWidth;
                canvas.height = orgVideoHeight;
                var context = canvas.getContext("2d");
                context.drawImage(video, 0, 0, orgVideoWidth, orgVideoHeight);
                stopPlay();
            } else {
                playCamera();
            }
        });
<?php
    $js_content = ob_get_contents();
    ob_end_clean();
    $this->registerJs($js_content, View::POS_READY);

    ob_start();
?>
// image editor
var ratio = <?=$ratio;?>,
    minCropWidth = <?=AdvertiserMedia::MIN_WIDTH;?>,
    minCropHeight = <?=AdvertiserMedia::MIN_HEIGHT;?>;
var editImage = "#edit-image";
var firstCropInit = true;
var cropData = {};
var cropImage;

function runImageEditor(src) {
    console.log("runImageEditor", firstCropInit);
    firstCropInit = true;
    $(editImage).show().prop("src", src).one("load", function() {
      var scale = $("body").width()  / $(editImage).prop("width");
      if (scale > 1) {
          scale = 1;
      }
      $(this).cropper({
        aspectRatio:ratio,
        minCropBoxWidth:minCropWidth * scale,
        minCropBoxHeight:minCropWidth * scale,
        crop: function(e) {
          if (firstCropInit) {
              var data = $(editImage).cropper("getImageData");
              var scale = $(".cropper-container").width() / $(editImage).prop("width");
              $(editImage).
                cropper("zoomTo", scale).
                cropper("setCropBoxData", {"left":0,"top":0,"width":data.width * scale, "height":data.height * scale} );
              firstCropInit = false;
          }
        }
      });

      $.fancybox($("#pop-image-editor"), {
          'afterClose': function() {
              console.log("image editor close");
              $(editImage).cropper("destroy");
          }
      });
    });

    $("#cropper-toolbar").show();
    $("#save-crop-photo").hide().unbind("click").click(saveCropImage);
    $("#cancel-image-edit").unbind("click").click(function() {
        $.fancybox.close();
    });
    $("#crop-button").show().unbind("click").click(showCroppedImage);
    $("#rotate-left").unbind("click").click(function() { $(editImage).cropper('rotate', -90); $(this).blur(); });
    $("#rotate-right").unbind("click").click(function() { $(editImage).cropper('rotate', 90); $(this).blur(); });
}

function showCroppedImage() {
    console.log("showCroppedImage");
    cropImage = $(editImage).cropper('getCroppedCanvas');
    $('.mess-form').append(cropImage);
    $(editImage).cropper("destroy");
    $(editImage).hide();
    $("#cropper-toolbar").hide();
    $("#crop-button").hide();
    $("#save-crop-photo").show();
}

function saveCropImage() {
    $("#save-crop-photo").prop("disabled", true);
    $.ajax("<?=Yii::getAlias('@frontendWeb');?>/advertiser/crop-image", {
        method: "POST",
        data: {
            cropData: cropImage.toDataURL("image/jpeg", <?=AdvertiserMedia::JPEG_RATIO;?>),
            cropImage:$(editImage).prop("src")
        },
        success: function (data) {
          console.log('Upload success', data);
          location.reload();
        },
        error: function () {
          console.log('Upload error');
        }
    });
}
<?php
$js_content = ob_get_contents();
ob_end_clean();
$this->registerJs($js_content, View::POS_END);


function mobile_detect() {
    $user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
    if ($user_agent == '') {
        return false;
    }

    $ipod = (strpos($user_agent, 'iPod') !== false);
    $ipad = (strpos($user_agent, 'iPad') !== false);
    $iphone = (strpos($user_agent, 'iPhone') !== false);
    if ($ipod || $ipad || $iphone) {
        return true;
    }
    if (strpos($user_agent, 'Android') !== false) {
        return true;
    }
    if (strpos($user_agent, 'Symbian') !== false) {
        return true;
    }
    $winphone = (strpos($user_agent, 'WindowsPhone') !== false);
    $wp7 = (strpos($user_agent,'WP7') !== false);
    $wp8 = (strpos($user_agent,'WP8') !== false);
    if ($winphone || $wp7 || $wp8) {
        return true;
    }

    $operam = (strpos($user_agent,"Opera M") !== false);
    $palm = (strpos($user_agent,"webOS") !== false);
    $berry = (strpos($user_agent,"BlackBerry") !== false);
    $mobile = (strpos($user_agent,"Mobile") !== false);
    $htc = (strpos($user_agent,"HTC_") !== false);
    $fennec = (strpos($user_agent,"Fennec/") !== false);

    if ($operam || $palm || $berry || $mobile || $htc || $fennec) {
        return true;
    }
    return false;
}
