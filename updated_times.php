<?php
require('database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$text = mysql_escape_string($_GET['text']);
$id = mysql_escape_string($_GET['id']);
$orig= mysql_escape_string($_GET['old']);
$id = $_POST['id'];
$value = $_POST['value'];
$sql="UPDATE slots SET time_slot=? WHERE time_slot=?";
$run=$dbh->prepare($sql);
$run->execute(array($value,$id));
$get="SELECT * FROM `times` WHERE `time_id`='$id'";

$changeall="UPDATE times SET time_id=? WHERE time_id=?";
$go=$dbh->prepare($changeall);
$go->execute(array($value,$id));
echo $value;
?>