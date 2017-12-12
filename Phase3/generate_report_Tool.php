<?php

include('lib/common.php');
// written by Team008, xwang875
if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");  
}
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}

$query_temp1 ="CREATE TEMPORARY TABLE toolInfo AS
SELECT T.tool_id, T.power_source, T.purchase_price, Tio.tool_type, Tio.tool_subtype, Tio.tool_suboption
FROM tools AS T NATURAL JOIN toolinfo AS Tio;";
mysqli_query($db, $query_temp1);

$query_temp2 = "CREATE TEMPORARY TABLE toolInfoService AS
SELECT TI.tool_id, TI.power_source, TI.purchase_price, TI.tool_type, TI.tool_subtype, TI.tool_suboption, SO.service_id, SO.service_start_date, SO.service_end_date, SUM(SO.repair_cost) AS repair_cost
FROM toolInfo AS TI LEFT OUTER JOIN serviceorder AS SO ON TI.tool_id = SO.tool_id
GROUP BY tool_id;";
mysqli_query($db, $query_temp2);

$query_temp3 = "CREATE TEMPORARY TABLE toolInfoServiceSale AS
SELECT TIS.tool_id, TIS.power_source, TIS.purchase_price, TIS.tool_type, TIS.tool_subtype, TIS.tool_suboption, TIS.service_start_date, TIS.service_end_date, TIS.repair_cost, SAO.for_sale_date, SAO.sold_date
FROM toolInfoService AS TIS LEFT OUTER JOIN saleorder SAO ON TIS.tool_id =SAO.tool_id;";
mysqli_query($db, $query_temp3);

$query_temp4 = "CREATE TEMPORARY TABLE toolInfoServiceSaleRented AS
SELECT TISS.tool_id, TISS.power_source, TISS.purchase_price, TISS.tool_type, TISS.tool_subtype, TISS.tool_suboption, TISS.service_start_date, TISS.service_end_date, TISS.repair_cost, TISS.for_sale_date, TISS.sold_date, R.rented_reservation_id, R.rented_start_date, R.rented_end_date
FROM toolInfoServiceSale AS TISS LEFT OUTER JOIN rented AS R ON TISS.tool_id =R.tool_id;";
mysqli_query($db, $query_temp4);

$query_temp5 = "CREATE TEMPORARY TABLE toolRentedDays AS
SELECT tool_id, SUM(DATEDIFF(rented_end_date , rented_start_date)) AS rentedDays
FROM toolInfoServiceSaleRented
GROUP BY tool_id;";
mysqli_query($db, $query_temp5);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $toolType = mysqli_real_escape_string($db, $_POST['tool_type']);
    $searchkey = mysqli_real_escape_string($db, $_POST['searchkey']);
    $query_tool = 'SELECT * FROM toolInfoServiceSaleRented WHERE TRUE ';
    if (!empty($searchkey)) {
             $query_tool = $query_tool . "AND 
             (CONCAT(tool_type, tool_subtype, tool_suboption, power_source) LIKE '%$searchkey%') ";
    }
    switch ($toolType){
        case 'All Tools':
            $query_tool = $query_tool . 'GROUP BY tool_id;';
            $result_tool = mysqli_query($db, $query_tool);
            break;
        case 'Hand Tool':
            $query_tool = $query_tool . 'AND tool_type = "Hand Tool" GROUP BY tool_id;';
            $result_tool = mysqli_query($db, $query_tool);
            break;
        case 'Garden Tool':
            $query_tool = $query_tool . 'AND tool_type = "Garden Tool" GROUP BY tool_id;';
            $result_tool = mysqli_query($db, $query_tool);
            break;
        case 'Ladder':
            $query_tool = $query_tool . 'AND tool_type = "Ladder" GROUP BY tool_id;';
            $result_tool = mysqli_query($db, $query_tool);
            break;
        case 'Power Tool':
            $query_tool = $query_tool . 'AND tool_type = "Power Tool" GROUP BY tool_id;';
            $result_tool = mysqli_query($db, $query_tool);
    }
}
?>


<?php include("lib/header.php"); ?>
<html>
<head>
<title>Tool Inventory Report</title>
</head>

