


<?php

include('lib/common.php');
// written by Team008




    // ERROR: demonstrating SQL error handlng, to fix
    // replace 'sex' column with 'gender' below:
    $query = "SELECT customer_username, reservation_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS 'Full Name', 
    Round(SUM(Tools.purchase_price * 0.4),2) AS 'deposit', Round(SUM((Tools.purchase_price * 0.15 * DATEDIFF(Reservation.reservation_end_date , Reservation.reservation_start_date))),2)AS 'rental_price' " .
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





if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    $cardOption = mysqli_real_escape_string($db,$_POST['Credit_Card']); 
    $error = false;
    $reservation_id = $_SESSION['reservation_id'];
	if (empty($cardOption)) {
        $error = true;
        array_push($error_msg,  "Please select credit card option!");
        
    }
    if($cardOption == "New"){
        $customerusername = $row['customer_username'];
        $nameOnCard = mysqli_real_escape_string($db, $_POST['nameOnCard']);
        $creditCardNum = mysqli_real_escape_string($db, $_POST['creditCardNum']);
        $month = mysqli_real_escape_string($db, $_POST['month']);
        $year = mysqli_real_escape_string($db, $_POST['year']);
        $expiration_date = $year . '-' . $month . '-01';
        $cvc = mysqli_real_escape_string($db, $_POST['CVC']);
        
        if (empty($nameOnCard)) {
            $error = true;
            array_push($error_msg,  "Please enter your name on Credit Card");
        }
        if (empty($creditCardNum)) {
            $error = true;
            array_push($error_msg,  "Please enter your credit card number");
        }
        if (empty($month)) {
            $error = true;
            array_push($error_msg,  "Please select your credit card expiration date");
        }
        if (empty($year)) {
            $error = true;
            array_push($error_msg,  "Please select your credit card expiration date");
        }
        if (empty($cvc)) {
            $error = true;
            array_push($error_msg,  "Please enter your cvc number");
        }
       $customer_query = "Update Customer ".
       "Set Customer.name_on_card= '$nameOnCard', Customer.credit_card_number= '$creditCardNum', Customer.CVC_number= '$cvc',
       Customer.expiration_date= '$expiration_date'".
       "WHERE Customer.username = '$customerusername'";
       $customer_result = mysqli_query($db, $customer_query);
        
        if(!$customer_result){
            $error = true;
           array_push($error_msg,  "Customer_result went wrong, try again later...");
           
       }
    }
    
    if(!$error){
        array_push($query_msg, "Go to Pick Up Reservation page.");
        header(REFRESH_TIME . 'url=pick_up_reservation_confirmation.php');
    }

}

?>
<?php include("lib/header.php"); ?>



<html>

<head>
    <title>Pickup Reservation</title>

</head>
    <body>
      <div id = "main_container">
          <?php include("lib/clerk_menu.php"); ?>
        <div class = "center_content">    

           <form action = "pick_up_reservation_credit_card.php" method = "post" style = "width: 750px">
            <left><h2>Pick Up Reservation</h2></left>

            
            <div class = "creditCardSelection">
                    <div class="subtitle">View Reservation Information</div>   
                    <table>
                        <tr>
                            <td class="item_label">Reservation ID</td>
                            <td>
                                <?php print $row['reservation_id'];?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Clerk Username</td>
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
                            <td class="item_label">Total Rent</td>
                            <td>
                                <?php print $row['rental_price'];?>
                            </td>
                        </tr>

                    </table>						
              
              
               <label class = "Credit_Card"><b>Credit Card:</b> </label>                       
                <input class="radio" type="radio" name="Credit_Card" value="Existing" /> <span>Existing</span>
                <input class="radio" type="radio" name="Credit_Card" value="New" /> <span>New</span> 
               </div><br>
             
              <left><h3>Enter Updated Credit Card Information</h3></left>
               <div class = "two_form">
                   <input type = "text" placeholder = "Name on Credit Card" name = "nameOnCard" style = "width: 617px;" value="<?php if(isset($_POST["nameOnCard"]))echo $_POST["nameOnCard"]; ?>" /><br><br>
                   <input type = "text" placeholder = "Credit Card #" name = "creditCardNum" style = "width: 617px;" value="<?php if(isset($_POST["creditCardNum"]))echo $_POST["creditCardNum"]; ?>" />
               </div><br>
               <div class = "three_form">
                 <select name = "month" style = "width: 200px;" value="<?php if(isset($_POST["month"]))echo $_POST["month"]; ?>" >
                   <option value = "" >Expiration Month</option>
                   <option value = "01" >01</option>
                   <option value = "02" >02</option>
                   <option value = "03" >03</option>
                   <option value = "04" >04</option> 
                   <option value = "05" >05</option>
                   <option value = "06" >06</option>
                   <option value = "07" >07</option>
                   <option value = "08" >08</option>
                   <option value = "09" >09</option>
                   <option value = "10" >10</option>
                   <option value = "11" >11</option>
                   <option value = "12" >12</option>
                 </select>
                 <select name = "year" style = "width: 200px;" value="<?php if(isset($_POST["year"]))echo $_POST["year"]; ?>" >
                 <option value = "" >Expiration Year</option>
                    <?php 
                        for ($i = date('Y'); $i <= date('Y')+20; $i++) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        } 
                     ?>
                   </select>
                <input type = "text" placeholder = "CVC" name = "CVC" style = "width: 200px;" value="<?php if(isset($_POST["CVC"]))echo $_POST["CVC"]; ?>" />   
               </div><br><br>        
               <input type = "submit" name = "pickup_btn" value = "Pick Up" style = "font-size:10pt;color:white; background-color:green;" />
               

           </form>
           <br>
                <?php include("lib/error.php"); ?>

                <div class="clear"></div>
            </div>

      </div> 
        
    </body>
</html>
