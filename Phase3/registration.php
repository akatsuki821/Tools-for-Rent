<?php
include('lib/common.php');

/**
 * States Dropdown 
 *
 * @uses check_select
 * @param string $post, the one to make "selected"
 * @param string $type, by default it shows abbreviations. 'abbrev', 'name' or 'mixed'
 * @return string
 */
function StateDropdown($post=null, $type='abbrev') {
	$states = array(
		array('AK', 'Alaska'),
		array('AL', 'Alabama'),
		array('AR', 'Arkansas'),
		array('AZ', 'Arizona'),
		array('CA', 'California'),
		array('CO', 'Colorado'),
		array('CT', 'Connecticut'),
		array('DC', 'District of Columbia'),
		array('DE', 'Delaware'),
		array('FL', 'Florida'),
		array('GA', 'Georgia'),
		array('HI', 'Hawaii'),
		array('IA', 'Iowa'),
		array('ID', 'Idaho'),
		array('IL', 'Illinois'),
		array('IN', 'Indiana'),
		array('KS', 'Kansas'),
		array('KY', 'Kentucky'),
		array('LA', 'Louisiana'),
		array('MA', 'Massachusetts'),
		array('MD', 'Maryland'),
		array('ME', 'Maine'),
		array('MI', 'Michigan'),
		array('MN', 'Minnesota'),
		array('MO', 'Missouri'),
		array('MS', 'Mississippi'),
		array('MT', 'Montana'),
		array('NC', 'North Carolina'),
		array('ND', 'North Dakota'),
		array('NE', 'Nebraska'),
		array('NH', 'New Hampshire'),
		array('NJ', 'New Jersey'),
		array('NM', 'New Mexico'),
		array('NV', 'Nevada'),
		array('NY', 'New York'),
		array('OH', 'Ohio'),
		array('OK', 'Oklahoma'),
		array('OR', 'Oregon'),
		array('PA', 'Pennsylvania'),
		array('PR', 'Puerto Rico'),
		array('RI', 'Rhode Island'),
		array('SC', 'South Carolina'),
		array('SD', 'South Dakota'),
		array('TN', 'Tennessee'),
		array('TX', 'Texas'),
		array('UT', 'Utah'),
		array('VA', 'Virginia'),
		array('VT', 'Vermont'),
		array('WA', 'Washington'),
		array('WI', 'Wisconsin'),
		array('WV', 'West Virginia'),
		array('WY', 'Wyoming')
	);
	
	$options = '<option value=""></option>';
	
	foreach ($states as $state) {
		if ($type == 'abbrev') {
    	$options .= '<option value="'.$state[0].'" '. check_select($post, $state[0], false) .' >'.$state[0].'</option>'."\n";
    } elseif($type == 'name') {
    	$options .= '<option value="'.$state[1].'" '. check_select($post, $state[1], false) .' >'.$state[1].'</option>'."\n";
    } elseif($type == 'mixed') {
    	$options .= '<option value="'.$state[0].'" '. check_select($post, $state[0], false) .' >'.$state[1].'</option>'."\n";
        }
    
	}
		
	echo $options;
}

/**
 * Check Select Element 
 *
 * @param string $i, POST value
 * @param string $m, input element's value
 * @param string $e, return=false, echo=true 
 * @return string 
 */
function check_select($i,$m,$e=true) {
	if ($i != null) { 
		if ( $i == $m ) { 
			$var = ' selected="selected" '; 
		} else {
			$var = '';
		}
	} else {
		$var = '';	
	}
	if(!$e) {
		return $var;
	} else {
		echo $var;
	}
}

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


// written by Team008

/*if (!isset($_SESSION['username'])) {
	header('Location: login.php');
	exit();
}*/

