<?php

//To insert images to database. Can be done directly too through localhost.
require_once('init.php');
//gets executed only when the user clicks the submit button
if (isset($_POST['done']))
{
    //acceses the folder storing the images
    $folder = 'photos/';
    //name extention of the individual image files
    $ext = 'banana.jpg';
    //real_escape_string : escapes special characters in a string for use in a sql query 
    //here assigns value to the image 'name' in the database using the user input 
    $name = $mysqli->real_escape_string($_POST['name']);
    //this sql query enters the image path, name and token value in the php database
    $mysqli->query('
    INSERT INTO photos
    SET token = "' . md5($name . 'SeriesSmash') . '", 
        name = "' . $name . '",
        path = "' . $folder . strtolower($name) . $ext . '"');
    //to redirect the user to same page in order to enter more images in the database
    header ('Location: add.php');
    exit;
}
?>
<!-- To retrieve the user input data to enter in the database -->
<form action="" method="post">
    <input type="text" name="name" placeholder="Image Name" />
    <button type="submit" name="done">Add</button>
</form>