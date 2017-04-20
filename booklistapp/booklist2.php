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
    		<div class="row">
    			<h3>BookList</h3>
    		</div>
			<div class="row">
			
				<p>
					<!--<a href="bookcreate.php" class="btn btn-success">Create</a>-->
					<a href="home.php" class="btn btn-success">Home</a>
					<a class="btn btn-success" href="logout.php">Log Out</a>
				</p>
																
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>BookName</th>
		                  <th>BookAuthor</th>
		                  <!--<th>BookRating</th> -->
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					  
					  

					   include 'database.php';
					   $pdo = Database::connect();
					   print_r($_SESSION);
					   $id = $_SESSION['id'];
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
							  // 	echo '<a class="btn btn-success" href="bookupdate2.php?id='.$row['id'].'">Update</a>';
							   	//echo '&nbsp;';
							   //	echo '<a class="btn btn-danger" href="bookdelete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
					  
					  
					  
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>