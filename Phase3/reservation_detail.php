<?php

include('lib/common.php');
// written by Team008


if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}
$reservationid = $_GET['link'];
$query = "SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) AS 'Full Name', 
    Round(sum(Tools.purchase_price * 0.4),2) AS 'total_deposit', 
    Round(sum(Tools.purchase_price * 0.15 * DATEDIFF(Reservation.reservation_end_date , Reservation.reservation_start_date)), 2) AS 'total_rental_price'  " .
    "FROM Reservation INNER JOIN Customer ON Reservation.customer_username=Customer.username 
    INNER JOIN User ON Customer.username = User.username
    INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id" .
    " WHERE Reservation.reservation_id='$reservationid'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

include('lib/show_queries.php');

    $query_tool = "SELECT Tools.tool_id,  
    Round(Tools.purchase_price * 0.4,2) AS 'deposit', CONCAT(IF(power_source = 'manual', '',CONCAT(Tools.power_source, ' ')), Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, ' ')AS 'tool_name',
    Round((Tools.purchase_price * 0.15 * DATEDIFF(Reservation.reservation_end_date , Reservation.reservation_start_date)),2) AS 'rental_price' " .
    "FROM Reservation INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id
    INNER JOIN Toolinfo ON Toolinfo.tool_id = Tools.tool_id" .
    " WHERE Reservation.reservation_id= '$reservationid'";
    $result_tool = mysqli_query($db, $query_tool);

?>

<?php include("lib/header.php"); ?>              
<html>
<body>
<div id="main_container">
   <?php include("lib/clerk_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">         
            <div class="features">   
                <div class="tool_detail_section">
                    <div class="subtitle"><h2>Reservation Details</h2></div>
                       <table>
                         <tr>
                            <td class="item_label">Reservation ID: </td>
                            <td>
                                <?php print $reservationid ?>
                            </td> 
                         </tr>
                         <tr>
                            <td class="item_label">Customer Name: </td>
                            <td>
                                <?php print $row['Full Name']?>
                            </td> 
                         </tr>
                           <tr>
                            <td class="item_label">Total Deposit: </td>
                            <td>
                                <?php print $row['total_deposit']?>
                            </td> 
                         </tr>
                           <tr>
                            <td class="item_label">Total Rental Price: </td>
                            <td>
                                <?php print $row['total_rental_price']?>
                            </td> 
                         </tr>
                    </table>
               </div>
               	<div class="tool_info_section">
                    <div class="subtitle">Tool Information</div>
                     <?php 
                            echo '<table>';
                            echo '<th>TooL ID</th>';
                            echo '<th>Tool Name</th>';
                            echo '<th>Deposit Price</th>';
                            echo '<th>Rental Price</th>';
                        while($row_tool = mysqli_fetch_assoc($result_tool)) {
                            
                            echo '<tr align ="center">';
                            echo '<td width = "10px">'.$row_tool['tool_id'].'</td>';
                            
                            echo "<td width = 200px><a href=clerk_tool_detail.php?link=" . $row_tool['tool_id'] . ">".$row_tool['tool_name']."</a></td>";
                            echo '<td width = "50px">'.$row_tool['deposit'].'</td>';
                            echo '<td width = "50px">'.$row_tool['rental_price'].'</td>';
                            echo '</tr>';                     
                        }
                        echo '</table>';
                    ?>
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