if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");  
}
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    $error = false;
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']); 
    $middlename = mysqli_real_escape_string($db, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $phonetype1 = mysqli_real_escape_string($db, $_POST['phone_type1']);
    $areacode1 = mysqli_real_escape_string($db, $_POST['areacode1']);
    $number1 = mysqli_real_escape_string($db, $_POST['number1']);
    
    $extension1 = mysqli_real_escape_string($db, $_POST['extension1']);
    $phonetype2 = mysqli_real_escape_string($db, $_POST['phone_type2']);
    $areacode2 = mysqli_real_escape_string($db, $_POST['areacode2']);
    $number2 = mysqli_real_escape_string($db, $_POST['number2']);
    $extension2 = mysqli_real_escape_string($db, $_POST['extension2']);
    $phonetype3 = mysqli_real_escape_string($db, $_POST['phone_type3']);
    $areacode3 = mysqli_real_escape_string($db, $_POST['areacode3']);
    $number3 = mysqli_real_escape_string($db, $_POST['number3']);
    $extension3 = mysqli_real_escape_string($db, $_POST['extension3']);
    $primarySelection = mysqli_real_escape_string($db, $_POST['primary']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    //check username exist or not
    $username_query = "SELECT password FROM User WHERE username= '$username'";
    $username_result = mysqli_query($db, $username_query);
    include('lib/show_queries.php');
    $username_count = mysqli_num_rows($username_result); 
   
    if($username_count != 0){
        $error = true;
        //$usernameError = "Username is already in use.";
        array_push($error_msg,  "Username is already in use.");     
    }
       
    $email = mysqli_real_escape_string($db, $_POST['email']);
    //basic email validation
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        array_push($error_msg, "Please enter valid email address. ");
        //$emailError = "Please enter valid email address. ";
    }
    $password = mysqli_real_escape_string($db, $_POST['password']);
    //$password = password_hash(mysqli_real_escape_string($db, $_POST['password']), PASSWORD_DEFAULT , $options); 
    $repassword = mysqli_real_escape_string($db, $_POST['retypePassword']);
    //$repassword =  password_hash(mysqli_real_escape_string($db, $_POST['retypePassword']), PASSWORD_DEFAULT , $options);
    $street = mysqli_real_escape_string($db, $_POST['street']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $zipcode = mysqli_real_escape_string($db, $_POST['zipcode']);
    $address = $street.', '.$city.', '.$state.' '.$zipcode;
    
    $nameOnCard = mysqli_real_escape_string($db, $_POST['nameOnCard']);
    $creditCardNum = mysqli_real_escape_string($db, $_POST['creditCardNum']);
    $month = mysqli_real_escape_string($db, $_POST['month']);
    $year = mysqli_real_escape_string($db, $_POST['year']);
    //$whole_date = array($year, $month, '00');
    $expiration_date = $year . '-' . $month . '-00';
    
    //$rawExiry = $month . $year;
    //$expires = \DateTime::createFromFormat('mY', $_POST['expMonth'].$_POST['expYear'])
    //$expiration_date = implode("_", $whole_date);
        //\DateTime::createFromFormat('mY', $_POST['month'].$_POST['year']);  
    $cvc = mysqli_real_escape_string($db, $_POST['CVC']);
    
    if(empty($number1) && empty($number2) && empty($number3)){ 
        $error = true;
        
        array_push($error_msg,  "Please input at least one type of phone number");  
    
    }
/*    if(strlen($number1) != 10 && strlen($number2) != 10 && strlen($number3) != 10){
        $error = true;
        array_push($error_msg,  "Your phone number should be 10 numbers");  
        
    }
    if(!is_numeric($number1) && !is_numeric($number2) && !is_numeric($number3)){
        $error = true;
        array_push($error_msg,  "Your phone number should be digits");  
        
    }*/
    
    if(!empty($number1)){
        if(!(strlen($number1) == 10 && ctype_digit($number1))){
            $error = true;
            array_push($error_msg,  "Your home phone number should be 10 digits"); 
            
        }
        
        elseif(empty($areacode1)){
            $error = true;
            array_push($error_msg,  "Please select the corresponding area code1"); 
            
        }
        elseif(strlen($areacode1) != 3){
            $error = true;
            array_push($error_msg,  "Your area code1 should be 3 digits!"); 
            
        }
        else{
            $error = false;
            
        }
     
    }
    if(!empty($number2)){ 
        if(!(strlen($number2) == 10 && ctype_digit($number2))){
            $error = true;
            array_push($error_msg,  "Your work phone number should be 10 digits"); 
            
        }
        
        elseif(empty($areacode2)){
            $error = true;
            array_push($error_msg,  "Please input the corresponding area code2");
            
        }
        elseif(strlen($areacode2) != 3){
            $error = true;
            array_push($error_msg,  "Your area code2 should be 3 digits!");  
            
        }
        else{
            $error =false;
        }
            

    }
    if(!empty($number3)){
        if(!(strlen($number3) == 10 && ctype_digit($number3))){
            $error = true;
            array_push($error_msg,  "Your cell phone number should be 10 digits"); 
            
        }
              
        elseif(empty($areacode3)){
            $error = true;
            array_push($error_msg,  "Please input the corresponding area code3");
            
        }
        elseif(strlen($areacode3) != 3){
            $error = true;
            array_push($error_msg,  "Your area code3 should be 3 digits!");  
            
        }
        else{
            $error =false;
            
        }
    }
    if (empty($primarySelection)) {
        $error = true;
        array_push($error_msg,  "Please select your primary phone type: Home Phone, Work Phone, Cell Phone");
        
    }
     
    
    if($primarySelection == "home_phone" && empty($number1) ){
        $error = true;
         array_push($error_msg,  "No input home phone");
        
    }
    if($primarySelection == "work_phone" && empty($number2) ){
        $error = true;
         array_push($error_msg,  "No input work phone");
        
    }
    if($primarySelection == "cell_phone" && empty($number3)){
        $error = true;
         array_push($error_msg,  "No input cell phone");
        
    }
    if($repassword != $password){
        $error = true;
        array_push($error_msg,  "Password does not match the confirm password!");
        
    }
    //if there is no error, continue to signup
    
   if(!$error){
       include('lib/show_queries.php');        

       
       $user_query = "INSERT INTO User(username, email, password, first_name, middle_name, last_name) VALUES('$username','$email', '$password', '$firstname', '$middlename', '$lastname')";
       $user_result = mysqli_query($db, $user_query);
       if(!$user_result){
           array_push($error_msg,  "User_result went wrong, try again later...");
           
       }
       
       
       if(!empty($number1) && !empty($number2) && !empty($number3)){
           $number1 = substr($number1, 0, 3) . '-' . substr($number1, 3, 3). '-' . substr($number1, 6, 4);
    
           $number2 = substr($number2, 0, 3) . '-' . substr($number2, 3, 3) . '-' . substr($number2, 6, 4);
           $number3 = substr($number3, 0, 3) . '-' . substr($number3, 3, 3) . '-' . substr($number3, 6, 4);
           
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES ('$number1', 'home_phone', '$areacode1', '$extension1', '$username'), ('$number2', 'work_phone', '$areacode2', '$extension2', '$username'), ('$number3', 'cell_phone', '$areacode3', '$extension3', '$username')";            
       }
       if(!empty($number1) && !empty($number2) && empty($number3)){
           $number1 = substr($number1, 0, 3) . '-' . substr($number1, 3, 3). '-' . substr($number1, 6, 4);
          
           $number2 = substr($number2, 0, 3) . '-' . substr($number2, 3, 3) . '-' . substr($number2, 6, 4);
           
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES('$number1', 'home_phone', '$areacode1', '$extension1', '$username'), ('$number2', 'work_phone', '$areacode2', '$extension2', '$username')";            
       }
       if(!empty($number1) && !empty($number3) &&empty($number2)){
           $number1 = substr($number1, 0, 3) . '-' . substr($number1, 3, 3). '-' . substr($number1, 6, 4);
           $number3 = substr($number3, 0, 3) . '-' . substr($number3, 3, 3) . '-' . substr($number3, 6, 4);
        
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES('$number1', 'home_phone', '$areacode1', '$extension1', '$username'), ('$number3', 'cell_phone', '$areacode3', '$extension3', '$username')";  
       }
       if(!empty($number2) && !empty($number3) && empty($number1)){
           $number2 = substr($number2, 0, 3) . '-' . substr($number2, 3, 3) . '-' . substr($number2, 6, 4);
           $number3 = substr($number3, 0, 3) . '-' . substr($number3, 3, 3) . '-' . substr($number3, 6, 4);
       
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES('$number2', 'work_phone', '$areacode2', '$extension2', '$username'), ('$number3', 'cell_phone', '$areacode3', '$extension3', '$username')";            
       }
         
       if(!empty($number1) && empty($number2) && empty($number3)){
           $number1 = substr($number1, 0, 3) . '-' . substr($number1, 3, 3). '-' . substr($number1, 6, 4);
           
         
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES('$number1', 'home_phone', '$areacode1', '$extension1', '$username')";            
       }
         
       if(!empty($number2) && empty($number1) && empty($number3)){
           $number2 = substr($number2, 0, 3) . '-' . substr($number2, 3, 3) . '-' . substr($number2, 6, 4);          
           
          
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES('$number2', 'work_phone', '$areacode2', '$extension2', '$username')";            
       }
         
       if(!empty($number3) && empty($number1) && empty($number2)){
           $number3 = substr($number3, 0, 3) . '-' . substr($number3, 3, 3) . '-' . substr($number3, 6, 4);
         
           $phone_query = "INSERT INTO Phone(phone_number, phone_type, area_code, extension, username) VALUES('$number3', 'cell_phone', '$areacode3', '$extension3', '$username')";            
       }
       
       $phone_result = mysqli_query($db, $phone_query);
       if(!$phone_result){
           array_push($error_msg,  "phone_result went wrong, try again later...");
           
       }
              
      $customer_query = "INSERT INTO Customer(username, credit_card_number, name_on_card, expiration_date, cvc_number, address, phone_number) VALUES('$username','$creditCardNum', '$nameOnCard', '$expiration_date', '$cvc', '$address',(SELECT phone_number from Phone WHERE phone_type = '$primarySelection' AND username = '$username'))";
      
       
       //the mysqli_query() function performs a query against the database
       //for successful SELECT, SHOW, DESCRIBE queries it will return a mysqli_result object. for other queries result, it will return true or false.
       
       $customer_result = mysqli_query($db, $customer_query);
      
     
       if(!$customer_result){
           array_push($error_msg,  "Customer_result went wrong, try again later...");
           
       }
       
       if($user_result && $customer_result && $phone_result){
           
           $_SESSION['username'] = $username;
           array_push($query_msg, "logging in... ");
           header(REFRESH_TIME . 'url=view_profile.php');        
           
       }    
   }

}

?>

<?php include("lib/header.php"); ?>

<html>

<head>
    <title>Registration</title>

</head>
    <body>
      <div id = "main_container">
          
           <div id="header">
            <div class="logo">
                <img src="img/tools_for_rent.png" style="opacity:100;background-color:E9E5E2;" border="0" alt="" title="Tools-for-rent Logo"/>
            </div>
        </div>
        <div class = "center_content">                         
               
           <form action = "registration.php" method = "post" style = "width: 750px">
            <left><h2>Customer Registration Form</h2></left>
             <left><h3>Customer Information</h3></left>
              <div class = "three_form">
                 <input type = "text" placeholder = "Frist Name" name = "firstname" style = "width: 200px;" value="<?php if(isset($_POST["firstname"]))echo $_POST["firstname"]; ?>"required />

                 <input type = "text" placeholder = "Middle Name" name = "middlename" style = "width: 200px;" value="<?php if(isset($_POST["middlename"]))echo $_POST["middlename"]; ?>"/>
                 <input type = "text" placeholder = "Last Name" name = "lastname" style = "width: 200px;" value="<?php if(isset($_POST["lastname"]))echo $_POST["lastname"]; ?>"required />

              </div><br>
              <div class = "phonetype1">
                 Home Phone:
                <!--<select name = "phone_type1" style = "width: 100px;">              

                   <option value = "" >Home</option>
                   <option value = "" >Work</option>
                   <option value = "" >Cell</option>            
                 </select>-->
                 Area Code:
                 <input type = "text"  name = "areacode1" style = "width: 100px;" value="<?php if(isset($_POST["areacode1"]))echo $_POST["areacode1"]; ?>"/>
                 Number: 
                 <input type = "text" name = "number1" style = "width: 150px;"  value="<?php if(isset($_POST["number1"]))echo $_POST["number1"]; ?>"/> 
                 Extension:
                 <input type = "text" name = "extension1" style = "width: 100px;" value="<?php if(isset($_POST["extension1"]))echo $_POST["extension1"]; ?>"/> 
               </div><br>

               <div class = "phonetype2">
               Work Phone : 
               <!-- <select name = "phone_type2" style = "width: 100px;" value="<?php if(isset($_POST["phone_type2"]))echo $_POST["phone_type2"]; ?>" >
                   <option value = "" >Work</option>
                   <option value = "" >Home</option>               
                   <option value = "" >Cell</option> 
                 </select>-->
                  Area Code:
                 <input type = "text" name = "areacode2" style = "width: 100px;" value="<?php if(isset($_POST["areacode2"]))echo $_POST["areacode2"]; ?>"/> 
                 Number: 
                 <input type = "text"  name = "number2" style = "width: 150px;" value="<?php if(isset($_POST["number2"]))echo $_POST["number2"]; ?>"/> 
                 Extension:
                 <input type = "text"  name = "extension2" style = "width: 100px;" value="<?php if(isset($_POST["extension2"]))echo $_POST["extension2"]; ?>"/> 

               </div><br> 
                <div class = "phonetype3">
                Cell   Phone   :
                <!--<select name = "phone_type3" style = "width: 100px;" value="<?php if(isset($_POST["phone_type3"]))echo $_POST["phone_type3"]; ?>">

                   <option value = "" >Cell</option>
                   <option value = "" >Home</option>
                   <option value = "" >Work</option>

                 </select>-->
                 Area  Code :
                 <input type = "text" name = "areacode3" style = "width: 100px;" value="<?php if(isset($_POST["areacode3"]))echo $_POST["areacode3"]; ?>"/> 
                 Number: 
                 <input type = "text" name = "number3" style = "width: 150px;" value="<?php if(isset($_POST["number3"]))echo $_POST["number3"]; ?>"/> 
                  Extension:
                 <input type = "text" p name = "extension3" style = "width: 100px;" value="<?php if(isset($_POST["extension3"]))echo $_POST["extension3"]; ?>" /> 

               </div> <br>
                <!--<input type = "text" placeholder = "Home Phone" name = "homephone" style = "width: 200px;">
                <input type = "text" placeholder = "Work Phone" name = "workphone" style = "width: 200px;">
                <input type = "text" placeholder = "Cell Phone" name = "cellphone" style = "width: 200px;">  -->       
              <div class = "primaryPhoneselection">
               <label class = "phonetype_label"><b>Primary Phone:</b> </label>                       
                <input class="radio" type="radio" name="primary" value="home_phone" /> <span>Home Phone</span>
                <input class="radio" type="radio" name="primary" value="work_phone" /> <span>Work Phone</span> 
                <input class="radio" type="radio" name="primary" value="cell_phone" /> <span>Cell Phone</span> 
               </div><br>
               <div class = "two_form">
                 <input type = "text" placeholder = "Username" name = "username" style = "width: 303px;" value="<?php if(isset($_POST["username"]))echo $_POST["username"]; ?>"required />
                   <span class = "text-danger"><?php echo $usernameError; ?></span>
                 <input type = "text" placeholder = "Email Address" name = "email" style = "width: 303px;" value="<?php if(isset($_POST["email"]))echo $_POST["email"]; ?>"required />
                 <span class = "text-danger" ><?php echo $emailError; ?></span>
               </div><br>
               <div class = "two_form">
                 <input type = "text" placeholder = "Password" name = "password" style = "width: 303px;" value="<?php if(isset($_POST["password"]))echo $_POST["password"]; ?>"required />
                 <input type = "text" placeholder = "Re-type Password" name = "retypePassword" style = "width: 303px;" value="<?php if(isset($_POST["retypePassword"]))echo $_POST["retypePassword"]; ?>" required />
               </div><br>
               <div class = "two_form">
                   <input type = "text" placeholder = "Street Address" name = "street" style = "width: 617px;" required value="<?php if(isset($_POST["street"]))echo $_POST["street"]; ?>"/>
               </div><br>
               <div class = "three_form">
                <input type = "text" placeholder = "City" name = "city" style = "width: 200px;" value="<?php if(isset($_POST["city"]))echo $_POST["city"]; ?>"required />
               <select name="state" style = "width: 200px;" value="<?php if(isset($_POST["state"]))echo $_POST["state"]; ?>"required>
                <option value = "" >Select a state...</option>
                <?php echo StateDropdown(null, 'abbrev'); ?>
                </select>


                <input type = "text" placeholder = "Zip Code" name = "zipcode" style = "width: 200px;" value="<?php if(isset($_POST["zipcode"]))echo $_POST["zipcode"]; ?>" required />            

              </div><br>
              <left><h3>Credit Card Information</h3></left>
               <div class = "two_form">
                   <input type = "text" placeholder = "Name on Credit Card" name = "nameOnCard" style = "width: 617px;" value="<?php if(isset($_POST["nameOnCard"]))echo $_POST["nameOnCard"]; ?>" required/><br><br>
                   <input type = "text" placeholder = "Credit Card #" name = "creditCardNum" style = "width: 617px;" value="<?php if(isset($_POST["creditCardNum"]))echo $_POST["creditCardNum"]; ?>" required/>
               </div><br>
               <div class = "three_form">
                 <select name = "month" style = "width: 200px;" value="<?php if(isset($_POST["month"]))echo $_POST["month"]; ?>" required>
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
                 <select name = "year" style = "width: 200px;" value="<?php if(isset($_POST["year"]))echo $_POST["year"]; ?>" required>
                 <option value = "" >Expiration Year</option>
                    <?php 
                        for ($i = date('Y'); $i <= date('Y')+20; $i++) {
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        } 
                     ?>
                   </select>
                <input type = "text" placeholder = "CVC" name = "CVC" style = "width: 200px;" value="<?php if(isset($_POST["CVC"]))echo $_POST["CVC"]; ?>" required />   
               </div><br><br>        
               <input type = "submit" name = "register_btn" value = "Register" style = "font-size:10pt;color:white; background-color:green;" />


           </form>
           <br>
                <?php include("lib/error.php"); ?>

                <div class="clear"></div>
            </div>

      </div> 
        
    </body>
</html>
