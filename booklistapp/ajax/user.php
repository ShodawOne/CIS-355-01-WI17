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
		body {background-color: #ff4d4d;}
	</style>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Username</h3>
    		</div>
			<div class="row">
			
				<p>
					
					<a href="home.php" class="btn btn-success">Home</a>
				</p>
								
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Username</th>
		                  <th>Email Address</th>
		                  <th>Mobile Number</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					  

					   include 'database.php';
					   $pdo = Database::connect();
					   $id = $_SESSION['id'];
					   $sql = //'SELECT * FROM book ORDER BY id DESC';
					   //<a href="create.php" class="btn btn-success">Create</a>
					   
					  
					   'select email,mobile,username from 
					   (SELECT * FROM `users` as u join bookusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
					   as j join book on j.bookid=book.id LIMIT 0, 1';
					   
						
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['username'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width=250>';
								echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
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