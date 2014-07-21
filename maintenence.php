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
    $clear_slots="DELETE FROM `slots`";
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
        $dbh->query($clear_slots);
        $log->add_entry('Admin','Cleared all slots');
        
    }
    if($_POST['events']){
        $dbh->query($clear_event);
        $log->add_entry('Admin','Cleared all events');
    }
}
?>
