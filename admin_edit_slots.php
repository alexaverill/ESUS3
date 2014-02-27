<?php
include('header.php');
//Admin Edit Slots
$SLOTS=new  Slots();
$Verify=new Verification;
if($Verify->is_admin()){
    if($_POST['change_num']){
        $SLOTS->change_num_slots($_POST['event'],$_POST['typein']);
        $MVC->admin_edit_slots();
    }else{
        $MVC->admin_edit_slots();
    }
}
?>