<?php include('header.php');?>
	<h2>Random Password Generator</h2>
	<form method="POST" action="">
		Number of Passwords:<input type="text" name="number_pass">
		<input type="Submit" name="add_rand_pass" value="Generate Passwords">
	</form>
<?php
if($_POST['add_rand_pass']){
	$needed=mysql_real_escape_string($_POST['number_pass']);
	random_passwords($needed);
}
function random_passwords($needed){
	$letters= 'abcdefghjkmnpqrstuvwxyz23456789*/.[]!@#$%^&*'; //45 long
	$runs=0;
	while($runs<$needed){
		$new='';
		for($place=0; $place<6; $place++){
			$rand=rand(0,45);
			$new.=substr($letters,$rand, 1);
			}
			echo $new.'<br/>';
			$runs++;
	}
}