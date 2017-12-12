

 <?php
session_start();
include('lib/common.php');
// written by Team008

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}
 $customerusername = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $startdate = mysqli_real_escape_string($db, $_POST['startdate']);
	$enddate= mysqli_real_escape_string($db, $_POST['enddate']);
    $rentalstartdate = mysqli_real_escape_string($db, $_POST['rentalstartdate']);
	$rentalenddate= mysqli_real_escape_string($db, $_POST['rentalenddate']);
	$searchkey = mysqli_real_escape_string($db, $_POST['searchkey']); 
    $selecttype = mysqli_real_escape_string($db, $_POST['tool_type']); 
    $selectpowersource = mysqli_real_escape_string($db, $_POST['power_source']); 
    $selectsubtype = mysqli_real_escape_string($db, $_POST['sub_type']);
    $startdate1 = new DateTime($rentalstartdate);
    $enddate1 = new DateTime($rentalenddate);
    $interval = date_diff($startdate1,$enddate1);
     
    
    $query ="SELECT Tools.tool_id AS 'Tool ID', 
             CONCAT (IF(Tools.power_source = 'Manual', '',  
             CONCAT(Tools.power_source, ' ' )), Toolinfo.tool_suboption, ' ',  Toolinfo.tool_subtype)AS 'Description', 
             ROUND ((Tools.purchase_price * .15), 2) AS 'Rental Price', 
             ROUND ((Tools.purchase_price * .40), 2) AS 'Deposit Price' 
             FROM Tools 
             INNER JOIN Toolinfo ON Tools.tool_id = Toolinfo.tool_id 
             WHERE 
             Tools.tool_id IN (SELECT Tools.tool_id FROM Tools LEFT OUTER JOIN Reservation ON Tools.tool_id = Reservation.tool_id
             WHERE  
             Reservation.reservation_start_date is NULL OR Reservation.reservation_start_date > ' $enddate ' 
             OR Reservation.reservation_end_date is NULL OR Reservation.reservation_end_date < ' $startdate ')
             ";
    
           if (!empty($searchkey)) {
            $query = $query . "AND
             Tools.tool_id IN (SELECT Tools.tool_id FROM Tools INNER JOIN Toolinfo ON Tools.tool_id = Toolinfo.tool_id WHERE
             CONCAT(Toolinfo.tool_type,Toolinfo.tool_subtype,Toolinfo.tool_suboption, Tools.power_source) LIKE '%$searchkey%')";
           }
    
           if ($selecttype == 'All Tools') {
			          $query = $query; }
            else {
            $query = $query . "AND Toolinfo.tool_type = '$selecttype'";
            }
            
            if ( strlen($selectpowersource) == 0) {
                $query = $query;  }
            else {
             $query = $query . "And Tools.power_source = '$selectpowersource'";
            }

            if (strlen($selectsubtype) == 0) {
                $query = $query;  }
            else {
             $query = $query . "And Toolinfo.tool_subtype = '$selectsubtype'";
            }                                     
    
     $query = $query . " ORDER BY Tools.tool_id";

     $result = mysqli_query($db, $query);
    
     include('lib/show_queries.php');  
    
     if (mysqli_affected_rows($db) == -1) {
        array_push($error_msg,  "SELECT ERROR:Failed to find tool... <br>" . __FILE__ ." line:". __LINE__ );
    } 
     if (mysqli_affected_rows($db) >= 10) {
        array_push($error_msg,  "SELECT Hint:Please specify a more unique search... <br>" . __FILE__ ." line:". __LINE__ );
    } 
    
   }    

   ?>
    

<?php include("lib/header.php"); ?>              
<html>

