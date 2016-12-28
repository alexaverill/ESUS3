<?php
include('header.php');
$Verify=new Verification;
$USER=new Users();
$ADMIN= new Admin_Class();
if (isset($_POST['addcomp'])){
        $divNumber = 0;
        //Increment div number for throwing to admin class -> add competion
        if($_POST['divB'] == 'b'){
                $divNumber +=1;
        }
        if($_POST['divC'] == 'c'){
                $divNumber +=1;
        }
        echo $divNumber;
        $ADMIN->addCompetion($_POST['compname'],$_POST['username'],$_POST['passbox'],$_POST['timezone'],$divNumber);
}
$MVC->display('admin_master_template.php');

if (isset($_POST['updateCompetition'])){
}
?>
