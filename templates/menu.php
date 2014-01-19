
if(strlen($_SESSION['admin_name'])>1 && $_SESSION['install']==$install_value){
echo'<li><a href="index.php" class="menu_link">Team View</a></li>
	<!--<li><a href="admin.php" class="menu_link"> Admin Area</a></li>-->
	<li><a href="admin_manage.php" class="menu_link">Control  Users</a></li>
  <li><a href="team_manage.php" class="menu_link">Edit  Users</a></li>
	<li><a href="admin_mail.php" class="menu_link">Emailing</a></li>
	<li><a href="admin_addevent.php" class="menu_link">Control Events and Timer</a></li>
	<li><a href="admin_event.php" class="menu_link">View Events</a></li>';
          echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>';
}else if (strlen($_SESSION['name'])>1){
  echo'<li><a href="index.php" class="menu_link">Select Event Times</a></li>
    <li><a href="view.php" class="menu_link">View Your Event Times</a></li>';
      echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>'; 
}else if(strlen($_SESSION['name'])>1){
				echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>'; //</ul></div>
				}else if(strlen($_SESSION['admin_name'])>1){
					echo '<li><a href="logout.php" class="menu_link">Log Out</a></li>';
				}else{
				echo '<li><a href="login.php" class="menu_link">Login</a></li>';
				}	