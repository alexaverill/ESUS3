<?php

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
	    if(file_exists($file_name)){
		if(! $this->determine_permissions($file_name)){
		    include($file_name);
		}else{
		    $verify = new Verification;
		    if($verify->is_admin()){
			include($file_name);
		    }else{
			include('templates/permissionError.php');
		    }
		}
	    }else{
		
		echo 'That template does not exist';
	    }
    }
    public function display($file_name){
	/*
	 *general purpose templating function. Can be either the general file name such as admin_mail, the full template name
	 *such as admin_mail_template,or admin_mail_template.php
	 *General purpose to make my life easier. Or harder. Best practice is full name but wanted to test the modularity.
	 **/
	//First if it has a php tag, we are going to assume that is the best way to go.
	if(strpos($file_name, '.php') !== false){
	    $full_name = 'templates/'.$file_name;
	    $this->include_template($full_name);
	}else if(strpos($file_name, 'template') !== false){
	    //lets just append a .php to see if that is a template
	    $full_name = 'templates/'.$file_name.'.php';
	     $this->include_template($full_name);
	}else{
	    //last chance to get it to appear.
	    $full_name = 'templates/'.$file_name.'_template.php';
	     $this->include_template($full_name);
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
    /*MVC functions to get timer and display it*/
    public function display_timer(){
        $html='<h2>Current Settings</h2>';
        $TIMER=new Timer();
        $html.='<h3>';
	$html.=$TIMER->return_timer_dates();
        $html .='</h3>';
        return $html;
    }
    public function display_events(){
        $Verify=new Verification;
        if($Verify->is_admin() || $Verify->is_user() ){
	    if ($Verify->is_open() || $Verify->is_admin()){
		$EVENTS= new Events();
		$html = $EVENTS->return_event_html();
		echo $html;
	    }else{
		$html="<h1>It is not yet time.</h2>";
		echo $html;
	    }
        }else{
	    $html="<h1>You are not logged in.</h1><h2><a href=login.php>Please login here</a></h2>";
	    echo $html;
	}
    
    }
    
    public function display_reset_password(){
        $USER=new Users();
        $options=$USER->return_select_option_user(2);
        $html= '<form action="" method="POST">Team:<select name="reset_pass">';
        $html.=$options;
        $html.='</select><br/>
	New Password: <input type="text" name="new_pass"/><br/>
	<input name="change_pass" type="submit" value="Change Password"/>
	</form>';
        return $html;
    }
    public function display_email_options($type){
        $USER=new Users();
        $options=$USER->return_select_option_user(1);
        $html= '<form action="" method="POST">Team:<select name="emails">';
        if($type==1){
            $html.=$options;
            $html.='</select><br/>';
            $html.='<input name="send_times" type="submit"  value="Send Emails"/>';
        }else{
            $html.=$options;
            $html.='</select><br/>';
            $html.=' <textarea name="message" id="emess" height="100px" width="15%"></textarea><br/>';
            $html.='<input name="send_msg" type="submit" value="Send Emails"/>';
        }
        
	$html.='</form>';
        return $html;
    }
    public function display_edit_teams(){
        $USER=new Users();
        $html='';
        $options=$USER->return_select_option_user(2);
        $html.= '<form action="" method="POST">Team:<select name="edit_team_list">';
	$html.=$options;
        $html.= '</select><input name="edit_teams" type="submit"  value="Show Team Data"/></form>';
        return $html;
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
    public function display_events_slots(){
        $EVENTS = new Events();
	$html = '';
       // $html='<h2>Current Event\'s Setup';
        $html.=$EVENTS->events_with_slots();
        return $html;
    }
}
?>