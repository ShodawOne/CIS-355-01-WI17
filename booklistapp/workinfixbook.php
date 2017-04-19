<?php 
/* ---------------------------------------------------------------------------
 * filename    : fr_assign_update.php
 * author      : George Corser, gcorser@gmail.com
 * description : This program updates an assignment (table: fr_assignments)
 * ---------------------------------------------------------------------------
 */
session_start();
if(!isset($_SESSION["username"])){ // if "user" not set,
	session_destroy();
	header('Location: login.php');     // go to login page
	exit;
}
print_r($_SESSION);
print_r($id);


require 'database.php';


$id = $_GET['id'];

if ( !empty($_POST)) { // if $_POST filled then process the form
	
	# same as create

	// initialize user input validation variables
	$userError = null;
	$bookError = null;
	$ratingError = null; // not used
	
	
	// initialize $_POST variables
	$user = $_POST['userid'];    // same as HTML name= attribute in put box
	$book = $_POST['bookid'];
	$rating = $_POST['rating'];
	
	
	// validate user input
	$valid = true;
	if (empty($user)) {
		$userError = 'Please choose a user';
		$valid = false;
	}
	if (empty($book)) {
		$bookError = 'Please choose an book';
		$valid = false;
	} 
	
	if (empty($rating)) {
		$ratingError = 'Please choose an rating';
		$valid = false;
	} 
		
	if ($valid) { // if valid user input update the database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE bookusers set userid = ?, 
		bookid = ?, rating = ? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($user,$book,$rating,$id));
		Database::disconnect();
		header("Location: booklist2.php");
	}
} else { // if $_POST NOT filled then pre-populate the form
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM bookusers where id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$user = $data['userid'];
	$book = $data['bookid'];
	Database::disconnect();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<link rel="icon" href="cardinal_logo.png" type="image/png" />
</head>

<body>
    <div class="container">
        <?php 
			//gets logo
			functions::logoDisplay();
		?>
		<div class="span10 offset1">
		
			<div class="row">
				<h3>Update Assignment</h3>
			</div>
	
			<form class="form-horizontal" action="booklist2.php?id=<?php echo $id?>" method="post">
		
				<div class="control-group">
					<label class="control-label">user</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM users ORDER BY username ASC, email ASC';
							echo "<select class='form-control' name='user' id='users'>";
							 // if $_GET exists restrict person options to logged in user
								foreach ($pdo->query($sql) as $row) {
									if($user==$row['id'])
										echo "<option value='" . $row['id'] . " '
									> " . $row['username'] . ', ' .$row['email'] . "</option>";
								}
							else
								
							echo "<option value='" . $row['id'] . " '
							> " . $row['username'] . ', ' .$row['email'] . "</option>";
								}
							echo "</select>";
							
							Database::disconnect();
						?>
					</div>	<!-- end div: class="controls" -->
				</div> <!-- end div class="control-group" -->
			  
				<div class="control-group">
					<label class="control-label">book</label>
					<div class="controls">
						<?php
							$pdo = Database::connect();
							$sql = 'SELECT * FROM book ORDER BY bookname ASC, bookauthor ASC';
							echo "<select class='form-control' name='book' id='book_id'>";
							 // if $_GET exists restrict person options to logged in user
								foreach ($pdo->query($sql) as $row) {
									if($book==$row['id'])
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
					<button type="submit" class="btn btn-success">Update</button>
					<a class="btn" href="booklist2.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->

  </body>
</html>