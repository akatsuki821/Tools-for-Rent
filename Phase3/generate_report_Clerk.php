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
$currentDate = date("Y-m"); 
$query_temp1 ="CREATE TEMPORARY TABLE num_of_pickup AS
SELECT clerk_username AS pickup_username, COUNT(pickup.tool_id) AS numPickup, DATE_FORMAT(rented_start_date, '%Y-%m') AS pickup_date
FROM pickup LEFT OUTER JOIN rented ON pickup.tool_id = rented.tool_id
WHERE DATE_FORMAT(rented_start_date, '%Y-%m') = '$currentDate'
GROUP BY pickup_username;";

//this is very helpful to debug
/*if (mysqli_query($db, $query_temp1)) {
    echo "Table MyGuests created successfully";
} else {
    echo "Error creating table: " . mysqli_error($db);
}*/
mysqli_query($db, $query_temp1);

$query_temp2 = "
CREATE TEMPORARY TABLE num_of_dropoff AS
SELECT clerk_username AS dropoff_username, COUNT(dropoff.tool_id) AS numDropoff, DATE_FORMAT(rented_end_date, '%Y-%m') AS dropoff_date
FROM dropoff LEFT OUTER JOIN rented ON dropoff.tool_id = rented.tool_id
WHERE DATE_FORMAT(rented_end_date, '%Y-%m') = '$currentDate';";
mysqli_query($db, $query_temp2);

$query_clerk = "
SELECT clerk_id, first_name, middle_name, last_name, email, date_of_hire, clerk.username, IFNULL(numPickup, 0) AS num_pickup, IFNULL(numDropoff, 0) AS num_dropoff, (IFNULL(numPickup, 0) + IFNULL(numDropoff, 0)) AS total
FROM ((clerk NATURAL JOIN user) LEFT OUTER JOIN num_of_pickup ON clerk.username = pickup_username) LEFT OUTER JOIN num_of_dropoff ON clerk.username = dropoff_username
GROUP BY clerk.username
ORDER BY total DESC;";
$result_clerk = mysqli_query($db, $query_clerk);

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
                    <div class="subtitle">Clerk Report</div>
                    <p>The list of clerks where their total pickups and dropoffs are shown for the this month.</p>
                     <?php 
                            echo '<table style = "font-size: 10px">';
                            echo '<th>Clerk ID</th>';
                            echo '<th>First Name</th>';
                            echo '<th>Middle Name</th>';
                            echo '<th>Last Name</th>';
                            echo '<th>Email</th>';
                            echo '<th>Hire Date</th>';
                            echo '<th>Number of Pickups</th>';
                            echo '<th>Number of Dropoffs</th>';
                            echo '<th>Combined Total</th>';
                        while($row_clerk = mysqli_fetch_assoc($result_clerk)) {
                            echo '<tr align ="center">';
                            $hireDate = date("m/d/Y", strtotime($row_clerk['date_of_hire']));
                            echo '<td width = "10px">'.$row_clerk['clerk_id'].'</td>';
                            echo '<td width = "50px">'.$row_clerk['first_name'].'</td>';
                            echo '<td width = "50px">'.$row_clerk['middle_name'].'</td>';
                            echo '<td width = "50px">'.$row_clerk['last_name'].'</td>';
                            echo '<td width = "100px">'.$row_clerk['email'].'</td>';
                            echo '<td width = "80px">'.$hireDate.'</td>';
                            echo '<td width = "80px">'.$row_clerk['num_pickup'].'</td>';
                            echo '<td width = "80px">'.$row_clerk['num_dropoff'].'</td>';
                            echo '<td width = "80px">'.$row_clerk['total'].'</td>';
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