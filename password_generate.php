<?php include('header.php');?>
	<h2>Random Password Generator</h2>
	<form method="POST" action="">
		Number of Passwords:<input type="text" name="number_pass">
		<input type="Submit" name="add_rand_pass" value="Generate Passwords">
	</form>
<?php
if($_POST['add_rand_pass']){
	$needed=$_POST['number_pass'];
	random_passwords($needed);
}
function random_passwords($needed){
	$password_length=9;
	$letters= 'ABDEFGHJKMNPQRTUVWXYZabcdefghjkmnpqrstuvwxyz23456789*'; //69 long
	$letter_len = strlen($letters);
	$runs=0;
	while($runs<$needed){
		$new='';
		for($place=0; $place<$password_length; $place++){
			$rand=rand(0,$letter_len);
				$new.=substr($letters,$rand, 1);
			}
			echo $new.'<br/>';
			$runs++;
	}
}
