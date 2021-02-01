
![Mainpage Screenshot](https://github.com/rajshree-v/series-smash/blob/main/Screenshot.png)

Database Structure in SQL: These are the properties of all the rows made in the php database.

In case you want to create the database directly, then:
The name of the database: facemash
The name of the table to store all the image and score information: photos

CREATE TABLE 'photos' (
  'id' int(11) NOT NULL PRIMARY KEY,
  'token' varchar(255) NOT NULL,
  'name' varchar(255) NOT NULL,
  'path' varchar(255) NOT NULL,
  'score' int(11) NOT NULL DEFAULT '2000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#init.php
We have used mySqli in this project.

$host = 'localhost'; // Put here your host
$db_username = 'root'; // Put here your database username
$db_password = ''; // Put here your database password
$db_name = 'facemash'; // Put here your database name
$mysqli = new mysqli($host, $db_username, $db_password, $db_name);

#add.php
To add different images in the database, enter the name in the text-box and Click "Add" button.
Or you can directly add the images by going to phpMyAdmin tab through the localhost in XAMPP.

#Make sure to save all the files in the same folder
