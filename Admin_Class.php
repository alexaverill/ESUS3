<?php
class Admin_Class{

    public function addCompetion($competitionName,$username,$password,$timezone,$divNumber){
            //insert a new competition into setttings table
            //start by determining if it is one or two division
            if($divNumber ==1){
                    //there is only one competition and this is simple....
                    $installID = $this->insertCompetionDatabase($competitionName,$timezone);
                    $USER = new Users();
                    $USER->add_admin($username,$password,1,$installID);
            }else{
                    $compArray = [$competitionName.' B',$competitionName.' C'];
                    //loop through array and add in new competitions.
                    foreach ($compArray as $value) {
                            $installID = $this->insertCompetionDatabase($value,$timezone);
                            $USER = new Users();
                            $USER->add_admin($username,$password,1,$installID);
                    }
            }

            //competion admins will have permissions of 1
            //overall admin will have permissions of -1
            //teams permissions will be a 2

    }
    public function insertCompetionDatabase($competitionName,$timezone){
            global $dbh;
            $slotNum = 10; //defualt for now. may change in install.sql
            $installID = $this->returnInstallID();
            $query = "INSERT INTO settings(installID,timezone,slotNum,competitionName) VALUES(?,?,?,?)";
            $runQ = $dbh->prepare($query);
            $runQ->execute(array($installID,$timezone,$slotNum,$competitionName));
            return $installID;

    }
    private function returnInstallID(){
            //generate an InstallID based on last known ID.
            global $dbh;
            $query= "SELECT * FROM settings ORDER BY installID DESC LIMIT 1";
            $runQ = $dbh->prepare($query);
            $runQ->execute();
            $value = $runQ->fetchAll(PDO::FETCH_ASSOC);
            $lastId = $value[0]['installID'];
            if($lastId !=0){
                    return $lastId+=1;
            }
            return 1;
    }
    public function searchCompetitions($competionName){
             //search through database based on name.
             //also search with appending B or C if not found and not included

    }
}
