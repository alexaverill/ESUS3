<?php
include('header.php');
//$MVC->display_admin_manage();
$Verify=new Verification;
        $USER=new Users();
        if (isset($_POST['adduser'])){
                 $USER->add_user($_POST['username'],$_POST['passbox'],$_POST['email'],$_POST['schoolname']); 
                 $MVC->display('admin_manage_template.php');
        }else if(isset($_POST['teams'])){
                $USER->show_user_info($_POST['call']);
                $MVC->display('admin_manage_template.php');
        }else if(isset($_POST['change_pass'])){
                $USER->reset_password($_POST['reset_pass'],$_POST['new_pass'],0);
                $MVC->display('admin_manage_template.php');
        }else if(isset($_POST['change_pass_admin'])){
                $USER->reset_password($_POST[''],$_POST[''],1);
                $MVC->display('admin_manage_template.php');
        }else if(isset($_POST['add_admin'])){
                $USER->add_admin($_POST['username'],$_POST['passbox']);
                $MVC->display('admin_manage_template.php');
        }else if(isset($_POST['up'])){
                $USER->upload($_FILES['uploadedfile']['name'],$_FILES['uploadedfile']['tmp_name']);
                $MVC->display('admin_manage_template.php');
        }else{
                $MVC->display('admin_manage_template.php');
        }
?>
