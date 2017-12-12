<?php

include('lib/common.php');
// written by Team008


if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}

include('lib/show_queries.php');

  $reservationlid = $_GET['reservationid'];
 

  $totaldepositprice_query="SELECT ROUND(sum(Tools.purchase_price * 0.4),2) AS 'TotalDepositPrice' FROM Reservation 
                            INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id 
                            WHERE Reservation_id = '$reservationlid'";
  $result_totaldepositprice = mysqli_query($db, $totaldepositprice_query);
  $row_totaldepositprice = mysqli_fetch_array($result_totaldepositprice , MYSQLI_ASSOC);
      

  $totalrentalprice_query="SELECT ROUND(sum(purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date)),2) AS 'TotalRentaltPrice' 
                         FROM Reservation INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id 
                         WHERE Reservation_id = '$reservationlid'";
  $result_totalrentalprice = mysqli_query($db, $totalrentalprice_query);
  $row_totalrentalprice = mysqli_fetch_array($result_totalrentalprice, MYSQLI_ASSOC);
  
  $totals_query = "SELECT ROUND(sum(Tools.purchase_price * 0.4)+sum(purchase_price * 0.15 * DATEDIFF(reservation_end_date,reservation_start_date)),2) AS 'Totals' FROM Reservation INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id 
                         WHERE Reservation_id = '$reservationlid'";
  $result_totals = mysqli_query($db, $totals_query);
  $row_totals = mysqli_fetch_array($result_totals, MYSQLI_ASSOC);   
 
      

$querycon =  "SELECT Reservation.tool_id AS 'Tool ID', 
             CONCAT (IF(Tools.power_source = 'Manual', '', CONCAT(Tools.power_source, ' ' )), Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype)AS 'Description', 
             ROUND ((Tools.purchase_price * .15), 2) AS 'Rental Price', ROUND ((Tools.purchase_price * .40), 2) AS 'Deposit Price', 
             Reservation_start_date AS 'Start Date', reservation_end_date AS 'End Date' 
             FROM Reservation INNER JOIN Toolinfo ON Reservation.tool_id = Toolinfo.tool_id INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id 
             WHERE Reservation_id = '$reservationlid'
             ORDER BY Reservation.tool_id";

$resultcon = mysqli_query($db, $querycon);



?>

<?php include("lib/header.php"); ?>             
<html>
<body>
<div id="main_container">
    <?php include("lib/customer_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">         
            <div class="features">   
                <div class="tool_detail_section">
                    <div class="subtitle"><h2>Reservation Confirmation</h2></div>
                       <table>
                         <tr>
                            <td class="item_label">Reservation ID: </td>
                            <td>
                                <?php echo $reservationlid ?>
                            </td> 
                            <td class="item_label">Total Deposit Price: </td>
                            <td>
                                <?php print $row_totaldepositprice['TotalDepositPrice']?>
                            </td> 
                             <td class="item_label">Total Rental Price: </td>
                             <td>
                                <?php print $row_totalrentalprice['TotalRentaltPrice']?>
                            </td> 
                             <td class="item_label">Totals: </td>
                             <td>
                                <?php print $row_totals['Totals']?>
                            </td> 
                           </tr>
                    </table>
                    <br>
                    <div class="reservation_detail_section">
                    <div class="subtitle">Reservation Detail</div>  
                   
                    <style>
                    {
                   font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                   border-collapse: collapse;
                   width: 100%;
                    }

                  td, th {
                     border: 1px solid #ddd;
                     padding: 8px;
                    }

                   tr:nth-child(even){background-color: #f2f2f2;}

                   tr:hover {background-color: #ddd;}

                   th {
                        padding-top: 12px;
                        padding-bottom: 12px;
                        text-align: left;
                        background-color: #4CAF50;
                        color: white;
                        }
                     </style>

                    
                     <?php 
                            echo '<table>';
                            echo '<th>Tool ID';
                            echo '<th>Description</th>';
                            echo '<th>Rental Price</th>';
                            echo '<th>Deposit Price</th>';
                            echo '<th>Start Date</th>';
                            echo '<th>End Date</th>';
                            while($row_resultcon = mysqli_fetch_assoc($resultcon)) {
                            echo '<tr align ="center">';
                            echo '<td width = "20px">'.$row_resultcon['Tool ID'].'</td>';
                            echo "<td width = 200px><a href=tool_detail.php?link=" . $row_resultcon['Tool ID'] . ">".$row_resultcon['Description']."</a></td>";
                            echo '<td width = "100px">'.$row_resultcon['Rental Price'].'</td>';
                            echo '<td width = "100px">'.$row_resultcon['Deposit Price'].'</td>';
                            echo '<td width = "100px">'.$row_resultcon['Start Date'].'</td>';
                            echo '<td width = "100px">'.$row_resultcon['End Date'].'</td>';   
                            echo '</tr>';
                            }
                         echo '</table>';
                       
                    ?>					
                </div>	
                    
                    <a href="make_reservation.php">Go back to Make Reservation Page</a> 
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