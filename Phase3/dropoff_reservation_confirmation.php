<?php 
function yearDropdown($startYear, $endYear, $id="year"){ 
    //start the select tag 
    echo "<select id=".$id." name=".$id.">n"; 
          
        //echo each year as an option     
        for ($i=$startYear;$i<=$endYear;$i++){ 
        echo "<option value=".$i.">".$i."</option>n";     
        } 
      
    //close the select tag 
    echo "</select>"; 
} 
?>



<?php
include('lib/common.php');
// written by Team008
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
	    exit(); 
    }
    $clerkusername = $_SESSION['username'];
    // ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
    $query = "SELECT Round(Sum(Tools.purchase_price * 0.4), 2) AS 'deposit', CONCAT(first_name, ' ', middle_name, ' ', last_name) AS 'Full Name', 
    Round(sum(Tools.purchase_price * 0.15 * DATEDIFF(Reservation.reservation_end_date , Reservation.reservation_start_date)), 2) AS 'rental_price'  " .
    "FROM Reservation INNER JOIN Customer ON Reservation.customer_username=Customer.username 
    INNER JOIN User ON Customer.username = User.username
    INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id" .
    " WHERE Reservation.reservation_id='{$_SESSION['reservation_id']}'";
    $query_name = "SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) AS 'Full Name' FROM User WHERE User.username = '{$_SESSION['username']}'";
    $result_name = mysqli_query($db, $query_name);
    $row2 = mysqli_fetch_array($result_name, MYSQLI_ASSOC);
    
    $result = mysqli_query($db, $query);








    include('lib/show_queries.php');
 
    if ( !is_bool($result) && (mysqli_num_rows($result) > 0) ) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        array_push($error_msg,  "Query ERROR: Failed to get reservation information...<br>" . __FILE__ ." line:". __LINE__ );
    }

    $query_tool = "SELECT Tools.tool_id,  
    Round(Tools.purchase_price * 0.4,2) AS 'deposit', CONCAT(IF(power_source = 'manual', '',CONCAT(Tools.power_source, ' ')), Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, ' ')AS 'tool_name',
    Round((Tools.purchase_price * 0.15 * DATEDIFF(Reservation.reservation_end_date , Reservation.reservation_start_date)), 2) AS 'rental_price' " .
    "FROM Reservation INNER JOIN Tools ON Reservation.tool_id = Tools.tool_id
    INNER JOIN Toolinfo ON Toolinfo.tool_id = Tools.tool_id" .
    " WHERE Reservation.reservation_id='{$_SESSION['reservation_id']}'ORDER BY Tools.tool_id ";
    $result_tool = mysqli_query($db, $query_tool);
    if( $_SERVER['REQUEST_METHOD'] == 'POST'){
         $reservation_id = $_SESSION['reservation_id'];
        while($row_tool = mysqli_fetch_assoc($result_tool)) {
        $tool_id = $row_tool['tool_id'];
        $user_query = "INSERT INTO DropOff(clerk_username, reservation_id, tool_id) VALUES('$clerkusername','$reservation_id', '$tool_id')";
        $user_result = mysqli_query($db, $user_query);
        }
        
        /*$content = $_post['content'];
        include_once （'dompdf_config.inc.php')
        $dompdf = new DOMPDF();
        $dompdf -> load_html($content);
        $dompdf -> render();
        $dompdf -> stream('contract.pdf');
        
        
        require("html2fpdf.php"); 
        $htmlFile = "dropoff_reservation_confirmation.php"; 
        $buffer = file_get_contents($htmlFile); 

        $pdf = new HTML2FPDF('P', 'mm', 'Legal'); 
        $pdf->AddPage(); 
        $pdf->WriteHTML($buffer); 
        $pdf->Output('my.pdf', 'F'); */
        
        
            
        header(REFRESH_TIME . 'url=dropoff_reservation.php');
        
     }

?>
<?php include("lib/header.php"); ?>



<html>

<head>
    <title>Drop Off Reservation</title>

</head>
    <body>
      <div id = "main_container">
          <?php include("lib/clerk_menu.php"); ?>
        <div class = "center_content">    

           <form action = "dropoff_reservation_confirmation.php" method = "post" style = "width: 750px">
            <left><h2>Drop Off Reservation</h2></left>

            
            <div class = "creditCardSelection">
                    <div class="subtitle">Rental Contract</div>   
                    <table>
                        <tr>
                            <td class="item_label">Drop Off Clerk</td>
                            <td>
                                <?php print $row2['Full Name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Customer Name</td>
                            <td>
                                <?php print $row['Full Name'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Total Deposit</td>
                            <td>
                                <?php print $row['deposit'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Total Rental Price</td>
                            <td>
                                <?php print $row['rental_price'];?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="item_label">Total Due</td>
                            <td>
                                <?php print $row['rental_price'] - $row['deposit'];?>
                            </td>
                        </tr>

                    </table>						
              
                  
           
           <br>
               
               
               
               
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

                <input type = "submit" name = "print_btn" value = "Print Receipt" style = "font-size:10pt;color:white; background-color:green;" />	

               
               
                <?php include("lib/error.php"); ?>

                <div class="clear"></div>
            </div>
               
           </form> 

           </div> 
         
            

      </div> 
        
    </body>
</html>

