<?php
include('header.php');
$SLOTS=new Slots();


if($_POST['getthis']){
    $id=$_SESSION['id']; //CHANGE THIS TO SESSION STORED ID AFTER TESTING!!!
   $SLOTS->claim_slot($id,$_POST['event'],$_POST['time']);
    $MVC->display_events();
}else{
    $MVC->display_events();
}

?>