<body>
<div id="main_container">
    <?php include("lib/customer_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
            </div>          
            <div class="features">   
                <div class="check_tool_availability_section">
                    <div class="subtitle">Make Reservation</div>
                     <br/>
                       <div>
                           <form name="search_tool" action = "make_reservation.php?" method= "POST">
                            <strong>Start Date: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>End Date:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Customer Search:</strong>
                             <br/>
                              <input type="date" name="startdate" data-date-format="MM-DD-YYYY" style = "width:200px" value="<?php echo "$startdate"; ?>"required /> 
                              <input type="date" name="enddate" data-date-format="MM-DD-YYYY" style = "width:200px" value="<?php echo "$enddate"; ?>"required/> 
                              <input type="text" name="searchkey" placeholder ="Enter Keyword" style = "width:250px" value="<?php echo "$searchkey"; ?>"/>
                              <input type="submit" name="submit_search" class="btnSubmitAction" value="Search"/>
                              <br/>
                              <br/>
                              <strong>Type:</strong>
                            <input type="radio" name="tool_type" value="All Tools" checked/>All Tools
                            <input type="radio" name="tool_type" value="Hand Tool"/> Hand Tool
                            <input type="radio" name="tool_type" value="Garden Tool"/> Garden Tool
                            <input type="radio" name="tool_type" value="Ladder"/> Ladder
                            <input type="radio" name="tool_type" value="Power Tool"/>Power Tool
                            <br/>
                              <br/>
                            <strong>Power Source: </strong><select name="power_source" style = "width:250px">
                            <option value=""> </option>
                            <option value="electric(A/C)">electric(corded)</option>
                            <option value="cordless(D/C)">battery powered(cordless)</option>
                            <option value="gas">gas-powered</option>
                            <option value="manual">manual</option>
                            </select>
                            <strong>Sub-Type:</strong><select name="sub_type" style = "width:250px" onchange="generateSuboption()">
                            <option value=""> </option>
                            <option value="Screwdriver">Screwdriver</option>
                            <option value="Socket">Socket</option>
                            <option value="Ratchet">Ratchet</option>
                            <option value="Wrench">Wrench</option>
                            <option value="Pliers">Pliers</option>
                            <option value="Gun">Gun</option>
                            <option value="Hammer">Hammer</option>
                            </select> 
                           </form>
                    </div>        
                <br/>
                   		
             
        <br/>
              <hr>  
                 <div class="make_reservation_section">
                  <div class="subtitle"></div>       
        </div>
         </div> 
            </div>			
        </div>
        <?php
         session_start();
         require_once("dbcontroller1.php");
        $db_handle = new DBController();
        if(!empty($_GET["action"])) {
            echo $item["rentalstartdate"];
            //$currentstartdate = $startdate;
            //echo "currentstartdate=".$currentstartdate;
             switch($_GET["action"]) {
                     
	   case "add":
           
		//if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT Tools.tool_id AS 'Tool ID', 
             CONCAT (IF(Tools.power_source = 'Manual', '',  
             CONCAT(Tools.power_source, ' ' )), Toolinfo.tool_suboption, ' ',  Toolinfo.tool_subtype)AS 'Description', 
             ROUND ((Tools.purchase_price * .15), 2) AS 'Rental Price', 
             ROUND ((Tools.purchase_price * .40), 2) AS 'Deposit Price' 
             FROM Tools 
             INNER JOIN Toolinfo ON Tools.tool_id = Toolinfo.tool_id 
             WHERE Tools.tool_id='" . $_GET["code"] . "'");
			
            $itemArray = array($productByCode[0]["Tool ID"]=>array('Tool ID'=>$productByCode[0]["Tool ID"], 'Description'=>$productByCode[0]["Description"], 'quantity'=>$_POST["quantity"], 'rentalstartdate'=>$_POST["rentalstartdate"],'rentalenddate'=>$_POST["rentalenddate"], 'Rental Price'=>$productByCode[0]["Rental Price"], 'rentaldays'=>$interval ->format('%a'), 'Deposit Price'=>$productByCode[0]["Deposit Price"]));
			
			if(!empty($_SESSION["cart_item"])) {
				//if(in_array($productByCode[0]["Tool ID"],array_keys($_SESSION["cart_item"]))) {
					//foreach($_SESSION["cart_item"] as $k => $v) {
							//if($productByCode[0]["Tool ID"] == $k) {
								/*if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}*/
								//$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							//}
					//}
				//} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				//}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		//}
	break;
                     
    case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;              
                    
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
    case "reserve": 
           
            $count_cart_item=0;
            $latest_reservation_id = 0;
            foreach ($_SESSION["cart_item"] as $item){         
            
               
            if($count_cart_item==0){
                $reservation_id_query="SELECT reservation_id from Reservation ORDER BY reservation_id desc limit 1";
                    $reservation_id_query_result = mysqli_query($db, $reservation_id_query);
                    //$reservation_id_count = mysqli_num_rows($reservation_id_query_result); 
                    //echo "reservation_id_count =".$reservation_id_count;
                    
                    $reservation_id_query_row = mysqli_fetch_array($reservation_id_query_result);
                         
                      echo "reservation_id_query_result=".$reservation_id_query_row["reservation_id"];
                    $latest_reservation_id = $reservation_id_query_row["reservation_id"]+1;
                $reserve_query= "INSERT INTO Reservation (reservation_id,tool_id, reservation_start_date, reservation_end_date, customer_username) VALUES
            ('".$latest_reservation_id."','".$item["Tool ID"]."','".$item["rentalstartdate"]."', '".$item["rentalenddate"]."','$customerusername')";
                echo $reserve_query;
                $reserve_result = mysqli_query($db, $reserve_query);
                if(!$reserve_result)array_push($error_msg,  "reserve_result went wrong, try again later...");
                 
             
              
            }
                 
                else{
                   
                    $reserve_query= "INSERT INTO Reservation (reservation_id, tool_id, reservation_start_date, reservation_end_date, customer_username) VALUES ('".$latest_reservation_id."',".$item["Tool ID"].",'".$item["rentalstartdate"]."', '".$item["rentalenddate"]."','$customerusername')";
                    echo $reserve_query;
                
                $reserve_result = mysqli_query($db, $reserve_query);
                if(!$reserve_result)array_push($error_msg,  "reserve_result went wrong, try again later...");
                    
                }
                $count_cart_item++;
            }
                echo'<script> window.location="reservation_confirmation.php?reservationid=' . $latest_reservation_id . '"; </script> ';   
                unset($_SESSION["cart_item"]);    
                     
     break;	    
}
     
            
}
        


        
?>
<HTML>
<HEAD>
<TITLE>Make Reservation</TITLE>
<link href="css/cartstyle.css" type="text/css" rel="stylesheet" />
</HEAD>

 <div class="subtitle">Add Tools to Reservation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a type="btnReserve" href="make_reservation.php?action=reserve&code=<?php echo "startdate=".$startdate; ?>">Submit Reservation</a></div>

<div id="shopping-cart">
<div class="txt-heading">Shopping Cart<a id="btnEmpty" href="make_reservation.php?action=empty">Empty Cart</a>
  </div>

  
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
      

<table>

   
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


<tbody>
<tr>
<th><strong>Tool ID</strong></th>
<th><strong>Description</strong></th>
<th><strong>Rental Price/Day</strong></th>
<th><strong>Deposit Price</strong></th>
<th><strong>Start Date</strong></th>
<th><strong>End Date</strong></th>
<th><strong>Rental Days</strong></th>
<th><strong>Action</strong></th>
</tr>	
<?php	
    $count_tools = 0;
    foreach ($_SESSION["cart_item"] as $item){
		?>

				<tr>
				<td><strong><?php echo $item["Tool ID"]; ?></strong></td>
				<td><?php echo '<a href=tool_detail.php?link='.$item["Tool ID"].'>'.$item["Description"].'</a>'; ?></td>	
				<td><?php echo $item["Rental Price"]; ?></td>
				<td><?php echo $item["Deposit Price"]; ?></td>
				<td><?php echo $item["rentalstartdate"]; ?></td>
				<td><?php echo $item["rentalenddate"]; ?></td>
				<td><?php echo $item["rentaldays"]; ?></td>	
				<td><a href="make_reservation.php?action=remove&code=<?php echo $item["Tool ID"]; ?>" class="btnRemoveAction">Remove</a></td>
				</tr>
               
				<?php
           $item_rental += ($item["Rental Price"]*$item["rentaldays"]);
          $item_deposit += ($item["Deposit Price"]);
        $item_total += ($item["Rental Price"]*$item["rentaldays"]+$item["Deposit Price"]);
    
        $count_tools++;
        
        if($count_tools >= 10){
            $error = true;
            array_push($error_msg,  "Please Reduce Number of Tools to 10!"); 
        }
		}
    
    
		?>
		
		
		

<tr>
<td colspan="2" align=left><strong>Rental Summary</strong></td>
<td colspan="2" align=left><strong>Total Rental Price:</strong> <?php echo "$".$item_rental; ?></td>
<td colspan="2" align=left><strong>Total Deposit Price:</strong> <?php echo "$".$item_deposit; ?></td>
<td colspan="2" align=left><strong>Totals:</strong> <?php echo "$".$item_total; ?></td>
</tr>
</tbody>
</table>		
  <?php
}
?>
</div>






<div id="product-grid">
	<div class="txt-heading">Available Tools</div>
	<?php
    session_start();
	$product_array = $db_handle->runQuery($query);
    $_SESSION["tool_item"] = $product_array;
    $count_k=0;
    while (list($key, $value) = each($_SESSION)){
        $count_k++;
	if (!empty($product_array)) {
        
		foreach($product_array as $key=>$value){
            
                
	?>
		<div class="product-item">
			<form method="post" action="make_reservation.php?action=add&code=<?php echo $product_array[$key]["Tool ID"]; ?>">
			<div><strong><?php echo "Tool ID:".$product_array[$key]["Tool ID"]; ?></strong></div>
			<div><strong><?php echo '<a href=tool_detail.php?link='.$product_array[$key]["Tool ID"].'>'.$product_array[$key]["Description"].'</a>'; ?></strong></div>
        	<div class="product-rental-price"><?php echo "Rental Price/Day: $".$product_array[$key]["Rental Price"]; ?></div>
			<div class="product-deposit-price"><?php echo "Deposit Price/Order: $".$product_array[$key]["Deposit Price"]; ?></div>
             <div><?php echo"Start From:"; ?><input type="date" style = "width:120px" name="rentalstartdate" required /></div>
             <div><?php echo"Rent Unill:"; ?><input type="date" style = "width:120px" name="rentalenddate" required /></div>
             <div><input type="submit" value="Add to cart" class="btnAddAction" /></div>
			</form>
		</div>
	<?php
			}
	
        
    }
        if($count_k>0)break;
    }
   
	?>
</div>
<div>
 
</div>


</HTML>

        	   <?php include("lib/error.php"); ?>
        	<div class="clear"></div> 		
			</div>    
               <?php include("lib/footer.php"); ?>	
            </div>
   
    </body>
</html>

