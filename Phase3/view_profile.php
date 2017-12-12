<?php

include('lib/common.php');
// written by Team008

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}
$username = $_SESSION['username'];

    // ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
//home_phone, cell_phone, work_phone
    $query_user = "SELECT email AS 'E-mail', CONCAT(first_name, ' ', middle_name, ' ', last_name) AS 'Full Name',  address FROM User INNER JOIN Customer ON User.username = Customer.username WHERE User.username = '$username'";
    $query_homephone = "SELECT phone_number FROM Phone p WHERE P.phone_type = 'home_phone' AND p.username = '$username'";
    $query_workphone = "SELECT phone_number FROM Phone p WHERE P.phone_type = 'work_phone' AND p.username = '$username'";
    $query_cellphone = "SELECT phone_number FROM Phone p WHERE P.phone_type = 'cell_phone' AND p.username = '$username'";

   /* $query_reservation = "SELECT R.reservation_id, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) AS numOfDays, ROUND(sum(T.purchase_price * 0.4,2)) AS TotalDepositPrice, ROUND(sum(purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date)),2)AS TotalDepositPrice, CONCAT(IF(power_source = 'manual', '', CONCAT(T.power_source, ' ')), I.tool_suboption, ' ', I.tool_subtype, ' ') AS toolDescrip, P.clerk_username AS PCUser, D.clerk_username AS DCUser FROM Reservation R "
        ."INNER JOIN Tools T ON R.tool_id = T.tool_id "
        ."INNER JOIN Toolinfo I ON T.tool_id = I.tool_id "
        ."INNER JOIN PickUp P ON T.tool_id = P.tool_id AND P.reservation_id = R.reservation_id "
        ."INNER JOIN DropOff D ON T.tool_id = D.tool_id AND D.reservation_id = R.reservation_id "
        ."WHERE R.customer_username = '$username'";*/
   


    $result_user = mysqli_query($db, $query_user);
    $result_homephone = mysqli_query($db, $query_homephone);
    $result_workphone = mysqli_query($db, $query_workphone);
    $result_cellphone = mysqli_query($db, $query_cellphone); 
    
    
    include('lib/show_queries.php');
    
    if ( !is_bool($result_user) && (mysqli_num_rows($result_user) > 0)) {
        $row_user = mysqli_fetch_array($result_user, MYSQLI_ASSOC);
    } 
    else {
        array_push($error_msg,  "Query ERROR: Failed to get User profile...<br>" . __FILE__ ." line:". __LINE__ );
    }

  
    if(mysqli_num_rows($result_homephone) > 0){
        $row_home = mysqli_fetch_array($result_homephone, MYSQLI_ASSOC);
    }
   if(mysqli_num_rows($result_workphone) > 0){
        $row_work = mysqli_fetch_array($result_workphone, MYSQLI_ASSOC);
    }
   if(mysqli_num_rows($result_cellphone) > 0){
        $row_cell = mysqli_fetch_array($result_cellphone, MYSQLI_ASSOC);
    }
   
?>


<?php include("lib/header.php"); ?>

