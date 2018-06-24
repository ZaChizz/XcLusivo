<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 20.05.2016
 * Time: 17:22
 */
use common\helpers\Toolbox;
?>

<div class="pop-up" id="pop-clnd">
    <div class="col-clnd">
        <div class="pop-title title-date"><?php echo $model->user->username; ?>'s Calendar</div>
		<div id="calendar"></div>
    </div>
    <div class="col-work">
        <div class="pop-title title-time">Working hours</div>
        <table class="table-time">
            <tr><td>Sunday</td><td>09:00 - 18:00</td></tr>
            <tr><td>Monday</td><td>09:00 - 18:00</td></tr>
            <tr><td>Tuesday</td><td>09:00 - 18:00</td></tr>
            <tr><td>Wednesday</td><td>09:00 - 18:00</td></tr>
            <tr><td>Thursday</td><td>09:00 - 18:00</td></tr>
            <tr><td>Friday</td><td>21:00 - 06:00</td></tr>
            <tr><td>Saturday</td><td>21:00 - 06:00</td></tr>
        </table>
    </div>
	<?= $template['bookLINK'] ?>
</div>

<?php
$this->registerJs(' 
	$("#calendar").fullCalendar({
		editable: true,
		selectable: true,
		selectHelper: true,
		header: {
			left: "prev",
			center: "month, agendaWeek, agendaDay",
			right: "next"
		},
		businessHours: {
			start: "00:00",
			end: "23:00",
			dow: [0,1,2,3,4,5,6,7]
		},
		/*
		dayClick: function() {
            alert("dayClick");
        },
		*/
		/*
		dayRender: function( date, cell ) { 
			cell.append($("<div>Custom content</div>"));
		},
		*/
 events:
[
    {
        id:    "available_hours",
        start: "' . Toolbox::sysFormatDateTime(Toolbox::sysFormatDate() . ' 10:00', ' ') . '",
        end:   "' . Toolbox::sysFormatDateTime(Toolbox::sysFormatDate() . ' 18:00', ' ') . '",
        rendering: "background"
    },
    {
        id:    "work",
        start: "' . Toolbox::sysFormatDateTime(Toolbox::sysFormatDate() . ' 13:00', ' ') . '",
        end:   "' . Toolbox::sysFormatDateTime(Toolbox::sysFormatDate() . ' 15:00', ' ') . '",
        constraint: "available_hours"
    }
]
	});
', yii\web\View::POS_READY);
?>

<?php
/*
  // Recycle Bin

  businessHours: {
  start: "00:00",
  end: "23:00",
  dow: [0,1,2,3,4,5,6,7]
  }
 * 
 * 
  dayClick: function() {
  alert("dayClick");
  },

 * 
  events:
  [
  {
  id:    "available_hours",
  start: "2015-1-13T8:00:00",
  end:   "2015-1-13T19:00:00",
  rendering: "background"
  },
  {
  id:    "work",
  start: "2015-1-13T10:00:00",
  end:   "2015-1-13T16:00:00",
  constraint: "available_hours"
  }
  ]
 * 
 * 
 */
?>