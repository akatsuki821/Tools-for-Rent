
<?php
include('lib/common.php');
// written by GTusername1

if($showQueries){
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
    
   
}

//Note: known issue with _POST always empty using PHPStorm built-in web server: Use *AMP server instead
if( $_SERVER['REQUEST_METHOD'] == 'POST') {


	$enteredUsername = mysqli_real_escape_string($db, $_POST['username']);
	$enteredPassword = mysqli_real_escape_string($db, $_POST['password']);
	$userSelected = mysqli_real_escape_string($db,$_POST['user']); 
    $customer_status = 'unchecked';
    $clerk_status = 'unchecked';
    

    if (empty($enteredUsername)) {
            array_push($error_msg,  "Please enter a username.");
    }

	if (empty($enteredPassword)) {
			array_push($error_msg,  "Please enter a password.");
	}
	if (empty($userSelected)) {
            array_push($error_msg,  "Please select Customer or Clerk!");
        
    }
    
	
    if ( !empty($enteredUsername) && !empty($enteredPassword) && !empty($userSelected))   { 
        
         

        $query = "SELECT password FROM User WHERE username='$enteredUsername'"; //password from user table
        $query_customer = "SELECT * FROM Customer WHERE username = '$enteredUsername'"; // query from Customer
        $query_clerk = "SELECT * FROM Clerk WHERE username = '$enteredUsername'"; //query from Clerk
        
        
        $result = mysqli_query($db, $query);//The mysqli_query() function performs a query against the database
        $result_customer = mysqli_query($db, $query_customer);
        $result_clerk = mysqli_query($db, $query_clerk);
        
        
        include('lib/show_queries.php');
        $count = mysqli_num_rows($result); 
        $count_customer = mysqli_num_rows($result_customer);
        $count_clerk = mysqli_num_rows($result_clerk);
        
  
        
       
        
        if (!empty($result) && ($count > 0) ) {
            	
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $storedPassword = $row['password']; 
            
            
            $options = [
                'cost' => 8,
            ];
            //$storedHash = password_hash(storedPassword, PASSWORD_DEFAULT , $options); //hash stored password
             //convert the plaintext passwords to their respective hashses
             // 'michael123' = $2y$08$kr5P80A7RyA0FDPUa8cB2eaf0EqbUay0nYspuajgHRRXM9SgzNgZO
            $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT , $options);   //may not want this if $storedPassword are stored as hashes (don't rehash a hash)
            $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT , $options); 
            
            if($showQueries){
                array_push($query_msg, "Plaintext entered password: ". $enteredPassword);
                //Note: because of salt, the entered and stored password hashes will appear different each time
                array_push($query_msg, "Entered Hash:". $enteredHash);
                array_push($query_msg, "Stored plaintext password:". $storedPassword. NEWLINE);
                array_push($query_msg, "Stored hashed password:". $storedHash. NEWLINE);
                //array_push($query_msg, "Stored Hash:  ". $storedHash . NEWLINE); 
                //array_push($query_msg, "Stored Hash:  ". $storedPassword . NEWLINE); //note: change to storedHash if tables store the plaintext password value
                //unsafe, but left as a learning tool uncomment if you want to log passwords with hash values
                //error_log('email: '. $enteredEmail  . ' password: '. $enteredPassword . ' hash:'. $enteredHash);
            }
            
            //depends on if you are storing the hash $storedHash or plaintext $storedPassword 
            if (password_verify($enteredPassword, $storedHash)) {
                //array_push($query_msg, "Password is Valid!");                
                
                if($userSelected == "customer"){                    
                    
                    if($count_customer > 0){                      
                        
                        $_SESSION['username'] = $enteredUsername;
                        array_push($query_msg, "Go to the Profile page.");
                        header(REFRESH_TIME . 'url=view_profile.php');	//redirect to the veiw	
                    }
                    else{
                        array_push($error_msg, "Login failed: no such customer username exist!" . $enteredUsername . NEWLINE);
                    }
                }
                else if ($userSelected == "clerk"){
                    if($count_clerk > 0){
                        $_SESSION['username'] = $enteredUsername;                        
                        array_push($query_msg, "Go to Pick Up Reservation page.");
                        header(REFRESH_TIME . 'url=pick_up_reservation.php');	//redirect to the pick_up_reservation page	
                    }
                    else{
                        array_push($error_msg, "There is no clerk with username: " . $enteredUsername . NEWLINE);
                    }
                    
                    
                }
                
            }
            else{
                array_push($error_msg, "Login failed: password is not correct " . $enteredPassword . NEWLINE);
                
            }
        }
        
                
            
                //array_push($error_msg, "To demo enter: ". NEWLINE . "michael@bluthco.com". NEWLINE ."michael123");
            
            
         else {
            
             if($userSelected == "customer"){
                 array_push($query_msg, "No username ".$enteredUsername. " and go to Registratoin page.");                 
                 
                 header(REFRESH_TIME . 'url=registration.php');	
             }
             else if($userSelected == "clerk"){
                array_push($error_msg, "There is no clerk with username: " . $enteredUsername);
             }
             
        }
            
        
    }
}
    
    



?>

<?php include("lib/header.php"); ?>

<html>
<head>
<title>Tools-4-Rent</title>
</head>
<body>
    <div id="main_container">
        <div id="header">
            <div class="logo">
                <img src="img/tools_for_rent.png" style="opacity:100;background-color:E9E5E2;" border="0" alt="" title="Tools-for-rent Logo"/>
            </div>
        </div>

        <div class="center_content">
            <div class="text_box">

                <form action="login.php" method="post" enctype="multipart/form-data">
                    <div class="title">Tools-4-Rent Login</div>
                    <div class="login_form_row">
                        <label class="login_label">Username:</label>
                        <input type="text" name="username" class="login_input"/>
                    </div>
                    <div class="login_form_row">
                        <label class="login_label">Password:</label>
                        <input type="password" name="password" class="login_input"/>
                    </div>
                    <div class = "login_form_row">                       
                        <input class="radio" type="radio" name="user" value="customer" /> <span>Customer</span>
                        <input class="radio" type="radio" name="user" value="clerk" /> <span>Clerk</span> 
                        <br><br>
                        <input type = "submit" name = "submit1" value = "Log in" />	
                        
                    </div>
   
                </form>
                <br>
                
             </div>
         

                <?php include("lib/error.php"); ?>

                <div class="clear"></div>
            </div>
   
            
	<!--		<div class="map">
			<iframe style="position:relative;z-index:999;" width="820" height="600" src="https://maps.google.com/maps?q=801 Atlantic Drive, Atlanta - 30332&t=&z=14&ie=UTF8&iwloc=B&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a class="google-map-code" href="http://www.embedgooglemap.net" id="get-map-data">801 Atlantic Drive, Atlanta - 30332</a><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></iframe>
			</div>-->
             
      

        </div>
    </body>
</html>