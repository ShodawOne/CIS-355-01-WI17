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


<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Forum</title>
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
								<a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/index.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Home</span>
								</a>
								<a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/forum3/main_forum1.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Main Forum</span>
								</a>
								<<a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/logout.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Log Out</span>
								</a>

							<!--	<a href="bookcreate.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Add Book</span>
								</a> -->
								
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
							<li><a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/index.php">Home</a></li>
							<li><a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/user.php">User Info</a></li>
							<li><a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/booklist.php">Book List</a></li>
							<li><a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/tvlist.php">TV List</a></li>
							<li><a href="http://csis.svsu.edu/~mrdurfee/cis355/booklistapp/bootstarp/forum3/main_forum1.php">Forum</a></li>
						</ul>
					</nav>
					
					
						</div>
					</header>

					<div id="main">
						<div class="inner">
							<h1>Home Forum</h1>
					<table >
		              <thead>
		                <tr>
		                  <th>Topic</th>
		                  <th>Views</th>
		                  <th>Replies</th>
		                  <th>Date/Time</th>
		                </tr>
		              </thead>
		              <tbody>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form id="form1" name="form1" method="post" action="add_new_topic1.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3" bgcolor="#E6E6E6"><strong>Create New Topic</strong> </td>
</tr>
<tr>
<td width="14%"><strong>Topic</strong></td>
<td width="2%">:</td>
<td width="84%"><input name="topic" type="text" id="topic" size="50" /></td>
</tr>
<tr>
<td valign="top"><strong>Detail</strong></td>
<td valign="top">:</td>
<td><textarea name="detail" cols="50" rows="3" id="detail"></textarea></td>
</tr>
<tr>
<td><strong>Name</strong></td>
<td>:</td>
<td><input name="name" type="text" id="name" size="50" /></td>
</tr>
<tr>
<td><strong>Email</strong></td>
<td>:</td>
<td><input name="email" type="text" id="email" size="50" /></td>
</tr>
<tr>
<td colspan="5" align="middle" bgcolor="#E6E6E6"><a href="main_forum1.php" ><strong>Return to Main Page</strong> </a></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Submit" /> 
<input type="reset" name="Submit2" value="Reset" /></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
					  
					
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