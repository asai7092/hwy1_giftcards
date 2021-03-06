<?php
session_start();

if (isset($_POST['loginForm'])) {  //login form has been submitted
    include 'db_connection.php';
    $sql = "SELECT * FROM logins " .
           "WHERE username = :username " .
           "AND password = :password  ";
	$stmt = $dbConn->prepare($sql);
	$stmt->execute( array (":username" => $_POST['username'],
		        ":password" => hash("sha1",$_POST['password'])));
	$record = $stmt->fetch();
 
  if (!empty($record)) { //if record with username and password was found
        $_SESSION['username'] = $record['username'];
        $_SESSION['employee_id'] = $record['employee_id'];
        $_SESSION['first_name'] = $record['first_name'];
        $_SESSION['admin'] = $record['admin'];
        header("Location: admin_welcome.php");
    } else {
        echo "<span id='login_err'> Wrong username/password </span>"; 
    }
} //endIf loginForm was submitted



?>

<!DOCTYPE HTML>
<head>
	<link rel="stylesheet" type="text/css" href="css/mystyle.css">

</head>
<body>

<form method="post">
Username: <input type="text" name="username" /> <br />
Password: <input type="password" name="password"  />
<input type="submit" name="loginForm" />
</form>

      <?php 
              //check whether errorArray is set, if so, display items.
       ?>
</body>
 
</html>
 