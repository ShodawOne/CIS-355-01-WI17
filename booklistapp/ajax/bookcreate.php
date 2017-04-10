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
						
		// insert data
		if ($valid) {
			//print_r(["Data: ",$bookname,$bookauthor,$bookrating,$tid,$userid,$bookid]);
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "INSERT INTO book (bookname,bookauthor,bookrating) values(?, ?, ?)";
			
			//$sql = 'select email,mobile,username,bookname,bookauthor,bookrating from 
			//		   (INSERT INTO `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
				//	   as j join book on j.bookid=book.id';
			
			$q = $pdo->prepare($sql);
			$q->execute(array($bookname,$bookauthor,$bookrating));
			
			//$sql = "SELECT MAX(bookid) FROM book";
			//$sql = "SELECT Last_Insert_Id( id FROM book)";
			/*$sql = "SELECT TOP 1 id FROM book ORDER BY id DESC";
			$sql = "SELECT Last_Insert_Id()";
			$result = mysql_query($sql);
			if (!$result){
				echo 'Could not run query: ' .mysql_error();
			}
			
			$row = mysql_fetch_row($result);
			$bookid = $row[0];*/
			//print_r($row[0]);	
			$sql = "SELECT `AUTO_INCREMENT`
					FROM INFORMATION_SCHEMA.TABLES
					WHERE TABLE_SCHEMA = 'mrdurfee'
					AND  TABLE_NAME   = 'book'";
			$q = $pdo->prepare($sql);
			$q->execute(array($book));
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$bookid = (int)$data['AUTO_INCREMENT']-1;
		//var_dump ($data);
		//echo $data['AUTO_INCREMENT'];
		//exit();		
			
			//$bookid = 63;
			$sql = "INSERT INTO bookusers (userid,bookid) values( ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$bookid));
			
			//$sql = "INSERT INTO bookusers (tid,userid,bookid) values (?, ?, ?)";
			//$q = $pdo->prepare($sql);
			//$q->execute(array($tid,$userid,$bookid));
			Database::disconnect();
			header("Location: booklist.php");
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
		body {background-color: #4d4dff;}
	</style>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a BookList</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="bookcreate.php" method="post">
					  <div class="control-group <?php echo !empty($booknameError)?'error':'';?>">
					    <label class="control-label">BookName</label>
					    <div class="controls">
					      	<input name="bookname" type="text"  placeholder="bookname" value="<?php echo !empty($bookname)?$bookname:'';?>">
					      	<?php if (!empty($booknameError)): ?>
					      		<span class="help-inline"><?php echo $booknameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($bookauthorError)?'error':'';?>">
					    <label class="control-label">BookAuthor</label>
					    <div class="controls">
					      	<input name="bookauthor" type="text" placeholder="bookauthor" value="<?php echo !empty($bookauthor)?$bookauthor:'';?>">
					      	<?php if (!empty($bookauthorError)): ?>
					      		<span class="help-inline"><?php echo $bookauthorError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($bookratingError)?'error':'';?>">
					    <label class="control-label">BookRating</label>
					    <div class="controls">
					      	<input name="bookrating" type="text"  placeholder="bookrating" value="<?php echo !empty($bookrating)?$bookrating:'';?>">
					      	<?php if (!empty($bookratingError)): ?>
					      		<span class="help-inline"><?php echo $bookratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="booklist.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>