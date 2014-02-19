<h2><a href="event_import.php">Click here to import current events</a></h2>
<h2>Add Events</h2>
<form method="POST" action="">
    <b>Event Name:</b><input type="text" name="event_name"/>
    <input type="submit" class="myButton" value="Add Event" name="add"/>
</form><br/>
<h2>Add Time Slots</h2>
<form method="POST" action="">
<b>Time Slot:</b><input type="text" name="time_slot"/><Br/>
<?php $event=new Events(); ?>
<?php echo $event->event_checkbox(); ?>

<input type="submit" class="myButton" value="Add Time Slot" name="add_slot"/>
</form><br/>

<h2>Current Events</h2>
<?php $event->list_events();?>

<h2>Add Times to Events</h2>
<div>
<?php $MVC=new MVC();
        echo $MVC->table_adding_slots();
        //echo $MVC->display_events_slots();
        ?>
        </div>
<div id="event_spacer"></div>
<div>
<?php $MVC=new MVC();
        echo $MVC->display_events_slots();
        ?>
</div>