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

 <?php

//print_r($_FILES);

if($_FILES['file1']['size']>0 && $_FILES['file1']['size']<2000000){

    // create variables for $_FILES elements
    $filename = $_FILES['file1']['name'];
    $tempname = $_FILES['file1']['tmp_name'];
    $filesize = $_FILES['file1']['size'];
    $filetype = $_FILES['file1']['type'];
    
    // make sure slashes are correct
    $filetype = (get_magic_quotes_gpc() == 0
        ? mysql_real_escape_string($filetype)
        : mysql_real_escape_string(stripslashes($_FILES['file1'])));
    
    // open the file that was uploaded 
    $fp = fopen($tempname, 'r');
    $content = fread($fp, filesize($tempname));
    $content = addslashes($content);
    
    // display the properties of the file that was uploaded
    echo 'filename: ' . $filename . '<br />';
    echo 'filesize: ' . $filesize . '<br />';
    echo 'filetype: ' . $filetype . '<br />';
    
    // close the file
    fclose($fp);
    
    if(!get_magic_quotes_gpc()) {
        $filename = addslashes($filename);
    }
    
    // connect to database
    $con = mysql_connect('localhost','mrdurfee', '580069') or die (mysql_error());
    $db = mysql_select_db('mrdurfee',$con);
    
    // if connection was successful, insert the contents into the content (blob) field
    if($db) {
        $query = "INSERT INTO book (name, size, type, content) VALUES ('$filename', '$filesize', '$filetype', '$filecontent')";
        mysql_query($query) or die('query failed');
        mysql_close();
        echo "upload successful";
    }
    // otherwise report error
    else echo "upload failed: " . mysql_error();
    
}



?> 