<?php 
class Users {
    public function login($user,$password){
        global $dbh;
        global $install;
        global $VALID;
        try{
    
            $sql='SELECT * FROM team WHERE username=?';
            $query_user=$dbh->prepare($sql);
            $user=$VALID->sant_string($user);
            $query_user->execute(array($user));
	    //echo $query_user->rowCount();
	    if($query_user->rowCount()>0){
		$user_information= $query_user->fetchAll(PDO::FETCH_ASSOC);
		$admin=false;
	    }else{
		
		$sql='SELECT * FROM members WHERE name=?';
		$query_user=$dbh->prepare($sql);
		$user=$VALID->sant_string($user);
		$query_user->execute(array($user));
		$user_information= $query_user->fetchAll(PDO::FETCH_ASSOC);
		$admin=true;
	    }
            //print_r($user_information[0][id]);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
        //Compare stored Password to input password
        $stored_password=$user_information[0]['password'];
        if(password_verify($password,$stored_password)){
            //TODO:Log user login to file.
            	$_SESSION['name']=$user; 
		$_SESSION['install']=$install;
		$_SESSION['id']=$this->get_id($user,'name');
		if(!$admin){
		    $_SESSION['admin']=false;
		}else{
		    $_SESSION['admin']=true;
		}
		$_SESSION['user']=true;
                echo '<META HTTP-EQUIV=Refresh CONTENT=".5; URL=index.php">';
                echo '<h2>You have logged in!</h2>';
        }else{
            $log=new Logging();
	    $IP = $_SERVER['REMOTE_ADDR'];
	    $log->add_entry("INVALID LOGIN:", "$user attempted to login and failed. IP: $IP");
            echo '<h2>Wrong Username or password</h2>';
        }
        
    }
    
    //User Admin Functions.
    public function add_user($user,$password,$email,$name){
        global $dbh;
	$log=new Logging();
        $VERIFY=new Validation();
	    $tempPass = $password;
	    $password =  password_hash($password,PASSWORD_DEFAULT);
	    $check= "SELECT * FROM `team` WHERE `name` = ? OR `user`=?";
	    $run_check=$dbh->prepare($check);
	    $run_check->execute(array($name,$user));
           $num_rows=$run_check->rowCount();
		if ($num_rows > 0) {
			echo "Sorry, the username ".$name." is already taken. Please try another users<br>";
		}else if($row_schools > 0){
			echo "Sorry, the School ".$user." is already taken. Please try another users<br>";
		}else{
		    try{
			$sql="INSERT INTO team(name,email,username,password) VALUES(?,?,?,?)";
			$add_team=$dbh->prepare($sql);
			$add_team->execute(array($name,$email,$user,$password));
			$log->add_entry($_SESSION['name'],"New team with name $name, has been added");
		    }catch(PDOException $e){
			echo 'There was an error.';
			
			$log->add_entry('ERROR:',$e->getMessage());
		    }
			echo 'Please send this info to the team:<br/>';
			echo 'The following is your login information for ' .$name.'. If you have any issues please contact '.$admin_email.'<br/>';
			echo 'Username: ' .$user.'<br/>';
			echo 'Password: ' .$tempPass. '<br/>';
			echo 'Email: '.$email.'<br/>';

		}
		//Log the addition of a user
    }
    public function add_admin($name,$password){
	//echo 'Adding admin';
	global $dbh;
	$log=new Logging();
	$name= stripslashes($name);
	$name = mysql_real_escape_string($name);
	$TempPass=$password;
	$password=stripslashes($password); //injection cleaner
	$password =  password_hash($password, PASSWORD_DEFAULT);
		echo '<br/> Please send this info to the admin:<br/>';
		echo 'Username: ' .$name.'<br/>';
		echo 'Password: ' .$TempPass. '<br/>';
		try{
		$insert = "INSERT INTO `members` (`name`, `password`) VALUES (?,?)";
		$add_admin=$dbh->prepare($insert);
		$add_admin->execute(array($name,$password));
		echo "<span class=\"success\">Your user account has been created!</span><br>";
		$log->add_entry($_SESSION['name'],"New account with name $name, has been added");
		}catch(PDOException $e){
		    echo 'There was an error.';
		   
		    $log->add_entry('ERROR:',$e->getMessage());
		}
    }
    public function remove_user($userid){
	global $dbh;
	$remove = "DELETE FROM team WHERE id=?";
	$removal = $dbh->prepare($remove);
	$removal->execute(array($userid));
	$log = new Logging;
	$message = "removed team with id $userid";
	$log->add_entry('ADMIN',$message);
	return true;
		//log removal of a user
    }
    public function show_user_info($user){
        global $dbh;
        $sql = "SELECT * FROM `team` WHERE `username`=?";
	$get_user=$dbh->prepare($sql);
        $get_user->execute(array($user));
		echo '<form method="POST" action="">';
		foreach( $get_user->fetchAll() as $row ){
			echo 'ID: '.$row['id'].'<br/>';
			echo 'Name: <input type="text" value="'.$row['name'].'" name="name"/><br/>';
			echo 'Email: <input type="text" value="'.$row['email'].'" name="email"/><br/>';
			echo 'Username: <input type="text" value="'.$row['username'].'" name="username"/><br/>';
			echo '<input type="hidden" value="'.$row['id'].'" name="id"/>';
			echo '<input type="submit" name="save_teams" value="Save"/>';
		} 
		echo '</form>';
	    
    }
    public function update_team($id,$name,$email,$user){
        global $dbh;
	$log=new Logging();
	try{
	    $log->add_entry($SESSION['name'],"Changing team with ID of $id to Name:$name, Email: $email, and username:$user");
	    $sql = "UPDATE team SET name=?,email=?,username=? WHERE id=?;";
	    $update=$dbh->prepare($sql);
	    $update->execute(array($name,$email,$user,$id));
	    return true;
	}catch(PDOException $e){
	    echo 'There was an error.'; 
            $log->add_entry('ERROR:',$e->getMessage());
	}
    }
    public function reset_password($user,$password,$type){		//general password reset function. 1 is admin, anything else is a normal user
									//It could be said to have one user table, but that makes other things harder.
		global $dbh;
		$write_pass=$password;
		$password =  password_hash($password,PASSWORD_DEFAULT);
		$user=mysql_real_escape_string($user);
		if($type==1){
			$sql = $dbh->prepare("UPDATE `members` SET `password` = ? WHERE `name` =?;");
		}else{
			$sql = $dbh->prepare("UPDATE `team` SET `password` = ? WHERE `username` =?;");
		}
		if(strlen($password)!=0){
				$sql->execute(array($password,$user));
				echo "<h3>Password for $user Changed to $write_pass </h3>";
		}else{
			echo $user;
			echo $password;
			echo 'You must enter a username and password.';
		}
		
	}
    public function return_check_teams(){
        global $dbh;
        $html='<div class="scroll_container">';
        $get_users="SELECT * FROM `team` ORDER BY `name` ASC";
        $query=$dbh->query($get_users);
        foreach($query as $team){
	     $html.='<label>'.$team['name'].'<input type="checkbox" name="team_checks[]" value="'.$team['email'].'"/></label><br/>';
        }
	$html .= '</div>';
        return $html;
    }
    public function return_select_option_user($type){
        global $dbh;
        $html=' ';
        $get_users="SELECT * FROM `team` ORDER BY `name` ASC";
        $query=$dbh->query($get_users);
        foreach($query as $team){
            switch($type){
                case 1:
                    $html.='<option value="'.$team['email'].'">'.$team['name'].'</option>';
                    break;
                case 2:
                    $html.='<option value="'.$team['username'].'">'.$team['name'].'</option>';
                    break;
                default:
                    $html.='<option value="'.$team['id'].'">'.$team['name'].'</option>';
                    break;
            
            }
        }
        return $html;
    }
    public function get_id($name,$type){
	/*
	 *Returns ID, type is either email or name
	 *defaults to name.
	 **/
        global $dbh;
	if($type=='email'){
	    $sql="SELECT * FROM team WHERE email=?";
	}else{
	    $sql="SELECT * FROM team WHERE username=?";
	}
        $get_id=$dbh->prepare($sql);
        $get_id->execute(array($name));
        $row=$get_id->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($row);
        $id=$row[0]['id'];
        return $id;
    }
    public function get_name($id){
        global $dbh;
        $sql="SELECT * FROM team WHERE id=?";
        $get_id=$dbh->prepare($sql);
        $get_id->execute(array($id));
        $row=$get_id->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($row);
        $name=$row[0]['name'];
        return $name;
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
		$message='Events: ';
        $get_events_qry="SELECT * FROM times";
        $get_events=$dbh->query($get_events_qry);
        foreach($get_events->fetchAll() as $event_info){
			for($x=1;$x<$slots;$x+=1){
				$place= 'team'.$x;
				if($event_info[$place]==$id){
					$message .= 'You have '.$event_info['event'].' at '.$event_info['time_id'];
				}
			}
		}
	return $message;
    }
    public function upload($name,$tmpName){						//Upload function for admin area excel files
	$target_path = "uploads/";
	$target_path = $target_path . basename($name); 
	if(move_uploaded_file($tmpName, $target_path)) {
	    //Moved file, no response due to trying to keep admin area simple
	    echo 'File moved to:'.$target_path;
	    $this->insert($target_path);
	} else{
	    echo "There was an error uploading the file, please try again!";
	}
	
	
	}
    public function insert($location){			//Addes uploaded Excel file data to database
	global $dbh;
	include('source/reader.php');
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($location);
		for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
		    $name = $data->sheets[0]["cells"][$x][1];
		    $username = $data->sheets[0]["cells"][$x][2];
		    $password = $data->sheets[0]["cells"][$x][3];
		    $email = $data ->sheets[0]["cells"][$x][4];
			$username=mysql_real_escape_string($username);
			$name = mysql_real_escape_string($name);
			$password = password_hash($password, PASSWORD_DEFAULT);
			$check = "SELECT * FROM `team` WHERE `name`=?"; //$name
		$qry = $dbh->prepare($check);
		$qry->execute(array($name));
		$check_two = "SELECT * FROM `team` WHERE `username`=?";
		$qry_two=$dbh->prepare($check_two);
		$qry_two->execute(array($username));
		$rows_schools= $qry_two->rowCount();
		$num_rows = $qry->rowCount();
		if ($num_rows > 0) {
			echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
		}else if($row_schools > 0){
			echo "Sorry, the username ".$user." is already taken. Please try another users<br>";
		}else{
		    $sql = "INSERT INTO team (name,email,username,password) VALUES (?,?,?,?)";
		    $add=$dbh->prepare($sql);
		    $add->execute(array($name,$email,$username,$password));
		}
		
	}
	unlink($location);
		echo 'Your file has been input into the database. Thank you.';
	}
}
?>
