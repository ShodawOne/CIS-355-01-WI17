<?php 
session_start();
if(!isset($_SESSION["username"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
print_r($_SESSION);
print_r($_GET);
print_r($_POST);
$users = $_SESSION["username"];
$books = $_GET['id'];



require 'database.php';


if ( !empty($_POST)) {

	// initialize user input validation variables
	$userError = null;
	$bookError = null;
	$ratingError = null; // not used
	
	
	// initialize $_POST variables
	$userid = $_POST['userid'];    // same as HTML name= attribute in put box
	$bookid = $_POST['bookid'];
	$rating = $_POST['rating'];
	
	// validate user input
	$valid = true;
	if (empty($userid)) {
		$userError = 'Please choose a user';
		$valid = false;
	}
	if (empty($bookid)) {
		$bookError = 'Please choose an book';
		$valid = false;
	} 
	
	if (empty($rating)) {
		$ratingError = 'Please choose an rating';
		$valid = false;
	} 
		
	if ($valid) {
				
		//echo $userid . " " . $bookid . " " . $rating; exit();
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE bookusers  set userid = ?, bookid = ?, rating = ? WHERE id = ?";
		/*$sql = "INSERT INTO bookusers 
			(userid,bookid,rating) 
			values(?, ?, ?)";*/
		$q = $pdo->prepare($sql);
		
		$q->execute(array($userid,$bookid,$rating,$id));
		Database::disconnect();
		header("Location: booklist2.php");
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
		<div class="span10 offset1">
			<div class="row">
				<h3>Assign a Volunteer to an Event</h3>
			</div>
	
			<form class="form-horizontal" action="bookcreate2.php" method="post">
		
				<div class="control-group">
					<label class="control-label">Users List</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM `users` WHERE username = "'. $_SESSION['username'] . '"';
							echo "<select class='form-control' name='userid' id='username'>";
							if($user) // if $_GET exists restrict person options to logged in user
								foreach ($pdo->query($sql) as $row) {
									if($user==$row['id'])
										echo "<option value='" . $row['id'] . " '
									> " . $row['username'] . ', ' .$row['email'] . "</option>";
								}
							else
								foreach ($pdo->query($sql) as $row) {
							echo "<option value='" . $row['id'] . " '
							> " . $row['username'] . ', ' .$row['email'] . "</option>";
								}
							echo "</select>";
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				<div class="control-group">
					<label class="control-label">Book List</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM `book` WHERE id = "'. $_GET['id'] . '"';
							echo "<select class='form-control' name='bookid' id='id'>";
							
							if($books) // if $_GET exists restrict person options to logged in user
								foreach ($pdo->query($sql) as $row) {
									if($books==$row['id'])
										echo "<option value='" . $row['id'] . " '>
									" . $row['bookname'] . ', ' .$row['bookauthor'] . 
									"</option>";
								}
							else
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '>
									" . $row['bookname'] . ', ' .$row['bookauthor'] . "
									</option>";
								}
							echo "</select>";
							
							
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
				
				 <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
					    <label class="control-label">Rating</label>
					    <div class="controls">
					      	<input name="rating" type="text"  placeholder="rating" value="<?php echo !empty($rating)?$rating:'';?>">
					      	<?php if (!empty($ratingError)): ?>
					      		<span class="help-inline"><?php echo $ratingError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>

				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
						<a class="btn" href="booklist2.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
		
    </div> <!-- end div: class="container" -->

  </body>
</html>