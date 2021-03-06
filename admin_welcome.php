<?php
	session_start();

	if (!isset($_SESSION['username'])){
  		header("Location: login.php");
	}
	
	if (isset($_POST['cardUpdate'])){
  		$_SESSION['cardUpdate'] = $_POST['cardUpdate'];
  		header("Location: transactions.php");
	}
	
	if (isset($_POST['transactions'])){
  		header("Location: transactions.php");
	}
	
?> 

<!DOCTYPE HTML>
	<head>
		<link rel="stylesheet" type="text/css" href="css/mystyle.css">
		<style>
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
      
    	<span id="greeting" style="font-size:40px; font-weight:bold;">Welcome Administrator   <?php echo $_SESSION['first_name'] . $_SESSION['employee_id'] ?></span>
    	</br>
    	<form class="nav" method="POST" action="">
        	<input type="submit" name="transactions" value="Transactions" />
    	</form>
    	<form class="nav" action="logout.php">
        	<input type="submit" value="Sign out" />
    	</form>  
    	</br>
    	</br>
    	
    	<?php
    		if($_SESSION['admin'] == 'yes'){
				echo "<span style='font-size:25px;'>
						Register a new employee
					</span> 
					</br>
					</br>
					<div id='content'>
        				<form method='POST' action='register.php'>
        					<label>First Name:</label>
      						<input class='input_register' type='text' name='fName'>
      						</br>
      						</br>
      						<label>Last Name:</label>
							<input class='input_register' type='text' name='lName'>
      						</br>
      						</br>
      						<label>Username:</label>
      						<input class='input_register' type='text' name='user'>
      						</br>
      						</br>
      						<label>Password:</label>
      						<input class='input_register' type='password' name='pass'>
      						</br>
      						</br>
      						<label>Position:&nbsp;</label>
      						<select class='input_register' name='admin'>
      							<option value='no'>
      								Associate
      							</option>
      							<option value='yes'>
      								Manager
      							</option>
      						</select>
      						</br>
      						</br>
      						<input class='input_register' type='submit' value='Submit' name='register'>
      					</form>
				</div>";
			}
		?>
		
		</br>
		</br>
		<div>
			<!-- DB Connect -->
			<?php

				include 'db_connect.php';
 
				$conn = OpenCon();
 
				echo "Connected Successfully <br>";

			?>

			<!-- Populate <select> -->
			<?php
				$sql = "SELECT * 
						FROM cards";
		
				$result = $conn->query($sql);
			?>

			Search by card number:
			</br>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> " method="post">
		
			<?php
				if ($result->num_rows > 0) {
    				echo "<select name='name'>";
    				echo "<option value='*'>All Cards</option>";
    				// output data of each row
    				while($row = $result->fetch_assoc()) {
        				echo "<option value='" . $row['card_number'] . "'>" . $row["card_number"]. "</option>";
    				}
    				echo "</select>";
				} else {
    				echo "0 results";
				}

			?>

			<?php
				$name  = "";

				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$name = ($_POST["name"]);

					if( $name > 0){	

						$sql = "SELECT * 
								FROM cards
								WHERE card_number='$name'";
		
						$result = $conn->query($sql);
		
					} elseif ( $name == 0 ) {

						$sql = "SELECT * 
								FROM cards";
		
						$result = $conn->query($sql);
					}
				}

			?>
		
			<input type="submit">
			</form>
			</br>

			<!-- Switch SQL Query -->

			<?php
				$name  = "";

				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$name = ($_POST["name"]);	
		
					if($name == '*'){

        				$sql = "SELECT * 
						FROM cards";
        
					} elseif ($name > 1) {
	
						$sql = "SELECT * 
						FROM cards
						WHERE card_number = '$name'";
					}
				}

				$result = $conn->query($sql);
			?>

			<!-- Build table -->
			<?php
				/* Cards */
				if ($result->num_rows > 0) {
    				echo "<table class='table' cellpadding='5px';'> 
    						<tr>
    							<th> 
    								Card Number
    							</th>
    							<th>
    								Card Type
    							</th>
    							<th>
    								Purchase Date
    							</th>
    							<th>
    								Expiration
    							</th>
    							<th>
    								Balance
    							</th>
    							<th>
    							</th>
    						</tr>";
    				// output data of each row
    				while($row = $result->fetch_assoc()) {
        				echo "<tr>
        						<td>" . 
        							$row["card_number"] . 
        						"</td>
        						<td>" . 
        							$row["card_type"]. 
        						"</td>
        						<td>" .
        							$row["purchased"]. 
        						"</td>
        						<td>" .
        							$row["expiration"]. 
        						"</td>
        						<td>" .
        							$row["balance"]. 
        						"</td>
        						<td>
        							<form method='POST' >
        								<button type='submit' name='cardUpdate' value='" . $row["card_number"] . "'>
        									Update Balance
        								</button>
        								
        							</form>
        						</td>
        					 </tr>";
    				}
    				echo "</table>";
				} else {
    				echo "0 results";
    			}
			?>
		
		</div>
		
		
	</body>
</html>
 