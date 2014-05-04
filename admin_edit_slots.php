<?php
include('header.php');
//Admin Edit Slots
$SLOTS = new  Slots();
$Verify = new Verification;
$EVENTS = new Events;
if($Verify->is_admin()){
     if(!empty($_POST)){
    if($_POST['change_num']){
        $SLOTS->change_num_slots($_POST['event'],$_POST['typein']);
        $MVC->display('admin_edit_template.php');
    }
     if($_POST['drop_times']){
            foreach($_POST['drop_time_checks'] as $time){
                $EVENTS->drop_events($_POST['drop_slots_event'],$time);
            }
            $MVC->display('admin_edit_template.php');
        }
    }else{
        $MVC->display('admin_edit_template.php');
    }
}
?>