<?php
include('header.php');
?>

<form name="passform" method="POST" action="">
	Admin Username:<input type="text" name="schoolname"/><br/>
	Admin Email:<input type="text" name="email"/><br/>
	Password:<input name="passbox" type="password">
	<!--<input type="button" value="Generate" onClick="javascript:formSubmit()" tabindex="2">--> <br/>
	<input type="submit" value="Add user" name="adduser"/>
</form>
<?php
if ($_POST['adduser'])
{ 
    add_admin($_POST['adminName'],$_POST['passbox']);
}


    public function add_admin($name,$password){
	//echo 'Adding admin';
	global $dbh;
	$log=new Logging();
	$name= stripslashes($name);
	$name = mysql_real_escape_string($name);
	$TempPass=$password;
	$password=stripslashes($password); //injection cleaner
	$password =  password_hash($password, PASSWORD_DEFAULT);
		echo '<br/> Please send this info to the admin:<br/>';
		echo 'Username: ' .$name.'<br/>';
		echo 'Password: ' .$TempPass. '<br/>';
		try{
		$insert = "INSERT INTO `members` (`name`, `password`) VALUES (?,?)";
		$add_admin=$dbh->prepare($insert);
		$add_admin->execute(array($name,$password));
		echo "<span class=\"success\">Your user account has been created!</span><br>";
		$log->add_entry($_SESSION['name'],"New account with name $name, has been added");
		}catch(PDOException $e){
		    echo 'There was an error.';
		   
		    $log->add_entry('ERROR:',$e->getMessage());
		}
    }

?>
