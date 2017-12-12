 <?php


include('lib/common.php');
// written by Team008

if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}

/* if form is submitted, then execute query to search for tools */
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   
    $startdate = mysqli_real_escape_string($db, $_POST['startdate']);
	$enddate= mysqli_real_escape_string($db, $_POST['enddate']);
	$searchkey = mysqli_real_escape_string($db, $_POST['searchkey']); 
    $selecttype = mysqli_real_escape_string($db, $_POST['tool_type']); 
    $selectpowersource = mysqli_real_escape_string($db, $_POST['power_source']); 
    $selectsubtype = mysqli_real_escape_string($db, $_POST['sub_type']);
   
    
    $query = "SELECT Tools.tool_id AS 'Tool ID', 
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
                    <div class="subtitle">Check Tool Availability</div>
                     <br/>
                       <div>
                           <form name="search_tool" action = "check_tool_availability.php" method= "POST">
                            <strong>Start Date: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>End Date:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Customer Search:</strong>
                             <br/>
                              <input type="date" name="startdate" style = "width:200px" value="<?php echo "$startdate"; ?>"required /> 
                              <input type="date" name="enddate" style = "width:200px" value="<?php echo "$enddate"; ?>"required/> 
                              <input type="text" name="searchkey" placeholder ="Enter Keyword" style = "width:250px" value="<?php echo "$searchkey"; ?>"/>
                              <input type="submit" name="submit_search" value="Search"/>
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
                    <div class="search_result_section">
                    <div class="subtitle">Available Tools</div>  
                   
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
                       if (!is_bool($result) && (mysqli_num_rows($result) > 0) ){
		 		            echo '<table>';
                            echo '<th>Tool ID';
                            echo '<th>Description</th>';
                            echo '<th>Rental Price</th>';
                            echo '<th>Deposit Price</th>';
                            while($row_result = mysqli_fetch_assoc($result)) {
                            echo '<tr align ="center">';
                            echo '<td width = "20px">'.$row_result['Tool ID'].'</td>';
                            echo "<td width = 200px><a href=tool_detail.php?link=" . $row_result['Tool ID'] . ">".$row_result['Description']."</a></td>";
                            echo '<td width = "100px">'.$row_result['Rental Price'].'</td>';
                            echo '<td width = "100px">'.$row_result['Deposit Price'].'</td>';
                            echo '</tr>';
                            }
                         echo '</table>';
                        } else {
                            echo 'Nothing Found at this moment';
                        }     
                    ?>					
                </div>
                	
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


