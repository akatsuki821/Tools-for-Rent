
			<div id="header">
                <div class="logo"><img src="img/tools_for_rent.png" style="opacity:1.0;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/></div>
			</div>
			
			<div class="nav_bar">
				<ul>    
                    <li><a href="pick_up_reservation.php" <?php if($current_filename=='pickup_reservation.php') echo "class='active'"; ?>>Pick Up Reservation</a></li>
                    <li><a href="dropoff_reservation.php" <?php if($current_filename=='dropoff_reservation.php') echo "class='active'"; ?>>Drop Off Reservation</a></li>  
                    <li><a href="add_new_tool.php" <?php if($current_filename=='add_new_tool.php') echo "class='active'"; ?>>Add New Tool</a></li>   
                    <li><a href="generate_report.php" <?php if($current_filename=='generate_report.php') echo "class='active'"; ?>>Generate Report</a></li> 
					<li><a href="logout.php" <span class='glyphicon glyphicon-log-out'></span> Log Out</a></li>              
				</ul>
			</div>