<?php
include('header.php');
//$MVC=new $MVC();
$Verify=new Verification;
if($Verify->is_admin()){
    $MVC->admin_mail();
    $MAIL=new Mail();
    if($_POST['send_times']){
    
        $MAIL->send_team_times($_POST['emails']);
    }
    if($_POST['all_teams']){
        $MAIL->send_all_times();
    }
    if($_POST['up']){
        $MAIL->upload_for_bulk($_POST['message'],$_FILES['uploadedfile']['name'],$_FILES['uploadedfile']['tmp_name']);
    }
    if($_POST['send_msg']){
        $MAIL->send_email($_POST['emails'],'admin','Announcement',$_POST['message']);
    }
}
?>