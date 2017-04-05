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

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: booklist.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$booknameError = null;
		$bookauthorError = null;
		$bookratingError = null;
		
		// keep track post values
		$bookname = $_POST['bookname'];
		$bookauthor = $_POST['bookauthor'];
		$bookrating = $_POST['bookrating'];
		
		// validate input
		$valid = true;
		if (empty($bookname)) {
			$booknameError = 'Please enter bookname';
			$valid = false;
		}
		
		if (empty($bookauthor)) {
			$bookauthorError = 'Please enter bookauthor';
			$valid = false;
		} 
						
		if (empty($bookrating)) {
			$bookratingError = 'Please enter bookrating';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$sql = 'select bookname,bookauthor,bookrating from 
					  // (UPDATE * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
					 //  as j join book on j.bookid=book.id';			
			$sql = "UPDATE book  set bookname = ?, bookauthor = ?, bookrating = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($bookname,$bookauthor,$bookrating,$id));
			Database::disconnect();
			header("Location: booklist.php");
		}	
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		print_r($_SESSION);
		//$sql = 'select bookname,bookauthor,bookrating from 
			//		   (SELECT * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
				//	   as j join book on j.bookid=book.id';
		$sql = "SELECT * FROM book where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$bookname = $data['bookname'];
		$bookauthor = $data['bookauthor'];
		$bookrating = $data['bookrating'];
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
		body {background-color: #6666ff;}
	</style>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a BookList</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="bookupdate.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($booknameError)?'error':'';?>">
					    <label class="control-label">BookName</label>
					    <div class="controls">
					      	<input name="bookname" type="text"  placeholder="BookName" value="<?php echo !empty($bookname)?$bookname:'';?>">
					      	<?php if (!empty($booknameError)): ?>
					      		<span class="help-inline"><?php echo $booknameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($bookauthorError)?'error':'';?>">
					    <label class="control-label">BookAuthor</label>
					    <div class="controls">
					      	<input name="bookauthor" type="text" placeholder="BookAuthor" value="<?php echo !empty($bookauthor)?$bookauthor:'';?>">
					      	<?php if (!empty($bookauthorError)): ?>
					      		<span class="help-inline"><?php echo $bookauthorError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($bookratingError)?'error':'';?>">
					    <label class="control-label">BookRating</label>
					    <div class="controls">
					      	<input name="bookrating" type="text"  placeholder="BookRating" value="<?php echo !empty($bookrating)?$bookrating:'';?>">
					      	<?php if (!empty($bookratingError)): ?>
					      		<span class="help-inline"><?php echo $bookratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="booklist.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>