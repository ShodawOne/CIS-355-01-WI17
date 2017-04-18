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
		//$sql = 'select email,mobile,username,bookname,bookauthor,bookrating from 
			//		   (SELECT * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
				//	   as j join book on j.bookid=book.id';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>


    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Read a BookList</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">BookName</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['bookname'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">BookAuthor</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['bookauthor'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">BookRatings</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['bookrating'];?>
						    </label>
					    </div>
					  </div>
					 <!-- Display photo, if any --> 

				<div class='control-group col-md-6'>
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
						  <a class="btn" href="booklist.html">Back</a>
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  