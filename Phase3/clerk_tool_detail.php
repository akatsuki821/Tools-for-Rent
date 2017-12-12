<?php

include('lib/common.php');
// written by Team008


if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit(); 
}


$toolid = $_GET['link'];

//$query_toolid = "SELECT Tools.tool_id AS 'Tool ID' FROM Tools WHERE Tools.tool_id = '$toolid'";
/*$query_tooltype = "SELECT Toolinfo.tool_type AS 'Tool Type' FROM Toolinfo WHERE Toolinfo.tool_id = '$toolid'";
$query_shortdescription = "SELECT CONCAT(IF(power_source = 'manual', '', CONCAT(T.power_source, ' ')),Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype) AS 'Short Description' FROM Tools AS T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id WHERE T.tool_id = '$toolid'";

$query_fulldescription_power = "SELECT CONCAT(T.width_or_diameter, ' in.W× ', T.length, ' in.L ', T.weight, ' lb. ', T.power_source, ' ', Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, PowerTools.volt_rating, ' Volt ', PowerTools.amp_rating, ' Amp ', PowerTools.min_rpm_rating, ' RPM ', PowerTools.max_rpm_rating , ' ft_lb.', ' by ', T.manufacturer) AS 'Full Description' FROM Tools AS T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id INNER JOIN PowerTools on T.tool_id = PowerTools.tool_id WHERE T.tool_id = '$toolid'";

$query_full_manual = "SELECT CONCAT(T.width_or_diameter, ' in.W× ', T.length, ' in.L ', T.weight, ' lb. ', Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, ' by ', T.manufacturer) AS 'Full Description' FROM Tools as T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id WHERE T.tool_id = '$toolid'";

$query_depositprice = "SELECT ROUND ((T.purchase_price * .40), 2) AS 'Deposit Price' FROM Tools AS T WHERE T.tool_id = '$toolid'";
$query_rentalprice = "SELECT ROUND ((T.purchase_price * .15), 2) AS 'Rental Price' FROM Tools AS T WHERE T.tool_id = '$toolid'";
$query_accessories = "SELECT CONCAT('(', Power_Accessories.quantity, ')', PowerTools.volt_rating, ' Volt ', PowerTools.amp_rating, ' Amp ', Power_Accessories. battery_type, accerssory_description) AS 'Accessories' FROM 
((Tools as T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id) INNER JOIN PowerTools on T.tool_id = PowerTools.tool_id INNER JOIN Power_Accessories on T.tool_id = Power_Accessories.tool_id) WHERE T.power_source != 'manual' AND T.tool_id = '$toolid'";*/
function decimalToFraction($decimal)
{
    if ($decimal < 0 || !is_numeric($decimal)) {
        // Negative digits need to be passed in as positive numbers
        // and prefixed as negative once the response is imploded.
        return false;
    }
    if ($decimal == 0) {
        return [0, 0];
    }

    $tolerance = 1.e-4;

    $numerator = 1;
    $h2 = 0;
    $denominator = 0;
    $k2 = 1;
    $b = 1 / $decimal;
    do {
        $b = 1 / $b;
        $a = floor($b);
        $aux = $numerator;
        $numerator = $a * $numerator + $h2;
        $h2 = $aux;
        $aux = $denominator;
        $denominator = $a * $denominator + $k2;
        $k2 = $aux;
        $b = $b - $a;
    } while (abs($decimal - $numerator / $denominator) > $decimal * $tolerance);

    return [
        $numerator,
        $denominator
    ];
}

$query_tooltype = "SELECT Toolinfo.tool_type AS 'Tool Type' FROM Toolinfo WHERE Toolinfo.tool_id = '$toolid'";

$query = "SELECT CONCAT(IF(power_source = 'manual', '', CONCAT(T.power_source, ' ')),Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype) AS 'Short Description',  ROUND ((T.purchase_price * .40), 2) AS 'DepositPrice', ROUND ((T.purchase_price * .15), 2) AS 'RentalPrice' FROM Tools as T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id WHERE T.tool_id = '$toolid'";

$widthquery = "SELECT CAST(T.width_or_diameter AS DECIMAL(10, 3)) AS width FROM Tools AS T WHERE T.tool_id = '$toolid'";
$lengthquery = "SELECT CAST(T.length AS DECIMAL(10,3)) AS length FROM Tools AS T WHERE T.tool_id = '$toolid'";

$result_width = mysqli_query($db, $widthquery);
$result_length = mysqli_query($db, $lengthquery);

if ( !is_bool($result_width) && (mysqli_num_rows($result_width) > 0) && !is_bool($result_length) && (mysqli_num_rows($result_length) > 0)) {   
        
        $row_width = mysqli_fetch_array($result_width, MYSQLI_ASSOC);
        $widthN = floor($row_width['width']);
        $widthD = $row_width['width'] - $widthN;
    
        $row_length = mysqli_fetch_array($result_length, MYSQLI_ASSOC);
        $lengthN =floor($row_length['length']);
        $lengthD = $row_length['length'] - $lengthN;
    
        $widthArray = decimalToFraction($widthD);
        $lengthArray = decimalToFraction($lengthD);
        //$width_length_descrip = "{$widthArray[0]}/{$widthArray[1]} in. W × {$lengthArray[0]}/{$lengthArray[1]} in. L ";
        
        $width_length_descrip = "{$widthN}-{$widthArray[0]}/{$widthArray[1]} in. W × {$lengthN}-{$lengthArray[0]}/{$lengthArray[1]} in. L ";
                
    }
else{
    array_push($error_msg,  "Query ERROR: Failed to get tool's width and length <br>" . __FILE__ ." line:". __LINE__ );
    
}



