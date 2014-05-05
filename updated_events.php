<?php
require('database.php');
try{
    $dbh= new PDO('mysql:host='.$data_host.';dbname='.$name_database,$data_username,$data_password);
}catch(PDOException $e){
    echo $e->getMessage();
}
$id = $_POST['id'];
$value = $_POST['value'];
$sql="UPDATE event SET event=? WHERE event=?";
$run=$dbh->prepare($sql);
$run->execute(array($value,$id));
$get="SELECT * FROM `times` WHERE `time_id`='$id'";

$changeall="UPDATE times SET event=? WHERE event=?";
$go=$dbh->prepare($changeall);
$go->execute(array($value,$id));
echo $value;
?>