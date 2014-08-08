<?php
include('header.php');
?>

<form name="passform" method="POST" action="">
	Admin Username:<input type="text" name="uname"/><br/>
	Admin Email:<input type="text" name="email"/><br/>
	Password:<input name="passbox" type="password">
	<!--<input type="button" value="Generate" onClick="javascript:formSubmit()" tabindex="2">--> <br/>
	<input type="submit" value="Add user" class="btn btn-primary" name="adduser"/>
</form>
<?php
if ($_POST['adduser'])
{ 
    add_admin($_POST['uname'],$_POST['passbox'],$_POST['email']);
}


   function add_admin($name,$password,$email){
	//echo 'Adding admin';
	global $dbh;
	$log=new Logging();
	//$name= stripslashes($name);
	//$name = mysql_real_escape_string($name);
	$TempPass=$password;
	$password=stripslashes($password); //injection cleaner
	$password =  password_hash($password, PASSWORD_DEFAULT);
		echo '<br/> Please send this info to the admin:<br/>';
		echo 'Username: ' .$name.'<br/>';
		echo 'Password: ' .$TempPass. '<br/>';
		try{
		$insert = "INSERT INTO `members` (`name`, `password`,`email`) VALUES (?,?,?)";
		$add_admin=$dbh->prepare($insert);
		$add_admin->execute(array($name,$password,$email));
		echo "<span class=\"success\">Your user account has been created!</span><br>";
		$log->add_entry($_SESSION['name'],"New account with name $name, has been added");
		}catch(PDOException $e){
		    echo 'There was an error.';
		   
		    $log->add_entry('ERROR:',$e->getMessage());
		}
    }

?>
