<?php $event=new Events(); ?>
<h2>Add Events</h2>
<form method="POST" action="">
    <b>Event Name:</b><input type="text" name="event_name"/>
    <input type="submit" class="myButton" value="Add Event" name="add"/>
</form><br/>
<hr>
<h2>Current Events</h2>
<?php $event->list_events();?>
<hr>
<h2>Add Time Slots</h2>
<form method="POST" action="">
<b>Time Slot:</b><input type="text" name="time_slot"/><Br/>

<?php echo $event->event_checkbox(); ?>

<input type="submit" class="myButton" value="Add Time Slot" name="add_slot"/>
</form><br/>

<hr>
<h2>Events with Slots</h2>
<h3>Gray means that the slot not yet in the events. Green means the slot is in the event</h3>
<div id="adding">
<?php $MVC=new MVC();
        echo $MVC->table_adding_slots();
        //echo $MVC->display_events_slots();
        ?>
</div>
<div id="event_spacer"></div>