<body>
<div id="main_container">
    <div id="header">
                <div class="logo"><img src="img/tools_for_rent.png" style="opacity:1.0;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/></div>
			</div>
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">Tool Inventory Report</div>
                    <p>The list of tools where their total profit and cost are shown for all time.</p>
                    <form name = "filer_tool_type" action = "generate_report_Tool.php" method = "POST">
                        <table>
                            <th><strong>Type:</strong></th>
                            <th><strong>Custom Search:</strong></th>
                            <tr>
                            <td>
                            <input type="radio" name="tool_type" value="All Tools" checked/> All Tools
                            <input type="radio" name="tool_type" value="Hand Tool"/> Hand Tool
                            <input type="radio" name="tool_type" value="Garden Tool"/> Garden Tool
                            <input type="radio" name="tool_type" value="Ladder"/> Ladder
                            <input type="radio" name="tool_type" value="Power Tool"/>Power Tool
                            </td>
                            <td>
                            <input type="text" name="searchkey" placeholder ="Enter Keyword" style = "width:200px" value="<?php echo "$searchkey"; ?>"/>
                            <input type="submit" name="search_btn" value="Search" />
                            </td>
                            </tr>
                        </table>
                    </form>
                    <br/>
                    <?php 
                            echo '<table>';
                            echo '<th>Tool ID</th>';
                            echo '<th>Current Status</th>';
                            echo '<th>Date</th>';
                            echo '<th>Description</th>';
                            echo '<th>Rental Profit</th>';
                            echo '<th>Total Cost</th>';
                            echo '<th>Total Profit</th>';
                    
                            while($row_tool = mysqli_fetch_assoc($result_tool)) {
                            $toolID = $row_tool['tool_id'];
                            $sale_price = 0;
                            //deal with the status
                            if ($row_tool['sold_date'] != NULL){
                                $toolStatus = '<div style="text-align:center; height:25px; background-color:black">Sold<div>';
                                $sale_price = $row_tool['purchase_price'] * 0.5;
                                $toolDate = $row_tool['sold_date'];
                            }
                            else if ($row_tool['for_sale_date'] != NULL){
                                $toolStatus = '<div style="text-align:center; height:25px; background-color:grey">For-Sale<div>';
                                $toolDate = $row_tool['for_sale_date'];
                            }
                            else {
                                if ($row_tool['service_start_date'] != NULL && $row_tool['service_end_date'] != NULL) {
                                $startDate = strtotime($row_tool['service_start_date']);
                                $endDate = strtotime($row_tool['service_end_date']);
                                $currentDate = strtotime(date("Y-m-d"));
                                if ($startDate < $currentDate && $currentDate < $endDate) {
                                    $toolStatus = '<div style="text-align:center; height:25px; background-color:red">In-Repair<div>';
                                    $toolDate = $row_tool['service_start_date'];
                                    } else {
                                    $toolStatus = '<div style="text-align:center; height:25px;background-color:green">Available</div>';
                                    $toolDate = '';
                                    }
                                }
                                else if ($row_tool['rented_start_date'] != NULL && $row_tool['rented_end_date'] != NULL) {
                                $rentStartDate = strtotime($row_tool['rented_start_date']);
                                $rentEndDate = strtotime($row_tool['rented_end_date']);
                                $currentDate = strtotime(date("Y-m-d"));
                                if ($rentStartDate < $currentDate && $currentDate < $rentEndDate) {
                                    $toolStatus = '<div style="text-align:center; height:25px; background-color:yellow">Rented<div>';
                                    $toolDate = $row_tool['rented_start_date'];
                                    } else {
                                    $toolStatus = '<div style="text-align:center; height:25px;background-color:green">Available</div>';
                                    $toolDate = '';
                                    }
                                }
                                else {
                                    $toolStatus = '<div style="text-align:center; height:25px;background-color:green">Available</div>';
                                    $toolDate = '';
                                }
                            }
                            //deal with the short description
                            if ($row_tool['power_source'] == 'manual'){
                                $toolDescription = $row_tool['tool_suboption'].' '.$row_tool['tool_subtype'];
                            } else {
                                $toolDescription = $row_tool['power_source'].' '.$row_tool['tool_suboption'].' '.$row_tool['tool_subtype'];
                            }
                            //deal with the rental profit
                            $rentedDay_query = "SELECT rentedDays FROM toolRentedDays WHERE tool_id = '$toolID'";
                            $rentedDay = mysqli_query($db, $rentedDay_query);
                            $days = mysqli_fetch_assoc($rentedDay);
                            //echo $days['rentedDays'];
                            if ($days['rentedDays'] == NULL) {
                                $days['rentedDays'] = 0;
                            }
                            $rentalPrice = $row_tool['purchase_price']*0.15;
                            $rentalProfit = $rentalPrice * $days['rentedDays'];
                            //deal with the repair cost
                            if ($row_tool['repair_cost'] == NULL){
                                $repairCost = 0;
                            } else {
                                $repairCost = $row_tool['repair_cost'];
                            }
                            $totalProfit = $rentalProfit - $repairCost + $sale_price;
                            echo '<tr>';
                            echo '<td width = "10px">'.$toolID.'</td>';
                            echo "<td width = '10px'>".$toolStatus.'</td>';
                            echo '<td width = "80px">'.$toolDate.'</td>';
                            echo "<td width = 140px><a href='clerk_tool_detail.php?link=$toolID' target = '_blank'>".$toolDescription.'</a></td>';
                            echo '<td width = "80px" align="center">$'.$rentalProfit.'</td>';
                            echo '<td width = "80px" align="center">$'.$repairCost.'</td>';
                            echo '<td width = "80px" align="center">$'.$totalProfit.'</td>';
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