<?php
include('header.php');
//Basic maintenence file.
$verify = new Verification;
if($verify->is_admin()){
    $MVC=new MVC();
    $MVC->display_log();
    $MVC->display_maintenence();
    //Clear databases (pull install.sql and just clear and reset database
    $clear_times="DELETE * FROM `times`";
$clear_team="DELETE * FROM `teams`";
$clear_slots="DELETE * FROM `slots`";
$clear_event="DELETE * FROM `event`";
$clear_sql="DELETE * FROM `teams`";

}
?>
