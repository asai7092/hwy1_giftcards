
<?php
$host = "localhost";
$dbName = "hwy1_cards"; 
$username = "myuser"; 
$pwd = "Subie25RS"; 

//creates connection
$dbConn = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $pwd);

// Sets Error handling to Exception so it shows ALL errors when trying to get data
$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
 