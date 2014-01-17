<?php
include('header.php');
$MVC->display_timer();
echo $MVC->admin_timer_form(); 
$TIMER =  new Timer();
$TIMER->check_timer_status();
if($_POST['update']){
  $TIMER->update_timer($_POST['start_dt'],$_POST['end_dt'],$_POST['start_time'],$_POST['end_time']);
}
?>