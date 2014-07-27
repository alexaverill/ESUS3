<?php $event=new Events(); ?>
<h2>Add Events</h2>
<form method="POST" action="">
    <b>Event Name:</b><input type="text" name="event_name"/>
    <input type="submit" class="myButton" value="Add Event" name="add"/>
</form><br/>
<hr>
<h2>Edit Event Names (Click to edit)</h2>
<?php $event->list_events();?>
<hr>
<h2>Delete Events</h2>
<form method="POST" action="">
    <?php $event->select_events();?>
    <input type="submit" name="deleteEvents" value="Delete Events"/>
</form>
<hr>
<h2>Add Time Slots</h2>
<form method="POST" action="">
<b>Time Slot:</b><input type="text" name="time_slot"/><Br/>

<?php echo $event->event_checkbox(); ?>

<input type="submit" class="myButton" value="Add Time Slot" name="add_slot"/>
</form><br/>
<hr>
    <?php $MVC=new MVC();
echo $MVC->display_slots_editable();
?>
<hr>
<h2>Delete Slots</h2>
<form method="POST" action="">
<?php $slots= new Slots;
echo $slots->slot_select();
?>
<input type="submit" name="deleteSlots" value="Delete Slots"/>
</form>
<hr>
<?php  print $MVC->display_slots_table();?>
<Br/>
<hr>
<h2>Events with Slots</h2>
<h3>Green times are in the event; grey times are not.</h3>
<div id="adding">
<?php $MVC=new MVC();
        echo $MVC->table_adding_slots();
        //echo $MVC->display_events_slots();
        ?>
</div>
<div id="event_spacer"></div>
