<?php
session_start();
session_destroy();
unset($_SESSION['username']);
$_SESSION['message']="You are now logged out";
header("location: http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/loginform2/login.php");
?>