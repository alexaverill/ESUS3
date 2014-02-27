<?php
include('header.php');
$MVC=new MVC();
$SLOTS=new Slots();
 $Verify=new Verification;
if($Verify->is_admin()){
    if($_POST['getthis']){
        
        $SLOTS->clear_slot($_POST['event'],$_POST['time'],$_POST['slot'],$_POST['id']);
        $MVC->display_admin_event_table();
    }else{
        $MVC->display_admin_event_table();
    }
}
?>