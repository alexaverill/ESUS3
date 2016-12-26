<?php
include('database.php');
include('classes.php');
class Admin{

    public addCompetion($competitionName,$username,$password,$timezone,$divNumber){
            //insert a new competition into setttings table
            //start by determining if it is one or two division

            //once division number is know we can then insert the rignt number of
            //competitons into settings.
            //for two divisions append a B and C to end of competion name.
            //else leave name alone.
            //once competition is added then use user class to add new admin username
            $USER = new Users();
            $USER->new_admin($username,$password,1);
            //competion admins will have permissions of 1
            //overall admin will have permissions of -1
            //teams permissions will be a 2

    }
    public searchCompetitions($competionName){
             //search through database based on name.
             //also search with appending B or C if not found and not included

    }
}