<html>
<head>
<title>View Profile</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/customer_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">                    
            <div class="features">   
            
                <div class="profile_section">
                    <div class="subtitle"><h2>Customer Info</h2></div>   
                    <table >
                        <tr>
                            <td class="item_label">E-mail: </td>
                            <td>
                                <?php print $row_user['E-mail'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Full Name:</td>
                            <td>
                                <?php print $row_user['Full Name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Home Phone:</td>
                            <td>
                                <?php print $row_home['phone_number'];?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Work Phone:</td>
                            <td>
                                <?php print $row_work['phone_number'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Cell Phone:</td>
                            <td>
                                <?php print $row_cell['phone_number'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Address:</td>
                            <td>
                                <?php print $row_user['address'];?>
                            </td>
                        </tr>

                       
                    </table>						
                </div>

                <div class="profile_section">
                    <div class="subtitle"><h2>Reservations</h2></div>  
                    <table width = "700" style = "font-size: 8px">
                    <tr>
                       <th width = "10px">Reservation ID</th>
                       <th width = "100px">Tools</th>
                       <th width = "40px">Start Date</th>
                       <th width = "40px">End Date</th>
                       <th width = "40px">Pick-up Clerk</th>
                       <th width = "40px">Drop-off Clerk</th>
                       <th width = "50px">Number of Days</th>
                       <th width = "50px">Total Deposit Price</th>
                       <th width = "40px">Total Rental Price</th>
                    </tr>
                    <?php
                         /*$query_reservation = "SELECT R.reservation_id, reservation_start_date, reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) AS numOfDays, ROUND(sum(T.purchase_price * 0.4),2) AS TotalDepositPrice, ROUND(sum(purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date)),2) AS TotalRentaltPrice, CONCAT(IF(power_source = 'manual', '', CONCAT(T.power_source, ' ')), I.tool_suboption, ' ', I.tool_subtype, ' ') AS toolDescrip, P.clerk_username AS PCUser, D.clerk_username AS DCUser FROM Reservation R INNER JOIN Tools T ON R.tool_id = T.tool_id INNER JOIN Toolinfo I ON T.tool_id = I.tool_id INNER JOIN PickUp P ON T.tool_id = P.tool_id AND P.reservation_id = R.reservation_id INNER JOIN DropOff D ON T.tool_id = D.tool_id AND D.reservation_id = R.reservation_id WHERE R.customer_username = '$username' GROUP BY R.reservation_id DESC ORDER BY reservation_start_date";*/
                        
                        
                        $query_A = "CREATE TEMPORARY TABLE A SELECT R.reservation_id, R.reservation_start_date, R.reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) AS numOfDays, ROUND(sum(T.purchase_price * 0.4),2) AS TotalDepositPrice,ROUND(sum(purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date)),2) AS TotalRentaltPrice FROM Reservation R INNER JOIN Tools T on R.tool_id = T.tool_id WHERE R.customer_username ='$username' GROUP BY R.reservation_id";
                        mysqli_query($db, $query_A);
                        $query_B = "CREATE TEMPORARY TABLE B SELECT R.reservation_id, T.tool_id, P.clerk_username AS PCUser, D.clerk_username AS DCUser, CONCAT(IF(power_source = 'manual', '',CONCAT(T.power_source, ' ')), I.tool_suboption, ' ', I.tool_subtype, ' ') AS toolDescrip FROM Reservation R INNER JOIN Tools T on R.tool_id = T.tool_id INNER JOIN Toolinfo I ON T.tool_id = I.tool_id left JOIN PickUp P ON T.tool_id = P.tool_id LEFT JOIN DropOff D ON T.tool_id = D.tool_id WHERE R.customer_username = '$username'";
                        mysqli_query($db, $query_B);
                        $query_reservation = "SELECT * FROM A NATURAL JOIN B";
                        
                     /*   $query_reservation = "CREATE TEMPORARY TABLE A SELECT R.reservation_id, R.reservation_start_date, R.reservation_end_date, DATEDIFF(reservation_end_date,reservation_start_date) AS numOfDays, ROUND(sum(T.purchase_price * 0.4),2) AS TotalDepositPrice,ROUND(sum(purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date)),2) AS TotalRentaltPrice FROM Reservation R INNER JOIN Tools T on R.tool_id = T.tool_id WHERE R.customer_username ='$username' GROUP BY R.reservation_id; CREATE TEMPORARY TABLE B SELECT R.reservation_id, T.tool_id, P.clerk_username AS PCUser, D.clerk_username AS DCUser, CONCAT(IF(power_source = 'manual', '',CONCAT(T.power_source, ' ')), I.tool_suboption, ' ', I.tool_subtype, ' ') AS toolDescrip FROM Reservation R INNER JOIN Tools T on R.tool_id = T.tool_id INNER JOIN Toolinfo I ON T.tool_id = I.tool_id left JOIN PickUp P ON T.tool_id = P.tool_id LEFT JOIN DropOff D ON T.tool_id = D.tool_id WHERE R.customer_username = '$username'";  */                  

                        $result_reservation = mysqli_query($db, $query_reservation);
                        
                        include('lib/show_queries.php');
                        
                        if ( is_bool($result_reservation) && (mysqli_num_rows($result_reservation) == 0)) {
                            array_push($error_msg,  "Query ERROR: Failed to get reservation informations...<br>" . __FILE__ ." line:". __LINE__ );                        
                        }
                        //$row_reservation = mysqli_fetch_array($result_reservation, MYSQLI_ASSOC);
                        $count = mysqli_num_rows($row_reservation);
                        while($row_reservation = mysqli_fetch_array($result_reservation, MYSQLI_ASSOC)){
                            echo '<tr align = "center">';
                            echo '<td width = "5px">'.$row_reservation['reservation_id'].'</td>';
                            echo '<td width = "10px">'.$row_reservation['toolDescrip'].'</td>';
                            echo '<td width = "20px">'.$row_reservation['reservation_start_date'].'</td>';
                            echo '<td width = "20px">'.$row_reservation['reservation_end_date'].'</td>';
                            echo '<td width = "20px">'.$row_reservation['PCUser'].'</td>';
                            echo '<td width = "20px">'.$row_reservation['DCUser'].'</td>';
                            echo '<td width = "10px">'.$row_reservation['numOfDays'].'</td>';
                            echo '<td width = "20px">'.$row_reservation['TotalDepositPrice'].'</td>';
                            echo '<td width = "20px">'.$row_reservation['TotalRentaltPrice'].'</td>';
                            echo '</tr>';                            
                        }
                       

                    ?>
                    </table>						
                </div>	


            </div> 			
        </div> 

                <?php include("lib/error.php"); ?>
                    
				<div class="clear"></div> 		
			</div>    

             
				 
		</div>
	</body>
</html>