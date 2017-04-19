<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
	include 'apiClass.php';

	API::setSQL($_GET['id']);

	API::printJson();
?>
</body>
</html>