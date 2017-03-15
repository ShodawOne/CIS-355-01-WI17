<?php

    // connect to database
    $con = mysql_connect('localhost','mrdurfee', '580069') or die (mysql_error());
    $db = mysql_select_db('mrdurfee',$con);
    
    // $id is the value of the id field in the table that contains the uploaded file

    if (isset($_POST['img_id'])) $id = $_POST['img_id'];
    else $id = 1; // initialize to something
    
    // get all info from mr_upload1 file
    $query = "SELECT id, name, size, type FROM mr_upload1";
    $result = mysql_query($query);
    
    // display list
    while ($row = mysql_fetch_assoc($result)) {
        echo "<p>" . $row['id'] . " " . $row['name'] . " " . $row['size'] . " " . $row['type'] . 
        "</p>";
    }
    
    // display form to user
    echo "<form method='post' action='filedownload.php'>";
    echo "<br />Hey, type an image id number <br />";
    echo "<input type='text' name='img_id' />";
    echo "<input type='submit' value='Submit' />";
    echo "</form>";
    
    $query = "SELECT id, name, size, type, content FROM mr_upload1 WHERE id=$id";
    
    $result = mysql_query($query);
    
    $content = mysql_result($result, 0, "content");
    
    echo "<img height='auto' width='50%' src='data:image/jpeg;base64," . base64_encode($content) . "'>";
    
//show_source(__FILE__);
    
?>