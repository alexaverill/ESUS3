<?php
include('header.php');
$Verify=new Verification;
if($Verify->is_admin()){
    if(isset($_POST['update'])){
    echo $MVC->display_timer();
    }else{
        echo $MVC->display_timer();
    }
        $TIMER =  new Timer();
    
    $status=$TIMER->check_timer_status();
        if($status){
        echo '<h3>Currently Open</h3>';
    }else{
        echo '<h3>Currently Closed</h3>';
    }
    $MVC->display('admin_timer_teplate.php'); 


    if(isset($_POST['update'])){
        $start_time=$_POST['st_hour'].':'.$_POST['st_min'];
        $end_time=$_POST['end_hour'].':'.$_POST['end_min'];
      $TIMER->update_timer($_POST['start_dt'],$_POST['end_dt'],$start_time,$end_time);
    }
    if(isset($_POST['change'])){
        echo 'BLEh';
        $TIMER->change_type($_POST['type']);
    }
}
?>
