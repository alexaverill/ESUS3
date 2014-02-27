<?php
//Get Database info
session_start();
include('database.php');
if (version_compare(phpversion(), '5.5.0', '<')) {
    //If the php Version is not supporting password hash, lets include it
    require('source/lib/password.php');
}
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
//Get Classes File
include('classes.php');
//Class Declarations for large scale classes
$MVC= new MVC();
$VERIFICATION= new Verification();
$USER=new Users();
include('templates/head_html.php');
?>