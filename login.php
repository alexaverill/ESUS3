<?php include('header.php');
    echo $MVC->display('login.php');
    if($_POST['submitted']){
        $USER->login($_POST['user'],$_POST['pass']);
    }
?>