<?php
 session_start();
 
//connect to database
$db=mysqli_connect("localhost","mrdurfee","580069","mrdurfee");

session_start();
if(!isset($_SESSION["username"])){ // if "user" not set,
	session_destroy();
	header('Location: http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/loginform2/login.php');     // go to login page
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
		//print_r($_SESSION);
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



		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="index.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Home</span>
								</a>

								<a href="booklist.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Book list</span>
								</a>
								
							<!-- Nav -->
								<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>
				<!-- Menu -->
					<nav id="menu">
						<h2>Menu</h2>
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="user.php">User Info</a></li>
							<li><a href="booklist.php">Book List</a></li>
							<li><a href="tvlist.php">TV List</a></li>
							<li><a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/forum3/main_forum1.php">Forum</a></li>
						</ul>
					</nav>
					
					
						</div>
					</header>

					<div id="main">
						<div class="inner">
							<h1>Read Book From List</h1>
					<table >
		              <thead>
					  <form class="form-horizontal" action="booklist.php?id=<?php echo $id?>" method="post">
		                <tr>
		                  <th> 
						  <label class="control-label">BookName</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['bookname'];?>
						    </label>
					    </div>
						</th>
		                  <th>
						  <label class="control-label">BookAuthor</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['bookauthor'];?>
						    </label>
					    </div>
						</th>
		                  <th>
						  <label class="control-label">BookRatings</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['bookrating'];?>
						    </label>
					    </div>
						</th>
						<th>
						  <div class="form-actions">
						   <button class="btn" href="booklist.php">Back</button>
						</div>
						</th>
						</tr>
						
						
						<!-- Display photo, if any --> 

				<div class='control-group col-md-6'>
					<div class="controls ">
					<?php 
					if ($data['filesize'] > 0) 
						echo '<img  height=20%; width=15%; src="data:image/jpeg;base64,' . 
							base64_encode( $data['filecontent'] ) . '" />'; 
					else 
						echo 'No photo on file.';
					?><!-- converts to base 64 due to the need to read the binary files code and display img -->
					</div>
				</div>
						
						
		              </thead>
		              <tbody>
		             
				
						
					
				      </tbody>
	            </table>
					</div>
					

		