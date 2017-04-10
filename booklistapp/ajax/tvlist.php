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
		body {background-color: #009933;}
	</style>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>TV Show List</h3>
    		</div>
			<div class="row">
			
				<p>
					<a href="tvcreate.php" class="btn btn-success">Create</a>
					<a href="home.php" class="btn btn-success">Home</a>
				</p>
																
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>TV Show Name</th>
		                  <th>TV NetWork</th>
		                  <th>TV Rating</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					 
					   $id = $_SESSION['id'];

					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 
					   'select tvname,tvnetwork,tvrating,tvshow.id as id from 
					   (SELECT * FROM `users` as u join tvshowusers as bu on u.id=bu.userid WHERE u.id='.$id.') 
					   as j join tvshow on j.tvshowid=tvshow.id';
					   
						
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['tvname'] . '</td>';
							   	echo '<td>'. $row['tvnetwork'] . '</td>';
							   	echo '<td>'. $row['tvrating'] . '</td>';
							   	echo '<td width=250>';
								echo '<a class="btn" href="tvread.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="tvupdate.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="tvdelete.php?id='.$row['id'].'">Delete</a>';
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