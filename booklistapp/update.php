<?php
session_start();
 
//connect to database
$db=mysqli_connect("localhost","mrdurfee","580069","mrdurfee");

session_start();
if(!isset($_SESSION["username"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
} 
?>


<?php 
	
	require 'database.php';

	$id=$_SESSION['id'];
	
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: user.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$usernameError = null;
		$emailError = null;
		$passwordError = null;
		$mobileError = null;
		
		// keep track post values
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$mobile = $_POST['mobile'];
		
		// validate input
		$valid = true;
		if (empty($username)) {
			$nameError = 'Please enter username';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE users  set username = ?, email = ?, password = ?, mobile = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$password=MD5($password);
			$q->execute(array($username,$email,$password,$mobile,$id));
			Database::disconnect();
			header("Location: user.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//print_r($_SESSION);
		//$sql = 'select bookname,bookauthor,bookrating from 
			//		   (SELECT * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
				//	   as j join book on j.bookid=book.id';		
		$sql = "SELECT * FROM users where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$username = $data['username'];
		$email = $data['email'];
		$password = $data['password'];
		$mobile = $data['mobile'];
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<style>
		body {background-color: #ff9999;}
	</style>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a User</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					    <label class="control-label">username</label>
					    <div class="controls">
					      	<input name="username" type="text"  placeholder="username" value="<?php echo !empty($username)?$username:'';?>">
					      	<?php if (!empty($usernameError)): ?>
					      		<span class="help-inline"><?php echo $usernameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="text" placeholder="password" value="" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
					      	<?php if (!empty($mobileError)): ?>
					      		<span class="help-inline"><?php echo $mobileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="user.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>