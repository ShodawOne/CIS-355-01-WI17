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
		header("Location: tvlist.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM tvshow where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>TV Show List</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="index.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Home</span>
								</a>

								<a href="tvlist.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">TV Show List</span>
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
							<h1>Read TV Show From List</h1>
					<table >
		              <thead>
		                <tr>
						<form class="form-horizontal" action="tvlist.php?id=<?php echo $id?>" method="post">
		                  <th>
						  <div class="control-group">
					    <label class="control-label">TV Show</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['tvname'];?>
						    </label>
					    </div>
					  </div>
					  </th>
		                  <th>
						  <div class="control-group">
					    <label class="control-label">TV NetWork</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['tvnetwork'];?>
						    </label>
					    </div>
					  </div>
					  </th>
		                  <th>
						  <div class="control-group">
					    <label class="control-label">TV Ratings</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['tvrating'];?>
						    </label>
					    </div>
					  </div>
					  </th>
		                  <th>
						  <div class="form-actions">
						   <button class="btn" href="tvlist.php">Back</button>
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
					</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>