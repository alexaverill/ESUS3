<?php
include('header.php');
$SLOTS=new Slots();
$MVC->display_events();
if($_POST['getthis']){
    var_dump($_POST['event']);
    $id=1; //CHANGE THIS TO SESSION STORED ID AFTER TESTING!!!
    $SLOTS->claim_slot($id,$_POST['event'],$_POST['time']);
}

?>