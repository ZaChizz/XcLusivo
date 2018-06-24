

var project = {};


project.booking = {};

project.booking.initCalendar = function (options)
{
	options = $.extend({
		//Custom options
		selector: '#calendar',
		bookingUrl: '',
		modelClass: 'Booking',
		modelFieldFrom: 'from_date',
		modelFieldTo: 'to_date',
		stubMode: false,
		//Native options
		editable: true,
		selectable: true,
		selectHelper: true,
		eventOverlap: false,
		selectOverlap: false,
		slotEventOverlap: false,
		//agenda
		allDaySlot: false,
		slotDuration: '01:00:00',
		defaultView: 'agendaWeek',
		header: {
			left: "prev",
			center: "agendaWeek, agendaDay",
			right: "next"
		},
		select: function (start, end, jsEvent, view, resource) {
			var postData = {};
			postData[options.modelClass] = {};
			postData[options.modelClass][options.modelFieldFrom] = start.format('X');
			postData[options.modelClass][options.modelFieldTo] = end.format('X');

			if (options.stubMode) {
				$.ajax({
					url: options.bookingUrl,
					method: 'POST',
					data: postData,
					dataType: 'json',
					success: function (response, textStatus, jqXHR) {
						if (response.success) {
							$(options.selector).fullCalendar('refetchEvents');
							$(options.selector).fullCalendar('rerenderEvents');
						}

						project.handleAjaxResponse(response, textStatus, jqXHR);
					}
				});

				return;
			}

			var message = 'Do you really want to book?';

			var confirm = project.confirmDialog(message, function () {

				$.ajax({
					url: options.bookingUrl,
					method: 'POST',
					data: postData,
					dataType: 'json',
					success: function (response, textStatus, jqXHR) {
						if (response.success) {
							$(options.selector).fullCalendar('refetchEvents');
							$(options.selector).fullCalendar('rerenderEvents');
							/*
							 $(options.selector).fullCalendar('renderEvent', {
							 title: '',
							 start: start,
							 end: end,
							 allDay: false
							 }, true);
							 */
						}

						confirm.close();
						project.handleAjaxResponse(response, textStatus, jqXHR);
					}
				});


			}, function () {
				//Cancel selection
				console.log('unselect');
				$(options.selector).fullCalendar('unselect');
			});
		}
	}, options);

	$(options.selector).fullCalendar(options);
	//http://fullcalendar.io/docs/event_data/events_json_feed/
	//http://fullcalendar.io/docs/event_data/Event_Object/
	//http://fullcalendar.io/docs/agenda/
}


project.booking._advConfirmDialog = null;
project.booking._advConfirmEvent = null;

project.booking.advEventClick = function (calEvent, jsEvent, view)
{
	var a = $(jsEvent.currentTarget);



	if (a.hasClass('js-user-view')) {

		if (a.hasClass('js-expired')) {
			if (calEvent.user_url) {
				window.open(calEvent.user_url, '_blank');
			} else {
				throw new Error('Invalid event data.');
			}

			return;
		}

		switch (calEvent.attributes.status) {
			case 'Pending':
				if (calEvent.manage_url) {
					project.booking._advConfirmEvent = calEvent;
					project.booking._advConfirmDialog = project.booking.confirmDialog(calEvent.manage_url);
				} else {
					throw new Error('Invalid event data.');
				}
				break;

			case 'Approved' :
				if (calEvent.user_url) {
					window.open(calEvent.user_url, '_blank');
				} else {
					throw new Error('Invalid event data.');
				}
				break;

			case 'Stub' :
				project.flashMessage('Remove disabled time range?', project.FM_CONFIRM, function () {
					$.ajax({
						url: calEvent.manage_url,
						method: 'POST',
						dataType: 'json',
						success: function (data, textStatus, xhr) {
							if (data.success) {
								$('#calendar').fullCalendar('removeEvents', calEvent.id);
								project.flashMessage(data.message, project.FM_SUCCESS);
							} else {
								project.flashMessage(data.message, project.FM_ERROR);

							}
						}
					});
				});
				break;
		}
	}
};


project.booking._checkEventExpiration = function(calEvent)
{
	
};

project.booking._nonAdvConfirmDialog = null;
project.booking._nonAdvConfirmEvent = null;

project.booking.nonAdvEventClick = function (calEvent, jsEvent, view)
{
	var a = $(jsEvent.currentTarget);

	if (a.hasClass('js-user-view')) {
		
		if (a.hasClass('js-expired')) {
			if (calEvent.user_url) {
				window.open(calEvent.user_url, '_blank');
			} else {
				throw new Error('Invalid event data.');
			}

			return;
		}
		
		switch (calEvent.attributes.status) {
			case 'Pending':

				project.flashMessage('Cancel unapproved booking?', project.FM_CONFIRM, function () {
					$.ajax({
						url: calEvent.manage_url,
						method: 'POST',
						dataType: 'json',
						data: {value: 0},
						success: function (data, textStatus, xhr) {
							if (data.success) {
								$('#calendar').fullCalendar('refetchEvents', calEvent.id);
								project.flashMessage(data.message, project.FM_SUCCESS);
							} else {
								project.flashMessage(data.message, project.FM_ERROR);
							}
						}
					});
				});

				break;

			case 'Approved' :
				if (calEvent.user_url) {
					window.open(calEvent.user_url, '_blank');
				} else {
					throw new Error('Invalid event data.');
				}
				break;
		}
	}
};


