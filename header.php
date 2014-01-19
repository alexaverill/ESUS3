<?php
//Get Database info
session_start();
include('database.php');
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