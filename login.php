<?php include('header.php');
    $installString = $_GET['competition'];
    $Verify = new Verification();
    echo $MVC->display('login.php');
    if($_POST['submitted']){
        $installID=$Verify->returnInstallID($installString);
        $USER->login($_POST['user'],$_POST['pass'],$installID);
    }
?>
