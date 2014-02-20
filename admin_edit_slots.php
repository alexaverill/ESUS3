<?php
include('header.php');
//Admin Edit Slots
$SLOTS=new  Slots();
if($_POST['change_num']){
    $SLOTS->change_num_slots($_POST['event'],$_POST['typein']);
    $MVC->admin_edit_slots();
}else{
    $MVC->admin_edit_slots();
}
?>