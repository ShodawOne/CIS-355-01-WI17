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
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		print_r($_SESSION);
		
	    $sql = "SELECT * FROM book where id = ?";
				print_r($id);
		//$sql = 'select email,mobile,username,bookname,bookauthor,bookrating from 
			//		   (SELECT * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
				//	   as j join book on j.bookid=book.id';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		body {background-color: #9999ff;}
	</style>
</head>


  
  
  <body>
    <div class="container">
    
		<div class="span10 offset1">
		
			<div class="row">
				<h3>Book Details</h3>
			</div>
			
						
				<div class="control-group">
					<label class="control-label">bookname</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['bookname'];?>
						</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">bookauthor</label>
					<div class="controls">
						<label class="checkbox">
							<?php echo $data['bookauthor'];?>
						</label>
					</div>
				</div>
				
				<!--<div class="control-group">
					<label class="control-label">Description</label>
					<div class="controls">
						<label class="checkbox">
							<//?php echo $data['bookrating'];/?>
						</label>
					</div>
				</div> -->
				
				<!-- Display photo, if any --> 

				<div class='control-group col-md-6'>
				<label class="control-label">Pic</label>
					<div class="controls ">
					<?php 
					if ($data['filesize'] > 0) 
						echo '<img  height=5%; width=15%; src="data:image/jpeg;base64,' . 
							base64_encode( $data['filecontent'] ) . '" />'; 
					else 
						echo 'No photo on file.';
					?><!-- converts to base 64 due to the need to read the binary files code and display img -->
					</div>
				</div>
			
				<div class="form-actions">
					<!--<a class="btn btn-primary" href="bookcreate2.php?book_id=<?//php echo $id; ?>">rating for this shift</a>-->
					<a href="bookcreate2.php"<?php?id=',$id,'?> class="btn btn-success">test</a>
					<a href="bookcreate2.php" class="btn btn-success">Create</a>
					<a href="bookupdate2.php" class="btn btn-success">update</a>
					<a class="btn" href="booklist2.php">Back</a>
				</div>
				 <?php 
					  
					  
					   $pdo = Database::connect();
					   print_r($_SESSION);
					   //*9$id = $_SESSION['id'];
					   //$sessionid = $_SESSION['id'];
					   $sql = 'SELECT * FROM book ORDER BY id DESC';
					   
					   
					   
					   
					  // 'select bookname,bookauthor,bookrating,book.id as id from 
					   //(SELECT * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
					   //as j join book on j.bookid=book.id';
					   
						
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['bookname'] . '</td>';
							   	echo '<td>'. $row['bookauthor'] . '</td>';
							   	//echo '<td>'. $row['bookrating'] . '</td>';
							   	echo '<td width=250>';
								echo '<a class="btn" href="bookread2.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="bookcreate2.php?id='.$row['id'].'">create</a>';
							   	//echo '&nbsp;';
							   //	echo '<a class="btn btn-danger" href="bookdelete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
			
				
			<div class="row">
				<h4>people read and rating</h4>
			</div>
			
			<?php
				$pdo = Database::connect();
				$sql = "SELECT * FROM bookusers, users
				WHERE userid = users.id
				AND bookid = " . 
				$data['id'] . ' ORDER BY username ASC, email ASC';
				$countrows = 0;
				if($_SESSION['users_title']=='Administrator') {
					foreach ($pdo->query($sql) as $row) {
						echo $row['username'] . ', ' . $row['email'] . ' - ' . $row['mobile'] . ' - ' . $row['rating'] . '<br />';
					$countrows++;
					}
				}
				else {
					foreach ($pdo->query($sql) as $row) {
						echo $row['username'] . ', ' . $row['email'] . ' - ' . $row['rating'] . '<br />';
					$countrows++;
					}
				}
				if ($countrows == 0) echo 'none.';
			?>

			
			</div> <!-- end div: class="form-horizontal" -->
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
	
</body>

  
</html>