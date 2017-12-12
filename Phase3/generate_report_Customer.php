<?php

include('lib/common.php');
// written by Team008
if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");  
}
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}
$lastmonthDate = date("Y-m", strtotime("last month")); 

$query_temp1 ="CREATE TEMPORARY TABLE reservations AS
SELECT distinct customer_username AS reservation_username, reservation.reservation_id, DATE_FORMAT(reservation_start_date, '%Y-%m') AS reservation_date
FROM reservation
WHERE DATE_FORMAT(reservation_start_date, '%Y-%m') = '$lastmonthDate';";
//this is very helpful to debug
/*if (mysqli_query($db, $query_temp1)) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . mysqli_error($db);
}*/
mysqli_query($db, $query_temp1);

$query_temp2 = "
CREATE TEMPORARY TABLE num_of_reserved AS
SELECT reservation_username, COUNT(reservation_id) AS numReserved, reservation_date
FROM reservations
GROUP BY reservation_username;";
mysqli_query($db, $query_temp2);

$query_temp3 = "
CREATE TEMPORARY TABLE num_of_rented AS
SELECT customer_username AS rented_username, COUNT(rented.tool_id) AS numRented, DATE_FORMAT(rented_start_date, '%Y-%m') AS rented_date
FROM rented
WHERE DATE_FORMAT(rented_start_date, '%Y-%m') = '$lastmonthDate'
GROUP BY rented_username;";
mysqli_query($db, $query_temp3);

$query_customer = 'SELECT customer_id, first_name, middle_name, last_name, email, phone_number, customer.username, IFNULL(numReserved, 0) AS num_reserved, IFNULL(numRented, 0) AS num_rented
FROM ((customer NATURAL JOIN user) LEFT OUTER JOIN num_of_reserved ON username = reservation_username) LEFT OUTER JOIN num_of_rented ON username = rented_username
GROUP BY customer.username
ORDER BY numRented DESC, last_name ASC;';
$result_customer = mysqli_query($db, $query_customer);

?>


<?php include("lib/header.php"); ?>
<html>
<head>
<title>Clerk Report</title>
</head>

<body>
<div id="main_container">
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
            </div>          
            <div class="features">   
            <div id="header">
                <div class="logo"><img src="img/tools_for_rent.png" style="opacity:1.0;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/></div>
			</div>
                <div class="report_profile_section">
                    <div class="subtitle">Customer Report</div>
                    <p>The list of customers and reservations with tools for the last month.</p>
                     <?php 
                            echo '<table style = "font-size: 10px">';
                            echo '<th>Customer ID</th>';
                            echo '<th>View Profile?</th>';
                            echo '<th>First Name</th>';
                            echo '<th>Middle Name</th>';
                            echo '<th>Last Name</th>';
                            echo '<th>Email</th>';
                            echo '<th>Phone</th>';
                            echo '<th>Total # Reservations</th>';
                            echo '<th>Total # Tools Rented</th>';
                        while($row_customer = mysqli_fetch_assoc($result_customer)) {
                            $customerUsername = $row_customer['username'];
                            echo '<tr>';
                            echo '<td width = "10px">'.$row_customer['customer_id'].'</td>';
                            echo "<td width = '10px'>"."<a href = 'clerk_view_profile.php?new=$customerUsername' target = '_blank'>View Profile</a>".'</td>';
                            echo '<td width = "50px">'.$row_customer['first_name'].'</td>';
                            echo '<td width = "50px">'.$row_customer['middle_name'].'</td>';
                            echo '<td width = "50px">'.$row_customer['last_name'].'</td>';
                            echo '<td width = "100px">'.$row_customer['email'].'</td>';
                            echo '<td width = "80px">'.$row_customer['phone_number'].'</td>';
                            echo '<td width = "80px">'.$row_customer['num_reserved'].'</td>';
                            echo '<td width = "80px">'.$row_customer['num_rented'].'</td>';
                            echo '</tr>';
                            
                        }
                        echo '</table>';
                    ?>
                    <a href = "generate_report.php">Back to Report Menu</a>					
                </div>	

            </div> 			
        </div> 

                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
				 
		</div>
	</body>
</html>