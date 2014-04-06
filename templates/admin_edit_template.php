<?php /*include('classes.php');*/ $MVC=new MVC();?>
<div id="columns">
    <div id="bulk">
<?php echo $MVC->display_slots_table();?>
</div>
<div id="individual1">
<?php
echo $MVC->display_slots_editable();
?>
</div>
<div id="currentslots">
<?php $MVC=new MVC();
        echo $MVC->display_events_slots();
        ?>
</div>
</div>