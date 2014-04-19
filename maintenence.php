<?php
include('header.php');
//Basic maintenence file.
$MVC=new MVC();
$MVC->display_log();

$MVC->display_maintenence();
//Clear databases (pull install.sql and just clear and reset database
$clear_times="DELETE * FROM `times`";
$clear_team="DELETE * FROM `teams`";
$clear_slots="DELETE * FROM `slots`";
$clear_event="DELETE * FROM `event`";

//Check # of slots vs max possible in database
//if not equal expand database

//Clear teams
$clear_sql="DELETE * FROM `teams`";
//Other goodies as needed
?>
