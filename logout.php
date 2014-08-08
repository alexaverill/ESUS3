<?php
session_unset(); 
session_destroy(); 
echo '<META HTTP-EQUIV=Refresh CONTENT=".5; URL=login.php">';
include('header.php');
echo '<h1>Logout</h1>';

echo 'You have logged out';
include('footer.php');
?>