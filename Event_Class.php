<?php
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
    public function number_slots($event){
        //return the number of slots in specified events
        global $dbh;
        $qry='SELECT * FROM event WHERE event=?';
        $run_qry=$dbh->prepare($qry);
        $run_qry->execute(array($event));
        foreach($run_qry->fetchAll() as $slots){
            $num_slots=$slots['slots'];                        
        }
        return $num_slots;
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
        $array=array($event_array,$time_array);
        return $array;
    }
    public function event_status($event,$slot){
        global $dbh;
        $SLOTS=new Slots();
        $total_slots=$this->number_slots($event);  //Gets total number of slots in each event.
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
            $get_times=$dbh->prepare('SELECT * FROM times WHERE event=?');
            $get_times->execute(array($event['event']));
           foreach($get_times->fetchAll() as $time){
                 $html.='<tr><td>'.$time[time_id].'</td>';
                 $html.='<td><form method="POST" action=""><input type="hidden" value="'.$time[time_id].'" name="time"/><input type="hidden" value="'.$event['event'].'" name="event"/><input type="submit" name="getthis" class="table_btn" value="Get this time"/></form>';
                 $html.='<td>'.$this->event_status($event['event'],$time[time_id]).'</td></tr>';
            }
             $html.= '</table>';
        }
        return $html;
    }
     public function return_table_adding(){
                global $dbh;
                $html='';
		$get_events_from_database="SELECT * FROM `event` ORDER BY `event` ASC";
		$query_db=$dbh->query($get_events_from_database);
		$html.='<div id="below">';//<
		$html.='<h2>Add Slots to an Event</h2>';
		
	foreach($query_db->fetchAll() as $get){
		$html.="<table border='1' style='float:left'>";
		$even=$get['event'];
		$sql = "SELECT * FROM `slots`"; 
		$get_times=$dbh->query($sql);
		$tblcl = "</td>";
		$html.='<tr><td><b>'.$even.'</b></td></tr>';
		$html.='<tr><td><form method="POST" action=""><input type="hidden" value="'.$even.'" name="event"/>
			<input type="submit" name="add_all" value="Add all Slots to this event"/></form></td></tr>';
                $html.='<form method="POST" action=""><input type="hidden" value="'.$even.'" name="event_checks"/>';
                $html.='<tr><td><input name="add_times" type="submit" value="Add Selected Slots"/></td></tr>';
                foreach($get_times->fetchAll() as $row){
                        $time=$row['time_slot'];
                            $query_slot_status="SELECT * FROM times WHERE event=? AND time_id=?";   //Check if already a slot
                            $magic_check=$dbh->prepare($query_slot_status);
                            $magic_check->execute(array($even,$time));
                            $num_check= $magic_check->rowCount();
                            if($num_check==0){
                                $html.='<td>'; 
                                $html.=$row['time_slot'].'<input type="checkbox" name="time_checks[]" value="'.$row['time_slot'].'"/>';
                                $html.='</tr>';
                            
                            }
                }
        
       $html.='</form>';
	$html.='</table>';
	}
       $html.='</table></div>';
       return $html;
    }
    function return_admin_table_html($event){
                global $dbh;
                $html='';
                    $sto= '<strong>';
                    $stc='</strong>';
                    $red = '<div id="red">';
                    $enred = '</div>';
                    $get_event_sql="SELECT * FROM `event` ORDER BY `event` ASC";
                    $get_events=$dbh->query($get_event_sql);
            echo "<table border='1'>"; foreach($get_events->fetchAll() as $get){
                    $event=$get['event'];
                    
                    

            $id=$_SESSION['id'];
                    $tblcl = "</td>";
                            echo "<table border='1'>";
                            echo '<h2 id="theevent">'.$event.'</h1>';
                            $menu=1;
                            $table_settings=$this->number_slots($event);
                            echo '<tr> <th>Hour</th>';
                            while ($menu<=$table_settings){
                                    echo '<th>Slot '.$menu.'</th>';
                                    $menu+=1;
                            }
            $sql = "SELECT * FROM times WHERE event=? ORDER BY time_id ASC";
            $get_times=$dbh->prepare($sql);
            $get_times->execute(array($event));
            foreach($get_times->fetchAll() as $row){
                    $time=$row['time_id'];
    
                            echo '<tr><td>'; 
                            echo $row['time_id'];
                            echo $tblcl;
                    
                    $team='team';
                    $run=1;
                            
                    while($run<=$table_settings){
                                    $team1=$team.$run;	
                                    if($row[$team1]==-1){
                                                    echo '<td id="closed">';
                                                    echo 'Closed';
                                            echo '<form method="POST" action="">
                                            <input type="hidden" value="'.$time.'" name="time"/>
                                            <input type="hidden" value="'.$team1.'" name="slot"/>
                                            <input type="hidden" value="'.$row['event'].'" name="event"/>
                                            <input type="hidden" value="'.$id.'" name="id"/>
                                            <input type="submit" name="getthis" class="table_btn" value="Reopen"/></form>';
                                                    echo  "</td></td>"; 
                                    }else{
                                            if($row[$team1]<=0){
                                                    echo '<td id="blue">';
                                                    echo 'Time Open';
                                                    echo "</td></td>"; 
                                            }else{
                                                    if($row[$team1] != 0){
                                                    echo '<td id="yellow">';
                                                    $id= $row[$team1];
                                                    $get ="SELECT * FROM `team` WHERE `id`=?";
                                                    $get_name=$dbh->prepare($get);
                                                    $get_name->execute(array($id));
                                                            foreach($get_name->fetchAll() as $name){}
                                                        
                                                                    echo $name['name'];
                                                            }
                                            echo '<form method="POST" action="">
                                            <input type="hidden" value="'.$time.'" name="time"/>
                                            <input type="hidden" value="'.$team1.'" name="slot"/>
                                            <input type="hidden" value="'.$row['event'].'" name="event"/>
                                            <input type="hidden" value="'.$id.'" name="id"/>
                                            <input type="submit" name="getthis" class="table_btn" value="Clear this"/></form>';
                                                            echo "</td></td>";
                                                    }
                                            echo "</td>";
                                            
                                    }
                                    
                                $run+=1;    
                            }
                            
                    }
            }
            return $html;
        }
        
    
    public function return_select_options(){
        global $dbh;
        $get_events="SELECT * ";
    }
}
?>