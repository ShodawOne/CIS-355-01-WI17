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

	if ( !empty($_POST)) {
		// keep track validation errors
		$tvnameError = null;
		$tvnetworkError = null;
		$bookratingError = null;
		
		// keep track post values
		$tvname = $_POST['tvname'];
		$tvnetwork = $_POST['tvnetwork'];
		$tvrating = $_POST['tvrating'];
		
		// validate input
		$valid = true;
		if (empty($tvname)) {
			$tvnameError = 'Please enter tvname';
			$valid = false;
		}
		
		if (empty($tvnetwork)) {
			$tvnetworkError = 'Please enter tvnetwork';
			$valid = false;
		} 
		
		if (empty($tvrating)) {
			$tvratingError = 'Please enter tvrating';
			$valid = false;
		}
						
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO tvshow (tvname,tvnetwork,tvrating) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($tvname,$tvnetwork,$tvrating));
			
			$sql = "SELECT `AUTO_INCREMENT`
					FROM INFORMATION_SCHEMA.TABLES
					WHERE TABLE_SCHEMA = 'mrdurfee'
					AND  TABLE_NAME   = 'tvshow'";
			$q = $pdo->prepare($sql);
			$q->execute(array($tvshow));
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$tvshowid = (int)$data['AUTO_INCREMENT']-1;
		//var_dump ($data);
		//echo $data['AUTO_INCREMENT'];
		//exit();		
			
			//$tvshowid = 63;
			$sql = "INSERT INTO tvshowusers (userid,tvshowid) values( ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$tvshowid));
			
			
			
			
			
			Database::disconnect();
			header("Location: tvlist.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<style>
		body {background-color: #00cc44;}
	</style>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a TV Show List</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="tvcreate.php" method="post">
					  <div class="control-group <?php echo !empty($tvnameError)?'error':'';?>">
					    <label class="control-label">TV Show Name</label>
					    <div class="controls">
					      	<input name="tvname" type="text"  placeholder="tvname" value="<?php echo !empty($tvname)?$tvname:'';?>">
					      	<?php if (!empty($tvnameError)): ?>
					      		<span class="help-inline"><?php echo $tvnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($tvnetworkError)?'error':'';?>">
					    <label class="control-label">TV NetWork</label>
					    <div class="controls">
					      	<input name="tvnetwork" type="text" placeholder="tvnetwork" value="<?php echo !empty($tvnetwork)?$tvnetwork:'';?>">
					      	<?php if (!empty($tvnetworkError)): ?>
					      		<span class="help-inline"><?php echo $tvnetworkError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($tvratingError)?'error':'';?>">
					    <label class="control-label">TV Rating</label>
					    <div class="controls">
					      	<input name="tvrating" type="text"  placeholder="tvrating" value="<?php echo !empty($tvrating)?$tvrating:'';?>">
					      	<?php if (!empty($bookratingError)): ?>
					      		<span class="help-inline"><?php echo $tvratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="tvlist.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>