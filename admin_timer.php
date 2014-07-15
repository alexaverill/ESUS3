<?php
include('header.php');

if($VERIFICATION->is_admin()){
        $TIMER =  new Timer();
    if(isset($_POST['update'])){
        $start_time=$_POST['st_hour'].':'.$_POST['st_min'];
        $end_time=$_POST['end_hour'].':'.$_POST['end_min'];
        $TIMER->update_timer($_POST['start_dt'],$_POST['end_dt'],$start_time,$end_time);
        echo $MVC->display_timer();
    }
    if(isset($_POST['change'])){
        $TIMER->change_type($_POST['type']);
        echo $MVC->display_timer();
    }else if (!$_POST['update']){
        echo $MVC->display_timer();
    }
    $status=$VERIFICATION->is_open();
    if($status){
        echo '<h3>Currently Open</h3>';
    }else{
        echo '<h3>Currently Closed</h3>';
    }
    $MVC->display('admin_timer_teplate.php'); 



}
?>
