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