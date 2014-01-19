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
}
$VALID=new Validation();
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
    public function claim_slot($id,$event,$time){
        echo $event;
	//Function used to claim slots in database will be called on index.php
        //Insert SQL
        $insert_sql="UPDATE times SET ?=? WHERE event=? AND time_id=?";
        echo 'HI';
        
    }
    public function drop_slot(){
	//WIll remove a teams slots from the database
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
        $number = $middle[0][slots];
        return $number;
    }
}

class Events{
    public function add_events($event){     //INitial add to database.
        //verify it does not exist
        global $dbh;
        $checking=$dbh->prepare("SELECT * FROM event WHERE event=?");
        $checking->execute(array($event));
        $row=$checking->rowCount();
        $add_to=$dbh->prepare("INSERT INTO event (event) VALUES (?)");
        if($row==0){
            $add_to->execute(array($event));
            return 0;
        }else{
            return 1;
        }
    }
    public function add_events_at($event,$time){        //Add slot at a time to an event.
        global $dbh;
        $checking=$dbh->prepare("SELECT * FROM times WHERE time_id=? AND event=?");
        $checking->execute(array($time,$event));
        $rows=$checking->rowCount();
        if($rows==0){
            try{
            $add_event=$dbh->prepare("INSERT INTO times (time_id, event) VALUES (?,?)");
            $add_event->execute(array($time,$event));
            return 0;
            }catch(PDOException $ex){
                echo $ex;
                return 0;
            }
        }else{
            return 1;
        }
        
    }

    public function remove_events(){
        
    }
    public function list_events(){
        global $dbh;
        foreach($dbh->query('SELECT * FROM event') as $row) {
            echo $row['event'].'<Br/>'; 
        }
    }
    public function event_checkbox(){
        $html='';
        global $dbh;
        foreach($dbh->query('SELECT * FROM event') as $row) {
            $html .= '<input id="'.$row['event'].'" type="checkbox" name="check_list[]" value="'.$row['event'].'"/><label for="'.$row['event'].'">'.$row['event'].'</label>'; 
        }
        return $html;
    }
    public function events_to_display(){
        global $dbh;
        foreach($dbh->query('SELECT * FROM times ORDER BY event ASC') as $row) {
            $event_array[]=$row['event'];
            $time_array[]=$row['time_id'];
        }
        //var_dump($array);
        $array=array($event_array,$time_array);
        return $array;
    }
    public function event_status($event,$slot){
        global $dbh;
        $SLOTS=new Slots();
        $total_slots=$SLOTS->number_of_slots($event);   //Gets total number of slots in each event.
        //get current number of filled slots and subtract it from total slots to get number left.
        $sql="SELECT * FROM times WHERE time_id=? AND event=?";
        $pull = $dbh->prepare($sql);
        $pull->execute(array($slot,$event));
        $rows=$pull->fetchAll(PDO::FETCH_ASSOC);
        $index=1;
        $taken=0;
        while($index<$total_slots){
            if($rows[0]['team'.$index]!=0){
                $taken+=1;
            }
            $index+=1;
        }
        
        $final=$taken.' of '.$total_slots;
        return $final;
    }
    public function return_event_html(){
        //Returns HTML code for the event table, I wish there were a better way, but ther is not really as I can see...
        
        global $dbh;
        $html='';
        foreach($dbh->query("SELECT * FROM event") as $event){
            $sql='SELECT * FROM times WHERE event=$event';
            $go=$dbh->prepare('SELECT * FROM times WHERE event=?');
            $html.='<table><h2>'.$event['event'].'</h2>';
            $html.='<tr> <th>Hour</th>';
            $html.='<th>Obtain</th><th>Status</th>';
            $get_times=$dbh->prepare('SELECT time_id FROM times WHERE event=?');
            $get_times->execute(array($event['event']));
            while($time=$get_times->fetchAll(PDO::FETCH_ASSOC)){
                 $html.='<tr><td>'.$time[0][time_id];
                 $html.='<td><form method="POST" action=""><input type="hidden" value="'.$time[0][time_id].'" name="time"/><input type="hidden" value="'.$event['event'].'" name="event"/><input type="submit" name="getthis" class="table_btn" value="Get this time"/></form>';
                 $html.='<td>'.$this->event_status($event['event'],$time[0][time_id]).'</td></tr>';
            }
             $html.= '</table>';
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
        echo $today->format('c');
        $sql="SELECT start,end,st_time,en_time FROM timer WHERE id=1";
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
    /*MVC functions to get timer and display it*/
    public function display_timer(){
        global $dbh;
        //$html='';
        $sql="SELECT start,end,st_time,en_time FROM timer WHERE id=1";
        foreach($dbh->query($sql) as $row){
             echo 'Start Date: '.$row['start'].' at '.$row['st_time'].'<br/>End Date: '.$row['end'].' at '.$row['en_time'];
        }
        //return $html;
    }
    public function admin_timer_form(){
        $html=file_get_contents('templates/admin_timer_teplate.php');
        return $html;
    }
    public function display_events(){
        $EVENTS= new Events();
        $html = $EVENTS->return_event_html();
        echo $html;
        
    
    }
    public function display_admin_adding(){
        /*$html=file_get_contents('templates/admin_adding_template.php');
        return $html;*/
        include('templates/admin_adding_template.php');         //Using an include since it has php code I want to execute.I need to reasearch more templating.
    }
    
}
?>