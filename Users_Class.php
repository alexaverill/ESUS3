<?php 
class Users {
    
    
    public $user_id=0; //Controls User ID for all people. Defualts to zero modified by login only.
    
    public function login($user,$password){
        global $dbh;
        global $install;
        global $VALID;
        try{
    
            $sql='SELECT * FROM team WHERE username=?';
            $query_user=$dbh->prepare($sql);
            $user=$VALID->sant_string($user);
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
                $_SESSION['admin']=false;
                $_SESSION['user']=true;
                $_SESSION['id']=$this->get_id($user);
                echo 'You have logged in!';
        }else{
            //TODO:Log wrong login to a login file.
            echo 'Wrong Username or passord';
        }
        
    }
    
    //User Admin Functions.
    public function add_user($user,$password,$email,$name){
        global $dbh;
        $VERIFY=new Validation();
        $check_admin = "SELECT * FROM `members` WHERE rank = '1'";
	$qry_admin = mysql_query($check_admin) or die ("Could not match data because ".mysql_error());
	while($ren= mysql_fetch_assoc($qry_admin)) {
		$admin_email = $ren['email'];			//Gets the admin email to post when adding contact info. 
	}
        if($VERIFY->valid_email($email)){
            $email=$email;
        }else{
            $email='0';
            return false;
        }
	$mpass = $password;
	$password =  crypt($password);
            

	$check= "SELECT * FROM `team` WHERE `name` = ? OR `user`=?";
        $run_check=$dbh->prepare($check);
        $run_check->execute(array($name,$user));
        $num_rows=$run_check;
	$num_rows = mysql_num_rows($qry);
	if ($num_rows > 0) {
		echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
	}else if($row_schools > 0){
		echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
	}else{
                $add_team=$dbh->prepare("INSERT INTO team(id,name,email,username)VALUES(NULL,?,?,?,?)");
                $add_team->execute(array($name,$email,$user,$password));
		echo 'Please send this info to the team:<br/>';
		echo 'The following is your login information for ' .$name.'. If you have any issues please contact '.$admin_email.'<br/>';
		echo 'Username: ' .$user.'<br/>';
		echo 'Password: ' .$mpass. '<br/>';

	}
    }
    public function remove_user(){
	
    }
    public function show_user_info($user){
        global $dbh;
        $sql = "SELECT * FROM `team` WHERE `username`=?";
	//echo $sql;
	$get_user=$dbh->prepare($sql);
        $get_user->execute(array($user));
	echo '<form method="POST" action="">';
	while($row = $get_user->fetch(PDO::FETCH_ASSOC)) {
		echo 'ID: '.$row['id'].'<br/>';
		echo 'Name: <input type="text" value="'.$row['name'].'" name="name"/><br/>';
		echo 'Email: <input type="text" value="'.$row['email'].'" name="email"/><br/>';
		echo 'Username: <input type="text" value="'.$row['username'].'" name="username"/><br/>';
		echo '<input type="hidden" value="'.$row['id'].'" name="id"/>';
		echo '<input type="submit" name="save" value="Save"/>';
	}
	echo '</form>';
	echo 'Please use Manage Users page to reset passwords.';
    }
    public function update_team($id,$name,$email,$user){
        global $dbh;
	$sql = "UPDATE team SET name=?,email=?,username=? WHERE id=?;";
	$update=$dbh->prepare($sql);
        $update->execute(array($name,$email,$user,$id));
	echo 'User Updated.';
    }
    public function reset_password($user,$password){
        global $dbh;
	$write_pass=$password;
	$password =  crypt($password);
	$user=mysql_real_escape_string($user);
	$sql = $dbh->prepare("UPDATE `team` SET `password` = ? WHERE `username` =?;");
	if(strlen($password)!=0){
           $set->execute(array($password,$user));
            echo '<h3>Password Changed to '.$write_pass.'</h3>';
	}else{
		echo 'You must enter a username and password.';
	}
    }
    public function return_select_option_user($type){
        global $dbh;
        $html=' ';
        $get_users="SELECT * FROM `team` ORDER BY `name` ASC";
        $query=$dbh->query($get_users);
        foreach($query as $team){
            switch($type){
                case 1:
                    $html.='<option value="'.$team['username'].'">'.$team['name'].'</option>';
                    break;
                case 2:
                    $html.='<option value="'.$team['username'].'">'.$team['name'].'</option>';
                    break;
                default:
                    $html.='<option value="'.$team['username'].'">'.$team['name'].'</option>';
                    break;
            
            }
        }
        return $html;
    }
    public function get_id($name){
        global $dbh;
        $sql="SELECT * FROM team WHERE name=?";
        $get_id=$dbh->prepare($sql);
        $get_id->execute(array($name));
        $row=$get_id->fetchAll(PDO::FETCH_ASSOC);
        $id=$row['id'];
        return $id;
    }
    public function get_email($name){
        global $dbh;
        $sql="SELECT * FROM team WHERE name=?";
        $get_email=$dbh->prepare($sql);
        $get_email->execute(array($name));
        $row=$get_email->fetchAll(PDO::FETCH_ASSOC);
        $email=$row['email'];
        return $email;
    }
    public function get_all_events($id){
    //Get all the teams slots that they are holding, and return a string as a message Used to send emails.
        global $dbh;
        //global $slots; //Global due to the fact that it is going to be set as a hard max in the database.php. really should be ten
        $slots=10;
	$EVENT=new Events();
	$message='';
        $get_events_qry="SELECT * FROM times";
        $get_events=$dbh->query($get_events_qry);
        foreach($get_events->fetchAll() as $event_info){
	    for($x=1;$x<$slots;$x+=1){
		$place='team'.$x;
		if($event_info[$place]==$id){
		    $message.='You have '.$event_info['event'].' at '.$event_info['time_id'];
		}
	    }
	}
	return $message;
    }
}
?>