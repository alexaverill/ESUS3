<?php
include('header.php');
//$MVC=new $MVC();
$MVC->admin_mail();

if($_POST['send_times']){
    $MAIL=new Mail();
    $MAIL->send_team_times($_POST['emails']);
}
?>