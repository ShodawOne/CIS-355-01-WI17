<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
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
					  

					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM tvshow ORDER BY id DESC';
					   
						
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