//SELECT CAST(width_or_diameter AS DECIMAL) AS "WIDTH" FROM Tools where Tools.tool_id = 1

/*$query_power = "SELECT CONCAT(T.width_or_diameter, ' in.W× ', T.length, ' in.L ', T.weight, ' lb. ', T.power_source, ' ', Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, PowerTools.volt_rating, ' Volt ', PowerTools.amp_rating, ' Amp ', PowerTools.min_rpm_rating, ' RPM ', PowerTools.max_rpm_rating , ' ft_lb.', ' by ', T.manufacturer) AS 'FullDescription', CONCAT('(', Power_Accessories.quantity, ')', PowerTools.volt_rating, ' Volt ', PowerTools.amp_rating, ' Amp ', Power_Accessories. battery_type, accerssory_description) AS 'Accessories' FROM Tools AS T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id INNER JOIN PowerTools on T.tool_id = PowerTools.tool_id INNER JOIN Power_Accessories on T.tool_id = Power_Accessories.tool_id WHERE T.power_source != 'manual' AND T.tool_id = '$toolid'";*/

$query_power = "SELECT CONCAT(T.weight, ' lb. ', T.power_source, ' ', Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, ' ', IF(T.power_source = 'cordless(D/C)', '', CONCAT(PowerTools.volt_rating, ' V ', ' ')), PowerTools.amp_rating, ' A ', PowerTools.min_rpm_rating, ' RPM ', PowerTools.max_rpm_rating , ' ft_lb.', ' by ', T.manufacturer) AS 'FullDescription', CONCAT('(', Power_Accessories.quantity, ')', Power_Accessories. battery_type, accerssory_description) AS 'Accessories' FROM Tools AS T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id INNER JOIN PowerTools on T.tool_id = PowerTools.tool_id INNER JOIN Power_Accessories on T.tool_id = Power_Accessories.tool_id WHERE T.power_source != 'manual' AND T.tool_id = '$toolid'";

$query_manual = "SELECT CONCAT(T.weight, ' lb. ', Toolinfo.tool_suboption, ' ', Toolinfo.tool_subtype, ' by ', T.manufacturer) AS 'FullDescription' FROM Tools as T INNER JOIN Toolinfo on T.tool_id = Toolinfo.tool_id WHERE T.tool_id = '$toolid'";




//$result_toolid = mysqli_query($db, $query_toolid);
$result_tooltype = mysqli_query($db, $query_tooltype);
$result_query = mysqli_query($db, $query);
$result_power = mysqli_query($db, $query_power);
$result_manual = mysqli_query($db,$query_manual);

/*$result_depositprice = mysqli_query($db, $query_depositprice);
$result_rentalprice = mysqli_query($db, $query_rentalprice);
$result_accessories = mysqli_query($db, $query_accessories);*/

include('lib/show_queries.php');

  if ( !is_bool($result_query) && (mysqli_num_rows($result_query) > 0)) {
        $row_query = mysqli_fetch_array($result_query, MYSQLI_ASSOC);
        
      
    } 
  else {
        array_push($error_msg,  "Query ERROR: Failed to get tool description..<br>" . __FILE__ ." line:". __LINE__ );
    }
  if ( !is_bool($result_tooltype) && (mysqli_num_rows($result_tooltype) > 0)) {
       $row_tooltype = mysqli_fetch_array($result_tooltype, MYSQLI_ASSOC);
       if($row_tooltype['Tool Type'] == 'Power Tool' && !is_bool($result_power) && mysqli_num_rows($result_power) > 0)
       {
           
          $row_power = mysqli_fetch_array($result_power, MYSQLI_ASSOC);

          $full = $width_length_descrip.$row_power['FullDescription'];
           
          $accessories = $row_power['Accessories'];

      }
      else if(!is_bool($result_manual) && mysqli_num_rows($result_manual) > 0)
      {
          $row_manual = mysqli_fetch_array($result_manual, MYSQLI_ASSOC);            
          $full = $width_length_descrip.$row_manual['FullDescription'];
      }
  }


  else {
      
      array_push($error_msg,  "Query ERROR: Failed to get tooltype...<br>" . __FILE__ ." line:". __LINE__ );
  }
    

   
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
                    <div class="subtitle"><h2>Tool Details</h2></div>
                       <table>
                         <tr>
                            <td class="item_label">Tool ID: </td>
                            <td>
                              <?php print $toolid ?>
                               
                            </td> 
                         </tr>
                         <tr>
                            <td class="item_label">Tool Type: </td>
                            <td>
                                <?php print $row_tooltype['Tool Type']?>
                            </td> 
                         </tr>
                           <tr>
                            <td class="item_label">Short Description: </td>
                            <td>
                                <?php print $row_query['Short Description']?>
                            </td> 
                         </tr>
                           <tr>
                            <td class="item_label">Full Description: </td>
                            <td>
                                <?php print $full?>
                            </td> 
                         </tr>
                           <tr>
                            <td class="item_label">Deposit Price: </td>
                            <td>
                                <?php print $row_query['DepositPrice']?>
                            </td> 
                         </tr>
                           <tr>
                            <td class="item_label">Rental Price: </td>
                            <td>
                                <?php print $row_query['RentalPrice']?>
                            </td> 
                         </tr>
                          <tr>
                          <?php
                            if($row_tooltype['Tool Type'] == 'Power Tool'){
                                echo '<td class="item_label">Accessories: </td>';
                                echo '<td width = "50px">'.$row_power['Accessories'].'</td>';
                                
                            }
                           ?>                          
           
  
                    </table>
                    
                    
                    	
                    
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