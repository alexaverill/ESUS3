<?php include('header.php');
    echo $MVC->display('login.php');
     $USER->login('test',$_POST['pass']);
    if($_POST['submitted']){
        $USER->login($_POST['user'],$_POST['pass']);
    }
?>