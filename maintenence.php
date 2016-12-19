<?php
include('header.php');
//Basic maintenence file.
$verify = new Verification;
$log = new Logging;
if($verify->is_admin()){
    $MVC->display('admin_maintenence_template.php');
    //Clear databases (pull install.sql and just clear and reset database
    global $dbh;
    $clear_times="DELETE FROM `times`";
    $clear_team="DELETE FROM `team`";
    $delete_slots="DELETE FROM `slots`";
    $clear_slots=" UPDATE slots SET `team1`=0,`team2`=0,`team3`=0,`team4`=0,`team5`=0,`team6`=0,`team7`=0,`team8`=0,`team9`=0,`team10`=0,`team11`=0,`team12`=0,`team13`=0,`team14`=0,`team15`=0";
    $clear_event="DELETE FROM `event`";
    $clear_sql="DELETE FROM `teams`";
    if($_POST['times']){
        $dbh->query($clear_times);
        $log->add_entry('Admin','Cleared all times');
    }
    if($_POST['teams']){
        $dbh->query($clear_team);
        $log->add_entry('Admin','Cleared all teams');
    }
    if($_POST['slots']){
        $dbh->query($delete_slots);
        $log->add_entry('Admin','Cleared all slots');
        
    }
    if($_POST['clearSlots']){
        $dbh->query($clear_slots);
        $log->add_entry('Admin','Cleared all slots');
        
    }
    if($_POST['events']){
        $dbh->query($clear_event);
        $log->add_entry('Admin','Cleared all events');
    }
}
?>
