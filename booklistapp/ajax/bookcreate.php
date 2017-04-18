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

if ( !empty($_POST)) { // if not first time through

			// keep track validation errors
		$booknameError = null;
		$bookauthorError = null;
		$bookratingError = null;
	$pictureError = null; // not used
	
	// keep track post values
		$bookname = $_POST['bookname'];
		$bookauthor = $_POST['bookauthor'];
		$bookrating = $_POST['bookrating'];
	$picture = $_POST['picture']; // not used
	
// initialize $_FILES variables
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	$content = file_get_contents($tmpName);

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


	// restrict file types for upload
	$types = array('image/jpeg','image/gif','image/png');
	if($filesize > 0) {
		if(in_array($_FILES['userfile']['type'], $types)) {
		}
		else {
			$filename = null;
			$filetype = null;
			$filesize = null;
			$filecontent = null;
			$pictureError = 'improper file type';
			$valid=false;
			
		}
	}
	// insert data
	if ($valid) 
	{
		$pdo = Database::connect();
		
				
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO book (bookname,bookauthor,bookrating,
		filename,filesize,filetype,filecontent) values(?, ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($bookname,$bookauthor,$bookrating,
		$fileName,$fileSize,$fileType,$content));
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
		
		Database::disconnect();
		header("Location: booklist.php");
	}
}
?>


    <div class="container">

		<div class="span10 offset1">
			
			<div class="row">
				<h3>Add New book</h3>
			</div>
	
			<form class="form-horizontal" action="bookcreate.html" method="post" enctype="multipart/form-data">
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
			  
				<div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
					<label class="control-label">Picture</label>
					<div class="controls">
						<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
						<input name="userfile" type="file" id="userfile">
						
					</div>
				</div>
			  
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
					<a class="btn" href="booklist.html">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
  