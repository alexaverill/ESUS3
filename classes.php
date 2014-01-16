<?php
include('database.php');
class Verification{
    /* This class is used to determine or check certain parameters, such as login status, and rights, the state of the timer, and the
     * validity if esus is open or not, this was originally done inline, and as such was extremely messy.
     */
    
    public $user_rights=0; //Set defualt user rights to nothing, 1 is Admin, 2 is a normal user.
    public function is_admin(){
        if ($_SESSION['admin']){
            return true;
        }else{
            return false;
        }
    }
    public function is_user(){
        if($_SESSION['name']){
            return true;
        }else{
            return false;
        }
    }
    private function check_time(){ //will check to see if current date is within the saved dates. false means it is not in the time true means its withing the set time
	
	/*MUST FIRST REWRITE HOW TIME IS STORED, NEED TO USE MYSQL DATE TYPE, NOT STRING!
	*/
	return false;
    }
    public function is_open(){
	$time_status=$this->check_time();
	//pull enabled value from database/
	global $dbh;
	$sql='SELECT * FROM  `enable`';
	$query_enable_status=$dbh->query($sql);
	$query_enable_status=$query_enable_status->fetch(PDO::FETCH_ASSOC);
	$query_enable_status=$query_enable_status[enabled];
	if($query_enable_status==1){
	    return true;
	}else if($query_enable_status==2){
	    return false;
	}else if($this->check_time()){
	    return true;
	}else{
	    return false;
	}
    }
}
class Users {
    
    
    public $user_id=0; //Controls User ID for all people. Defualts to zero modified by login only.
    
    
    public function login($user,$password){
        global $dbh;
        global $install;
        try{
    
            $sql='SELECT * FROM team WHERE username=?';
            $query_user=$dbh->prepare($sql);
            $query_user->execute(array($user));
            $user_information= $query_user->fetchAll(PDO::FETCH_ASSOC);
            print_r($user_information[0][id]);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
        //Compare stored Password to input password
        $stored_password=$user_information[0][password];
        if(crypt($password,$stored_password)==$stored_password){
            //TODO:Log user login to file.
            	$_SESSION['name']=$user; 
		$_SESSION['install']=$install;
                $_SESSION['admin']==false;
                $_SESSION['user']==true;
                echo 'You have logged in!';
        }else{
            //TODO:Log wrong login to a login file.
            echo 'Wrong Username or passord';
        }
        
    }
    
    //User Admin Functions.
    public function add_user(){
        
    }
    public function remove_user(){
	
    }
    public function reset_password(){
	
    }
}

class Slots{
    /* $slots should end up being a global that is created in database.php thus allowing easy setup of wacky esus installs.
     * slots denotes total possible slots, not just the slots per event that is still pulled via the database, under event
     * and slot, that will have to be made sure to be set less then total slots.
     *
     * TODO. setup a maintanence scripts that will check the database in order to make sure that the total number of "team##" in the slots
     * database table is equal to or greater then the max slot setting in database.php
     * */
    public $slots=0;
    public function claim_slot(){
	
    }
    public function drop_slot(){
	
    }
}

class Admin{
    

    
}

class MVC{          //Create HTML code to be displayed. call user and admin classes and functions.
    
    
    
    public function display_menu(){ //Pull validation values, if admin, or if user, then display correct menu.
        //Admin
        global $VERIFICATION;
        /*if($VERIFICATION->is_admin()){
            include('templates/admin_menu.php');
        }*/
        //Users
        if($VERIFICATION->is_user()){
            include('templates/user_menu.php');
        }
    }
    
    
    public function display_login(){
        $html='<h1>Login</h1>
		<div class="user_info">
			<form method="POST" action="">
				<label for="user">Username</label><input type="text" name="user" size="25"/><br/>
				Password<input type="password" name="pass" size="25"/><br/>
				<input class="myButton" value="Login" type="submit" />
				<input type=hidden name=submitted value=1> 
			</form>
		</div>
	<div id="add_login">
		<a href="admin_login.php">Admin Login</a>
	</div>';
        return $html;
    }
    
    public function draw_events(){
        
    }
}
?>