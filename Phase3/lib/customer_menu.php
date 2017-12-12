
			<div id="header">
                <div class="logo"><img src="img/tools_for_rent.png" style="opacity:1.0;background-color:E9E5E2;" border="0" alt="" title="GT Online Logo"/></div>
			</div>
			
			<div class="nav_bar">
				<ul>    
                    <li><a href="view_profile.php" <?php if($current_filename=='view_profile.php') echo "class='active'"; ?>>View Profile</a></li>
                    <li><a href="make_reservation.php" <?php if($current_filename=='make_reservation.php') echo "class='active'"; ?>>Make Reservation</a></li>  
                    <li><a href="check_tool_availability.php" <?php if($current_filename=='check_tool_availability.php') echo "class='active'"; ?>>Check Tool Availability</a></li>   
                    <li><a href="logout.php" <span class='glyphicon glyphicon-log-out'></span> Log Out</a></li>              
				</ul>
			</div>