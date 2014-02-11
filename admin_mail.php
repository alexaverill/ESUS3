<?php
include('header.php');
//$MVC=new $MVC();
$MVC->admin_mail();
$MAIL=new Mail();
if($_POST['send_times']){

    $MAIL->send_team_times($_POST['emails']);
}
if($_POST['all_teams']){
    $MAIL->send_all_times();
}
?>