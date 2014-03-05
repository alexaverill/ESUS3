<?php
include('header.php');
$Verify=new Verification;
if($Verify->is_admin()){
    echo $MVC->display_timer();
        $TIMER =  new Timer();
    $status=$TIMER->check_timer_status();
        if($status){
        echo '<h3>Currently Open</h3>';
    }else{
        echo '<h3>Currently Closed</h3>';
    }
    $MVC->admin_timer_form(); 


    if($_POST['update']){
      $TIMER->update_timer($_POST['start_dt'],$_POST['end_dt'],$_POST['start_time'],$_POST['end_time']);
    }
}
?>
