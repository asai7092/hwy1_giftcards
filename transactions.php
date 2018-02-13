<?php
session_start();

if (!isset($_SESSION['username'])){
  header("Location: login.php");
}

$sale = 0;

?>

<!DOCTYPE HTML>
<head>
	
	<link rel="stylesheet" type="text/css" href="css/mystyle.css">
	<style>
		.header2{
			font-weight:bold;
			}
			
		.red {
			color:red;
			}
			
		.table {
				border-collapse:collapse;
				}
		
			.table th, .table td {
				border:1px solid black;
				}
			
			.table tr:nth-child(even){
				background-color: #f2f2f2;
				}

			.table tr:hover {
				background-color: #ddd;
				}
			.table th {
    			padding-top: 12px;
    			padding-bottom: 12px;
    			text-align: left;
    			background-color: #4CAF50;
    			color: white;
				}
				
			.nav {
				position:relative;
				float:left;
				}
	</style>
</head>
<body>
	
	<?php
	if (isset($_POST['back'])){
  		unset($_SESSION['cardUpdate']);
  		header("Location: admin_welcome.php");
	}
	?>
	
	<form method="POST" action="">
		<input type="submit" name="back" value="Go Back"/>
	</form>

</br>
</br>
<h1>Transactions</h1>

<?php

				include 'db_connect.php';
 
				$conn = OpenCon();
 
				//echo "Connected Successfully <br>";

			?>

			<!-- Populate <select> -->
			<?php
				$sql = "SELECT * 
						FROM cards";
		
				$result = $conn->query($sql);
			?>

			<!-- Populate <select> -->
			<?php
				

			?>
<?php
	if (isset($_SESSION['cardUpdate'])){
		$cardNumber = $_SESSION['cardUpdate'];
		echo "<span class='header2' style='font-size:30px;'>
				Card #" . $cardNumber . "
			 </span>
			 </br>
			 Remaining balance: $";
		$sql = "SELECT * 
				FROM cards
				WHERE card_number = '$cardNumber'";
		
		$result = $conn->query($sql);
				
		if ($result->num_rows > 0) {
    		while($row = $result->fetch_assoc()) {
        		$start_balance = $row['balance'];
        		echo $row['balance'];
    		}
		} else {
    		echo "N/A";
		}
		
		if(!empty($_POST['order'])){
			$sale = $_POST['sale'];
			$_SESSION['sale'] = $_POST['sale'];
		} else {
			$sale = 0;
			$_SESSION['sale'] = 0;
		}
		
		
		echo "<form method='POST'>
				<label>Sale Total: $</label>
				<input type='text' name='sale' value='0'/>
				<input type='submit' name='order' value='Refresh Order'/>
			</form>";
	
		
	} else {
		
	}

?> 
</br>
</br>

<?php

$date = date('Y/m/d H:i:s');

echo $date;


	
?>

<?php
	if(!empty($_POST['order'])){
		$remain_balance = $start_balance - $sale;
		echo $start_balance . " - " . $sale . " = ";
		print($remain_balance);
	
		echo "</br>
			 </br>";


		if($remain_balance < 0){
			echo "The total balance due is ";
			echo "<span class='red'>$"; 
					print($remain_balance*-1);
			echo "</span>
				 </br>
				 and the remaining card balance will be reduced to <span class='red'>$0</span>";
		} else {
			echo "The remaining balance on card #" . $cardNumber . " is <span class='red'>$";
			echo($remain_balance) . "</span>";
		}
		
		$_SESSION['initial_balance'] = $start_balance;
		$_SESSION['final_balance'] = $remain_balance;
		
		echo "<form method='POST' action='update.php'>
			 <input type='submit' name='updateBalance' value='Confirm Order Purchase'>
			 </form></br></br>";
	}

?>

<!-- Switch SQL Query -->

			<?php
        		$sql = "SELECT * 
						FROM transactions";

				$result = $conn->query($sql);
			?>

			<!-- Build table -->
			<?php
				/* Cards */
				if ($result->num_rows > 0) {
    				echo "<table class='table' cellpadding='5px';'> 
    						<tr>
    							<th> 
    								Date
    							</th>
    							<th> 
    								Card Number
    							</th>
    							<th>
    								Employee ID
    							</th>
    							<th>
    								Start Balance
    							</th>
    							<th>
    								Sale Total
    							</th>
    							<th>
    								End Balance
    							</th>
    						</tr>";
    				// output data of each row
    				while($row = $result->fetch_assoc()) {
        				echo "<tr>
        						<td>" . 
        							$row["date"] . 
        						"</td>
        						<td>" . 
        							$row["card_number"]. 
        						"</td>
        						<td>" . 
        							$row["employee_id"]. 
        						"</td>
        						<td>$" .
        							$row["initial_balance"]. 
        						"</td>
        						<td>$" .
        							$row["total"]. 
        						"</td>
        						<td>$" .
        							$row["final_balance"]. 
        						"</td>
        					 </tr>";
    				}
    				echo "</table>";
				} else {
    				echo "0 results";
    			}
			?>

















</body>
<html>