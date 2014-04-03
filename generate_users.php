<?php include('header.php');?>
	<h2>Username Generator</h2>
	<form method="POST" action="">
		Prefix:<select name="division">
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="Team">Team</option>
				</select>
		Number of Users:<input type="text" name="number_users">
		<input type="Submit" name="add_rand_pass" value="Generate Usernames">
	</form>
<?php
if($_POST['add_rand_pass']){
	$needed=mysql_real_escape_string($_POST['number_users']);
	$type=mysql_real_escape_string($_POST['division']);
	usernames($needed,$type);
}
function usernames($need,$type){
	$runs=1;
	while($runs<=$need){
		Echo $type.$runs.'<br/>';
		$runs++;
	}
}