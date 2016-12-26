<?php
include('database.php');
include('classes.php');
class Admin{

    public addCompetion($competitionName,$username,$password,$timezone,$divNumber){
            //insert a new competition into setttings table
            //start by determining if it is one or two division
            if($divNumber ==1){
                    //there is only one competition and this is simple....
                    $installID = insertCompetionDatabase($competitionName,$timezone);
                    $USER = new Users();
                    $USER->new_admin($username,$password,1,$installID);
            }else{
                    $compArray = [$competitionName.' B',$competitionName.' C']
                    //loop through array and add in new competitions.
                    foreach ($compArray as $value) {
                            $installID = insertCompetionDatabase($value,$timezone);
                            $USER = new Users();
                            $USER->new_admin($username,$password,1,$installID);
                    }
            }

            //competion admins will have permissions of 1
            //overall admin will have permissions of -1
            //teams permissions will be a 2

    }
    private insertCompetionDatabase($competionName,$timezone){
            global $dbh;
            $installID = returnInstallID();
            $query = "INSERT INTO settings(installID,timezone,slotNum,competionName) VALUES(?,?,?,?)";
            $runQ = $dbh->prepare($query);
            $runQ->execute(array($installID,$timezone,$slotNum,$competionName));
            return $installID;

    }
    private returnInstallID(){
            //generate an InstallID based on last known ID.
            global $dbh;
            $query= "SELECT * FROM settings ORDER BY installID ASC LIMIT 1";
            $runQ = $dbh->prepare($query);
            $runQ->execute();
            $value = $runQ->fetchAll(PDO::FETCH_ASSOC);
            $lastId = $value[0]['installID'];
            if($lastId !=0){
                    return $lastId+=1;
            }
            return 1;
    }
    public searchCompetitions($competionName){
             //search through database based on name.
             //also search with appending B or C if not found and not included

    }
}