project.booking.confirmDialog = function (url)
{
	var cssClass = 'dialog dialog-booking col-md-6';

	var options = $.extend(project._commonDialogOptions, {
		confirmButton: false,
		cancelButton: false,
		title: 'Booking Confirmation',
		content: 'url:' + url,
		backgroundDismiss: true,
		closeIcon: true,
		onClose: function () {
			project.booking._advConfirmDialog = null;
			project.booking._advConfirmEvent = null;
		}
	});

	project.booking._advConfirm = $.confirm(options);
	return project.booking._advConfirm;
}

project.booking.cancelDialog = function (url)
{
	var cssClass = 'dialog dialog-booking col-md-6';

	var options = $.extend(project._commonDialogOptions, {
		confirmButton: 'Yes',
		cancelButton: 'No',
		title: 'Booking Cancellation',
		content: 'url:' + url,
		backgroundDismiss: true,
		closeIcon: true,
		onClose: function () {
			project.booking._nonAdvConfirmDialog = null;
			project.booking._nonAdvConfirmEvent = null;
		},
		confirm: function () {

		}
	});

	project.booking._nonAdvCancel = $.confirm(options);
	return project.booking._nonAdvCancel;
}

project.booking.initAdvManageButtons = function ()
{
	$('body').on('click', '.js-booking-manage', function (event) {
		event.stopPropagation();
		event.preventDefault();
		var link = $(this);
		var ajaxUrl = link.data('href');
		var ajaxValue = link.data('action');
		var postProcess = link.data('exec');

		$.ajax({
			url: ajaxUrl,
			data: {value: ajaxValue},
			method: 'POST',
			dataType: 'json',
			success: function (data, textStatus, xhr) {
				if (data.success) {
					data.value = parseInt(data.value);
					if (postProcess) {
						eval(postProcess);
					} else {
						$('#calendar').fullCalendar('refetchEvents');
					}

					if (project.booking._advConfirmDialog) {
						project.booking._advConfirmDialog.close();
					}

					project.flashMessage(data.message, project.FM_SUCCESS);
				} else {
					project.flashMessage(data.message, project.FM_ERROR);
				}

			}
		});
	});
}


// ******* Small Dialogs

project._commonDialogOptions = {
	confirmButton: 'OK',
	confirmButtonClass: 'btn-success',
	cancelButtonClass: 'btn-gray',
	theme: 'bootstrap'
};

project.FM_ERROR = 'error';
project.FM_WARNING = 'warning';
project.FM_SUCCESS = 'success';
project.FM_INFO = 'information';
project.FM_CONFIRM = 'confirmation';


project.flashMessage = function (message, type, okCallback, cancelCallback)
{
	var title = false;
	if (!type) {
		type = project.FM_INFO;
	}

	switch (type) {
		case project.FM_ERROR:
		case project.FM_WARNING:
		case project.FM_SUCCESS:
		case project.FM_INFO :
		case project.FM_CONFIRM :
			title = (new String(type)).charAt(0).toUpperCase() + (new String(type)).slice(1);
			break;
	}

	var cssClass = 'dialog dialog-flash flash-' + type;

	if (!okCallback) {
		okCallback = false;
	}

	if (!cancelCallback) {
		cancelCallback = false;
	}


	var options = $.extend(project._commonDialogOptions, {
		confirmButton: 'OK',
		cancelButton: (type == project.FM_CONFIRM) ? 'Cancel' : false,
		title: title,
		content: message,
		backgroundDismiss: true,
		columnClass: cssClass
	});

	if (okCallback) {
		options.confirm = okCallback;
	} else {
		options.confirm = function () {};
	}

	if (cancelCallback) {
		options.cancel = cancelCallback;
	} else {
		options.cancel = function () {};
	}

	return $.confirm(options);
}


project.confirmDialog = function (message, okCallback, cancelCallback)
{
	return project.flashMessage(message, project.FM_CONFIRM, okCallback, cancelCallback);
};


project.initFlashHandler = function (options)
{
	options = $.extend({
		selector: '.alert'
	}, options);

	var msg = $(options.selector).first();

	if (msg.length) {
		project.flashMessage(msg.html(), msg.data('type'));
	}
}


project.handleAjaxResponse = function (response, textStatus, jqXHR)
{
	if (response.flashes && response.flashes.length) {
		var f = response.flashes[0];
		project.flashMessage(f.message, f.type, function () {}, function () {});
	}
}


project.booking.initAdvManageButtons();