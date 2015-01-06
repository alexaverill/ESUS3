<?php include('header.php');?>
	<h2>Username Generator</h2>
	<form method="POST" action="">
		Prefix:<select name="division">
					<option value="B">B</option>
					<option value="C">C</option>
					<option value="Team">Team</option>
				</select>
		Number of Users:<input type="text" name="number_users">
		<input type="Submit" name="add" value="Generate Usernames">
	</form>
<?php
if($_POST['add']){
	$needed=$_POST['number_users'];
	$type=$_POST['division'];
	//echo $needed;
	
	$runs=1;
	while($runs<=$needed){
		
		Echo $type.$runs.'<br/>';
		$runs++;
	}
	//usernames($needed,$type);
}