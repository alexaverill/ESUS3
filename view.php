<?php
include('header.php');
$EVENTS=new Events();
if($_POST['remove']){
    $EVENTS->drop_own_event($_SESSION['id'],$_POST['event'],$_POST['time'],$_POST['slot']);
        $EVENTS->return_team_events_table($_SESSION['id']);
    $EVENTS->return_teams_events($_SESSION['id']);

}else{
    $EVENTS->return_team_events_table($_SESSION['id']);
    echo '<br/>Use the Drop Events to remove yourself from an event you do not wish to compete in, to change times please use the <a href="index.php">select times page</a>';
    $EVENTS->return_teams_events($_SESSION['id']);

}
?>