<?php
include('header.php');
//$MVC->display_admin_adding();
$EVENTS= new Events();
$SLOTS= new Slots();
$Verify=new Verification;
if($Verify->is_admin()){
    if(!empty($_POST)){
        if($_POST['add']){
            if($EVENTS->add_events($_POST['event_name'])==0){
                echo 'Event Added';
                $MVC->display_admin_adding();
            }else{
                echo 'There was an error, please try again!';
                $MVC->display_admin_adding();
            }
        } 
        if($_POST['add_slot']){
            $SLOTS->add_slots($_POST['time_slot']);
            //add_time_slot();
            if(isset($_POST['check_list'])){
                foreach($_POST['check_list'] as $check) {      //Loop through checked events to add to time slot.
                   if($EVENTS->add_events_at($check,$_POST['time_slot'])==0){
                        echo 'Slot Added';
                   }else{
                        echo 'There was an error adding slots. Please try again.';
                   }
                }
                $MVC->display_admin_adding();
            }else{
                $MVC->display_admin_adding();
            }
            
        }
        if($_POST['add_times']){
            foreach($_POST['time_checks'] as $time){
                $EVENTS->add_events_at($_POST['event_checks'],$time);
            }
            $MVC->display_admin_adding();
        }
        if($_POST['drop_times']){
            foreach($_POST['drop_time_checks'] as $time){
                $EVENTS->drop_events($_POST['drop_slots_event'],$time);
            }
            $MVC->display_admin_adding();
        }
    }else{
        $MVC->display_admin_adding();
    }
}
?>  
