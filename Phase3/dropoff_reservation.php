
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

if( $_SERVER['REQUEST_METHOD'] == 'POST') {

    $error = false;
	$enteredReservationid = mysqli_real_escape_string($db, $_POST['reservation_id']);
    $reservation_id_query = "SELECT * FROM Reservation WHERE reservation_id= '$enteredReservationid'";
    $reservation_id_result = mysqli_query($db, $reservation_id_query);
    include('lib/show_queries.php');
    $reservation_id_count = mysqli_num_rows($reservation_id_result); 
    
    if($reservation_id_count == 0){
        $error = true;
        array_push($error_msg,  "Reservation is not exist");     
    }
    
    else {
         $_SESSION['reservation_id'] = $enteredReservationid;  
         array_push($query_msg, "Go to Drop Off Reservation page.");
         header(REFRESH_TIME . 'url=dropoff_reservation_confirmation.php');
    }
}


$query_clerk = 'SELECT Distinct R.reservation_id, R.customer_username, C.customer_id, R.reservation_start_date, R.reservation_end_date
FROM Reservation AS R
Inner Join Customer AS C on R.customer_username = C.username 
Inner Join PickUp AS P on R.reservation_id = P.reservation_id
Left Outer Join Dropoff AS D on R.reservation_id = D.reservation_id
where D.reservation_id is NULL
ORDER BY R.reservation_id;';
$result_clerk = mysqli_query($db, $query_clerk);

?>


<?php include("lib/header.php"); ?>
<html>
<head>
<title>Drop Off Reservation</title>
</head>

<body>
<div id="main_container">
   <?php include("lib/clerk_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
            </div>          
            <div class="features">   
			
                <div class="dropoff_section">
                    <div class="subtitle">Drop Off Reservation</div>
                     <?php 
                            echo '<table>';
                            echo '<th>Reservation ID</th>';
                            echo '<th>Customer</th>';
                            echo '<th>Customer ID</th>';
                            echo '<th>Start Date</th>';
                            echo '<th>End Date</th>';
                        while($row_clerk = mysqli_fetch_assoc($result_clerk)) {
                            echo '<tr align ="center">';
                            echo "<td width = 20px><a href=reservation_detail.php?link=" . $row_clerk['reservation_id'] . ">".$row_clerk['reservation_id']."</a></td>";
                            echo '<td width = "50px">'.$row_clerk['customer_username'].'</td>';
                            echo '<td width = "50px">'.$row_clerk['customer_id'].'</td>';
                            echo '<td width = "80px">'.$row_clerk['reservation_start_date'].'</td>';
                            echo '<td width = "80px">'.$row_clerk['reservation_end_date'].'</td>';
                            echo '</tr>';                     
                        }
                        echo '</table>';
                    ?>
                    				
                </div>	

            </div> 	
              <form action = "dropoff_reservation.php" method = "post" style = "width: 750px">
               <div class = "two_form">
                   <input type = "text" placeholder = "Reservation ID" name = "reservation_id" style = "width: 217px;" value="<?php if(isset($_POST["reservation_id"]))echo $_POST["reservation_id"]; ?>" required/><br><br>
               <input type = "submit" name = "dropoff_btn" value = "Drop Off" style = "font-size:10pt;color:white; background-color:green;" />
               </div><br>
              </form>
        </div> 

                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

               <?php include("lib/footer.php"); ?>
               
				 
		</div>
	</body>
</html>