<?php
include('header.php');
$MVC=new MVC();
$SLOTS=new Slots();
 
if($_POST['getthis']){
    
    $SLOTS->clear_slot($_POST['event'],$_POST['time'],$_POST['slot']);
    $MVC->display_admin_event_table();
}else{
    $MVC->display_admin_event_table();
}
?>