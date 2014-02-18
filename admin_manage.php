<?php
include('header.php');
//$MVC->display_admin_manage();
$USER=new Users();
	if ($_POST['adduser']){
         $USER->add_user($_POST['user'],$_POST['password'],$_POST['email'],$_POST['email']); 
         $MVC->display_admin_manage(); 
    }else if($_POST['teams']){
        $USER->show_user_info($_POST['call']);
		$MVC->display_admin_manage();
    }else if($_POST['change_pass']){
            $USER->reset_password($_POST['reset_pass'],$_POST['new_pass'],0);
			$MVC->display_admin_manage();
	}else if($_POST['change_pass_admin']){
		$USER->reset_password($_POST[''],$_POST[''],1);
		$MVC->display_admin_manage();
	}else if($_POST['add_admin']){
		add_admin();
		$MVC->display_admin_manage();
	}else{
		$MVC->display_admin_manage();
	}
?>
