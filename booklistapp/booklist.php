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
    			<h3>BookList</h3>
    		</div>
			<div class="row">
			
				<p>
					<a href="bookcreate.php" class="btn btn-success">Create</a>
					<a href="home.php" class="btn btn-success">Home</a>
				</p>
																
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>BookName</th>
		                  <th>BookAuthor</th>
		                  <th>BookRating</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					  

					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM book ORDER BY id DESC';
					   
						
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['bookname'] . '</td>';
							   	echo '<td>'. $row['bookauthor'] . '</td>';
							   	echo '<td>'. $row['bookrating'] . '</td>';
							   	echo '<td width=250>';
								echo '<a class="btn" href="bookread.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="bookupdate.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="bookdelete.php?id='.$row['id'].'">Delete</a>';
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