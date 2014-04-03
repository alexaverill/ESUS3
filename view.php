<?php
include('header.php');
$EVENTS=new Events();
if($_POST['remove']){
    $EVENTS->drop_own_event($_SESSION['id'],$_POST['event'],$_POST['time'],$_POST['slot']);
    $EVENTS->return_teams_events($_SESSION['id']);
}else{
    $EVENTS->return_teams_events($_SESSION['id']);
}
?>