<?php
session_start();
 
//connect to database
$db=mysqli_connect("localhost","mrdurfee","580069","mrdurfee");
 
 
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

  <title>Register , login and logout user php mysql</title>
  
</head>
<body>
<div class="header">
    <h1>Register, login and logout user php mysql</h1>
</div>
<?php
    if(isset($_SESSION['message']))
    {
         echo "<div id='error_msg'>".$_SESSION['message']."</div>";
         unset($_SESSION['message']);
    }
?>
<h1>Home</h1>
<div>
    <h4>Welcome <?php echo $_SESSION['username']; ?></h4></div>
	<p>
	<a href="index.php" class="btn btn-success">Your Profile</a>
	<a href="" class="btn btn-success">Book List</a>
	<a href="http://csis.svsu.edu/~mrdurfee/cis355/forum3/main_forum.php" class="btn btn-success">Forum</a>
	</p>
	
	
</div>
<a class="btn btn-success" href="logout.php">Log Out</a>
</body>
</html>