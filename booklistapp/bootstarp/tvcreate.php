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
		$id=$_SESSION['id'];

	if ( !empty($_POST)) {
		// keep track validation errors
		$tvnameError = null;
		$tvnetworkError = null;
		$bookratingError = null;
		$pictureError = null; // not used
		
		// keep track post values
		$tvname = $_POST['tvname'];
		$tvnetwork = $_POST['tvnetwork'];
		$tvrating = $_POST['tvrating'];
		$picture = $_POST['picture']; // not used
		
		// initialize $_FILES variables
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	$content = file_get_contents($tmpName);		
		
		// validate input
		$valid = true;
		if (empty($tvname)) {
			$tvnameError = 'Please enter tvname';
			$valid = false;
		}
		
		if (empty($tvnetwork)) {
			$tvnetworkError = 'Please enter tvnetwork';
			$valid = false;
		} 
		
		if (empty($tvrating)) {
			$tvratingError = 'Please enter tvrating';
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
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO tvshow (tvname,tvnetwork,tvrating,filename,filesize,filetype,filecontent) values(?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($tvname,$tvnetwork,$tvrating,$fileName,$fileSize,$fileType,$content));
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT `AUTO_INCREMENT`
					FROM INFORMATION_SCHEMA.TABLES
					WHERE TABLE_SCHEMA = 'mrdurfee'
					AND  TABLE_NAME   = 'tvshow'";
			$q = $pdo->prepare($sql);
			$q->execute(array($tvshow));
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$tvshowid = (int)$data['AUTO_INCREMENT']-1;
		//var_dump ($data);
		//echo $data['AUTO_INCREMENT'];
		//exit();		
			
			//$tvshowid = 63;
			$sql = "INSERT INTO tvshowusers (userid,tvshowid) values( ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($id,$tvshowid));
			
			
			
			
			
			Database::disconnect();
			header("Location: tvlist.php");
		}
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
							<h1>Create TV Show</h1>
					<table >
		              <thead>
		                <tr>
						<form class="form-horizontal" action="tvcreate.php" method="post" enctype="multipart/form-data">
		                  <th>
						  <div class="control-group <?php echo !empty($tvnameError)?'error':'';?>">
					    <label class="control-label">TV Show Name</label>
					    <div class="controls">
					      	<input name="tvname" type="text"  placeholder="tvname" value="<?php echo !empty($tvname)?$tvname:'';?>">
					      	<?php if (!empty($tvnameError)): ?>
					      		<span class="help-inline"><?php echo $tvnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  </th>
		                  <th>
						  <div class="control-group <?php echo !empty($tvnetworkError)?'error':'';?>">
					    <label class="control-label">TV NetWork</label>
					    <div class="controls">
					      	<input name="tvnetwork" type="text" placeholder="tvnetwork" value="<?php echo !empty($tvnetwork)?$tvnetwork:'';?>">
					      	<?php if (!empty($tvnetworkError)): ?>
					      		<span class="help-inline"><?php echo $tvnetworkError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  </th>
		                  <th><div class="control-group <?php echo !empty($tvratingError)?'error':'';?>">
					    <label class="control-label">TV Rating</label>
					    <div class="controls">
					      	<input name="tvrating" type="text"  placeholder="tvrating" value="<?php echo !empty($tvrating)?$tvrating:'';?>">
					      	<?php if (!empty($bookratingError)): ?>
					      		<span class="help-inline"><?php echo $tvratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div></th>
					  <th>
					   <div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
					<label class="control-label">Picture</label>
					<div class="controls">
						<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
						<input name="userfile" type="file" id="userfile">
						
					</div>
				</div>
					  </th>
		                  <th>
						  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  </div>
						</th>
						<th>
						  <div>
						   <a class="button" href="tvlist.php">Back</a>
						</div>
						</th>
		                </tr>
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