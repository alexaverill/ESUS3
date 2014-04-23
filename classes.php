<?php
include('database.php');
include('Event_Class.php');
include('Users_Class.php');
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
    public function is_open(){
        $timer=new Timer();
	$time_status=$timer->check_timer_status();
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
	}else if($time_status){
	    return true;
	}else{
	    return false;
	}
    }
}
class Validation{
    //Verify inputs are correct, and not a method of egress.
    public function sant_string($input){
        //THis will make sure that input is only a string of characters or numbers.
        $output=filter_var($input,FILTER_SANITIZE_SPECIAL_CHARS);
        $output=filter_var($output,FILTER_SANITIZE_STRING);
        return $output;
    }
    public function valid_id($input){
        $input=filter_var($input,FILTER_SANITIZE_NUMBER_INT);
        if(is_int($input)){
            return $input;
        }else{
            return false;
        }
    }
    public function valid_email($input){
        /*if(FILTER_VALIDATE_EMAIL($input)){
            return true;
        }else{
            return false;
        }*/
        return true;
    }
}
$VALID=new Validation();

class Logging{
    //Log Removal of teams
    //Removal of slots
    //Removal of teams from slots
    //Log admin logins
    //Timestamps
    public function time_stamp(){
		$time= date("m-d-Y H:i:s");
		return $time;
	}
    public function add_entry($user,$message){
		//pass user and what happened to the log function
		//this function will add timestamp, and write to a file
		$file = fopen('logging.txt', 'a');
		$stamp=$this->time_stamp();
		$write=$stamp.' '.$user. ' '.$message."\n";
		fwrite($file,$write);
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
    public $slots=10;
    public function remove_held($event,$id){        //User function that clears slots when user claims a new slot
                global $dbh;
                //Loop through and drop all slots held by Id in the event;
                echo $event;
        $dropping_held=$dbh->prepare("SELECT * FROM times WHERE event=?");
        $dropping_held->execute(array($event));
        
        foreach($dropping_held->fetchAll() as $remove){
            $index=1;
            $time=$remove['time_id'];
            while($index<$this->slots){
                $place='team'.$index;
                if($remove[$place]==$id){
                     $insert_sql="UPDATE times SET ".$place."=0 WHERE event=? AND time_id=?";
                     $remove_query=$dbh->prepare($insert_sql);
                     $remove_query->execute(array($event,$time));
                     //break;
                }
                $index+=1;
            }
        }
    }
    public function clear_slot($event,$time,$slot,$team){
        global $dbh;
        $Log= new Logging;
        $clear_sql="UPDATE `times` SET ".$slot."=0 WHERE event=? AND time_id=?";
        $clear_qry=$dbh->prepare($clear_sql);
        $clear_qry->execute(array($event,$time));
	$user=new Users;
	$name=$user->get_name($team);
        $message="Dropped $team ($name) from $event at $time in slot: $slot"; //team is in the form of team ID #
        $Log->add_entry($_SESSION['name'],$message);
    }
    
    public function claim_slot($id,$event,$time){
        global $dbh;
	//Function used to claim slots in database will be called on index.php
        $team1='Hello';
        $get_query=$dbh->prepare("SELECT * FROM times WHERE event=? AND time_id=?");
        $get_query->execute(array($event,$time));
        $row=$get_query->fetchAll(PDO::FETCH_ASSOC);
        $index=1;
        while($index<$this->slots){
            $place='team'.$index;
            if($row[0]['team'.$index]==0){
                $this->remove_held($event,$id);
                $insert_sql="UPDATE times SET ".$place."=? WHERE event=? AND time_id=?";
                $sql=$dbh->prepare($insert_sql);
                $sql->execute(array($id,$event,$time));
                $status=true;
                break;
            }
            $index++;
        }
        if($status){
            return 0;
        }else{
            return 1;
        }
    }
    public function drop_slot(){
	//WIll remove a teams slots from the database
    }
    public function change_num_slots($event,$slots){
        global $dbh;
        $sql="UPDATE event SET slots=? WHERE event=?";
        $update=$dbh->prepare($sql);
        $update->execute(array($slots,$event));
    }
    //Admin Slot functions
    public function add_slots($time){       //Inserts a slot into the time table in the database.
        global $dbh;
        global $VALID;
        $check=$dbh->prepare("SELECT * FROM slots WHERE time_slot=?");
        $time=$VALID->sant_string($time);
        $check->execute(array($time));
        $rows=$check->rowCount();
        if($rows==0){
            $send=$dbh->prepare("INSERT INTO slots(time_slot) VALUES(?)");
            $send->execute(array($time));
            return 0;
        }else{
            return 1;
        }
        
    }
    public function number_of_slots($event){        //Returns total number of slots for an event, not the number taken
        global $dbh;
        $sql= "SELECT slots FROM event WHERE event=?";
        $get_slots=$dbh->prepare("SELECT slots FROM event WHERE event=?");
        $get_slots->execute(array($event));
        $middle = $get_slots->fetchAll(PDO::FETCH_ASSOC);
        $number = $middle[0]['slots'];
        return $number;
    }
    public function return_all_slots_editable(){
    	global $dbh;
        $sql2 = "SELECT * FROM `slots` ORDER BY `time_slot` ASC ";
	$count=mysql_query($sql2);
        $get_slots=$dbh->query($sql2);
        $html='';
        foreach($get_slots->fetchAll() as $row){
        	$ids = $row['time_slot'];
	        $html.='<div class="edit_time" id="'.$ids.'">'.$row['time_slot'].'</div>';
        }
        return $html;
    }
}


class Admin{
    

    
}
class Timer{
    public function check_timer_status(){   //Determine what the timer status is will return a boolean true=open false=closed.
        global $dbh;
        global $timezone;
        date_default_timezone_set($timezone);       //INSTALL CONFIG TIME ZONE!!!
        $today= new DateTime('NOW');
        //echo $today->format('c');
        $sql="SELECT * FROM timer";
        foreach($dbh->query($sql) as $row){
             $start_date=$row['start'];
             $start_time=$row['st_time'];
             $end_date=$row['end'];
             $end_time=$row['en_time'];
        }
        //Check to see if dates are similar...
        $start_date=$start_date.'T'.$start_time;        //Append time to end of date string
        $end_date=$end_date.'T'.$end_time;
        $start_date=new DateTime($start_date);      //Create it as a date time
        $end_date=new DateTime($end_date);      
        if($start_date<$today && $end_date>$today ){    //Compare date times.
            return true;
        }else{
            return false;
        }
    }
    public function update_timer($start_date,$end_date,$start_time,$end_time){
        global $dbh;
        try{
            $sql="UPDATE timer SET start=? end=? st_time=? en_time=? WHERE id=?";
            $update= $dbh->prepare("UPDATE timer SET start=?, end=?, st_time=?, en_time=? WHERE id=?");
            $update->execute(array($start_date,$end_date,$start_time,$end_time,1));
            $affected_rows = $update->rowCount();
            echo $affected_rows;
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
    public function change_type($type){
        global $dbh;
        $sql="UPDATE `enable` SET `enabled`=?";
        $update=$dbh->prepare($sql);
        $update->execute(array($type));
        
    }
    public function return_timer_dates(){
		global $dbh;
		$html='';
		$sql="SELECT * FROM timer";
		$dates=$dbh->query($sql);
		$dates=$dates->fetchAll(PDO::FETCH_ASSOC);
		$html.='Opens on '.$dates[0]['start'].' at '.$dates[0]['st_time'];
		$html.='<br/>';
		$html.='Closes on '.$dates[0]['end'].' at '.$dates[0]['en_time'];
                return $html;
	}
}
class Mail {
    public function send_team_times($team){
        $USER=new Users();
        $id=$USER->get_id($team,'email');
        $message=$USER->get_all_events($id);
        $subject="Your Event Times.";
        $this->send_email($team,$subject,$message);
    }
    public function send_all_times(){
        global $dbh;
        $sql="SELECT * FROM team";
        $get_teams=$dbh->query($sql);
        foreach($get_teams->fetchAll() as $team){
            $this->send_team_times($team['email']);
        }
    }
    public function send_email($to,$subject,$message){
	$from = 'ESUS@esus.us';
        $final_subject='ESUS :'.$subject;
        $send=mail($to,$subject,$final_message);
    }
    function upload_for_bulk($message,$name,$tmpName){						
        $target_path = "uploads/";
        $message= $_POST['message'];
        $target_path = $target_path . basename($name); 
        if(move_uploaded_file($tmpName, $target_path)) {
                echo 'File Uploaded';
        } else{
            echo "There was an error uploading the file, please try again!";
        }
        $this->send_bulk_mail($target_path,$message);
        
    }
    public function send_bulk_mail($location,$message){	
        include('source/reader.php');	
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($location);
        
        for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
                    $name = $data->sheets[0]["cells"][$x][1];
                    $username = $data->sheets[0]["cells"][$x][2];
                    $password = $data->sheets[0]["cells"][$x][3];
                    $email = $data ->sheets[0]["cells"][$x][4];
                    //$email_message = $data ->sheets[0]["cells"][1][5];
              $username=mysql_real_escape_string($username);
              $link =  'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
              $email_message= $message.'    Name: '.$name.' Username: '.$username.' Password: '.$password; //Esus Link: '.$link.'
              $email_from = 'esus@sciolyeventsignup.com';
              $email_to=$email;
              $email_subject= "Event Sign Up System";
              $headers = 'From: '.$email_from."\r\n".
              'Reply-To: '.$email_from."\r\n" .
              'X-Mailer: PHP/' . phpversion();
              $send=mail($email_to, $email_subject, $email_message, $headers); 
            if($send){
              $sent=1;
              }
              //echo '<b>Email Sent to '.$row['name'].'</b><br/>';
        }
        unlink($location);
	echo 'Your emails have been sent. Thank you.';
}
}


class MVC{          //Create HTML code to be displayed. call user and admin classes and functions.
    private function determine_permissions($file_name){
	/*
	 * Function to return true if admin page, and require admin perms to include, otherwise return false
	 * based on page name. admin_ prefix
	 **/
	if(strpos($file_name, 'admin_') !== false){
	    return true;
	}else{
	    return false;
	}
	
    }
    private function include_template($file_name){
	    if(file_exists($full_name)){
		if(!determine_permissions($file_name)){
		    include($full_name);
		}else{
		    $verify = new Verification;
		    if($verify->is_admin()){
			include($full_name);
		    }else{
			echo 'Incorrect Permissions.';
		    }
		}
	    }else{
		echo 'That template does not exist';
	    }
    }
    public function diplay($file_name){
	/*
	 *general purpose templating function. Can be either the general file name such as admin_mail, the full template name
	 *such as admin_mail_template,or admin_mail_template.php
	 *General purpose to make my life easier. Or harder. Best practice is full name but wanted to test the modularity.
	 **/
	//First if it has a php tag, we are going to assume that is the best way to go.
	if(strpos($file_name, '.php') !== false){
	    $full_name = 'templates/'.$file_name;
	    include_template($file_name);
	}else if(strpos($file_name, 'template') !== false){
	    //lets just append a .php to see if that is a template
	    $full_name = 'templates/'.$file_name.'.php';
	    include_template($file_name);
	}else{
	    //last chance to get it to appear.
	    $full_name = 'templates/'.$file_name.'_template.php';
	    include_template($file_name);
	}
	
    }
    
    
    public function display_menu(){ //Pull validation values, if admin, or if user, then display correct menu.
        global $VERIFICATION;
        if($VERIFICATION->is_admin()){
            include('templates/admin_menu.php');
        }else if($VERIFICATION->is_user()){
            include('templates/user_menu.php');
        }else{
            include('templates/general_menu.php');
        }
    }
    public function display_slots_editable(){
        $SLOTS=new Slots();
        $html='<h2>Edit Slots</h2>';
        $html.=$SLOTS->return_all_slots_editable();
        return $html;
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
    /*MVC functions to get timer and display it*/
    public function display_timer(){
	global $VERIFICATION;
        $html='<h2>Current Settings</h2>';
        $TIMER=new Timer();
        $html.='<h3>';
	if($VERIFICATION->is_admin()){
	    $html.=$TIMER->return_timer_dates();
	}else{
	    $html.="Permission Error.";
	    
	}
        $html .='</h3>';
        return $html;
    }
    public function display_admin_manage(){
	global $VERIFICATION;
	    if($VERIFICATION->is_admin()){
		include('templates/admin_manage_template.php');
	    }else{
		include('templates/permissionError.php');
	    }
	}
    public function admin_timer_form(){
    global $VERIFICATION;
	if($VERIFICATION->is_admin()){
            include('templates/admin_timer_teplate.php');
	}else{
	    include('templates/permissionError.php');
	}
    }
    public function display_events(){
        $Verify=new Verification;
        if($Verify->is_admin()||$Verify->is_user()){
            $EVENTS= new Events();
            $html = $EVENTS->return_event_html();
            echo $html;
        }else{
	    $html="<h1>You are not logged in.</h1><h2><a href=login.php>Please login here</a></h2>";
	    echo $html;
	}
    
    }
    public function admin_mail(){
	global $VERIFICATION;
	if($VERIFICATION->is_admin()){
	    include('templates/admin_mail_template.php');
	}else{
	    include('templates/permissionError.php');
	}
    }
    
    public function display_reset_password(){
        $USER=new Users();
        $options=$USER->return_select_option_user(1);
        $html= '<form action="" method="POST">Team:<select name="reset_pass">';
        $html.=$options;
        $html.='</select><br/>
	New Password: <input type="text" name="new_pass"/><br/><input name="change_pass" type="submit" class="myButton" value="Change Password"/>
	</form>';
        return $html;
    }
    public function display_email_options($type){
        $USER=new Users();
        $options=$USER->return_select_option_user(2);
        $html= '<form action="" method="POST">Team:<select name="emails">';
        if($type==1){
            $html.=$options;
            $html.='</select><br/>';
            $html.='<input name="send_times" type="submit" class="myButton" value="Send Emails"/>';
        }else{
            $html.=$options;
            $html.='</select><br/>';
            $html.=' <textarea name="message" id="emess" height="100px" width="15%"></textarea><br/>';
            $html.='<input name="send_msg" type="submit" class="myButton" value="Send Emails"/>';
        }
        
	$html.='</form>';
        return $html;
    }
    public function display_edit_teams(){
        $USER=new Users();
        $html='';
        $options=$USER->return_select_option_user(1);
        $html.= '<form action="" method="POST">Team:<select name="call">';
	$html.=$options;
        $html.= '</select><input name="teams" type="submit" class="myButton" value="Show Team Data"/></form>';
        return $html;
    }
    public function display_admin_adding(){
        /*$html=file_get_contents('templates/admin_adding_template.php');
        return $html;*/
        include('templates/admin_adding_template.php');         //Using an include since it has php code I want to execute.I need to reasearch more templating.
    }
    public function table_adding_slots(){
        $EVENTS=new Events();
        return $EVENTS->return_table_adding();
    }
    public function display_admin_event_table(){
        $EVENTS= new Events();
        $EVENTS->return_admin_table_html();
    }
    public function display_slots_table(){
        $EVENT = new Events();
        $html='<h2>Change Number of Slots</h2>';
        $html.=$EVENT->return_event_slots();
        return $html;
    }
    public function admin_edit_slots(){
	global $VERIFICATION;
	if($VERIFICATION->is_admin()){
	    include('templates/admin_edit_template.php');
	}else{
	    include('templates/permissionError.php');
	}
    }
    public function display_events_slots(){
        $EVENTS = new Events();
       // $html='<h2>Current Event\'s Setup';
        $html.=$EVENTS->events_with_slots();
        return $html;
    }
    public function display_maintenence(){
	include('templates/maintenence_template.php');
    }
}
?>
