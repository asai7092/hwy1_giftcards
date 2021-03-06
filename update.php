<?php
session_start();

if (!isset($_SESSION['username'])){
  header("Location: login.php");
}

$date = date('Y/m/d H:i:s');

$cardNumber= $_SESSION['cardUpdate'];

if($_SESSION['final_balance'] > 0){
$balance = $_SESSION['final_balance'];
} else {
$balance = 0;
}

if (isset($_POST['updateBalance'])) {  //login form has been submitted
    include 'db_connection.php';
     $sql = "INSERT INTO transactions
             (`employee_id`, `date`, `card_number`, `total`, `initial_balance`,`final_balance`)
             VALUES
             (:employee_id, :date, :card_number, :total, :initial_balance, :final_balance)";
$stmt = $dbConn->prepare($sql);
$stmt->execute( array (":employee_id" => $_SESSION['employee_id'],
						":date" => $date,
						":card_number" => $_SESSION['cardUpdate'],
						":total" => $_SESSION['sale'],
						":initial_balance" => $_SESSION['initial_balance'],
						":final_balance" => $_SESSION['final_balance']));


echo $_SESSION['employee_id'];
echo "&nbsp;";
echo $_SESSION['final_balance'];





$sql = "UPDATE cards SET balance='$balance' WHERE card_number='$cardNumber'";
$stmt = $dbConn->prepare($sql);
$stmt->execute();

}


?> 

<!DOCTYPE HTML>

<body>

      <h1>Thank you for updating card #<?php echo $_SESSION['cardUpdate'] . $_SESSION['initial_balance'] . "  " . $_SESSION['sale'];?></h1>
      </br>
      
      </br>
      <form action="logout.php">
           <input type="submit" value="Return to Login"/>
      </form>  
      
    

      
 </div>
 
 <?php
 unset($_SESSION['cardUpdate']);
unset($_SESSION['initial_balance']);
unset($_SESSION['sale']);
 ?>
</body>
</html>
 