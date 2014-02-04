<?php
include('header.php');
include('templates/admin_manage_template.php');
$USER=new Users();
if ($_POST['adduser'])
		{
                  $USER->add_user($_POST['user'],$_POST['password'],$_POST['email'],$_POST['email']);  
                }
    if($_POST['teams']){
        $USER->show_user_info($_POST['call']);
    }
	if($_POST['change_pass']){
            $USER->reset_password($_POST['reset_pass'],$_POST['new_pass']);
	}

	if($_POST['change_pass_admin']){
		admin_reset_password();
	}

	if($_POST['add_admin']){
		add_admin();
	}
?>