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
?>

<html>
<?php include("lib/header.php"); ?>
<title>Generate Report</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/clerk_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
            </div>          
            <div class="features">   
            
                <div class="profile_section">
                    <div class="subtitle">Selelct a Report</div>
                     <table border="1" cellspacing = "3px">
                         <tr>
                             <td><a href="generate_report_Clerk.php"><font size = "3">Clerk Report</font></a></td>
                         </tr>
                         <tr>
                             <td><a href="generate_report_Customer.php"><font size = "3">Customer Report</font></a></td>
                         </tr>
                         <tr>
                             <td><a href="generate_report_Tool.php"><font size = "3">Tool Inventory Report</font></a></td>
                         </tr>
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