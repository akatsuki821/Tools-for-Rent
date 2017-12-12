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
$clerk_username = $_SESSION['username'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$toolType = mysqli_real_escape_string($db, $_POST['tool_type']);
    $toolSubType = mysqli_real_escape_string($db, $_POST['sub_type']);
    $toolSubOption = mysqli_real_escape_string($db, $_POST['sub_option']);
    $toolPurchasePrice = mysqli_real_escape_string($db, $_POST['purcahse_price']);
    $toolMaterial = mysqli_real_escape_string($db, $_POST['material']);
    $toolManufacturer = mysqli_real_escape_string($db, $_POST['manufacturer']);
    $toolWeight = mysqli_real_escape_string($db, $_POST['weight']);
    $toolWidth = mysqli_real_escape_string($db, $_POST['width']);
    $toolWidthFraction = mysqli_real_escape_string($db, $_POST['width_fraction']);
    $toolWidthUnit = mysqli_real_escape_string($db, $_POST['width_unit']);
    $toolLength = mysqli_real_escape_string($db, $_POST['length']);
    $toolLengthFraction = mysqli_real_escape_string($db, $_POST['length_fraction']);
    $toolLengthUnit = mysqli_real_escape_string($db, $_POST['length_unit']);
    
    //find out the powersource
    switch ($toolType){
        case 'Hand Tool':
            $powerSource = 'manual';
            break;
        case 'Garden Tool':
            $powerSource = 'manual';
            break;
        case 'Ladder':
            $powerSource = 'manual';
            break;
        case 'Power Tool':
            $powerSource = mysqli_real_escape_string($db, $_POST['power_source']);
    }
    //width unit transfer
    if ($toolWidthUnit == "feet") {
        $toolWidth = ($toolWidth + $toolWidthFraction) * 12;
    }else {
        $toolWidth = ($toolWidth + $toolWidthFraction);
    }
    //length unit transfer
    if ($toolLengthUnit == "feet") {
        $toolLength = ($toolLength + $toolLengthFraction) * 12;
    }else {
        $toolLength = ($toolLength + $toolLengthFraction);
    }
    
    $query="INSERT INTO tools(manufacturer, material, weight, width_or_diameter, length, purchase_price, power_source) ".
            "VALUES ('$toolManufacturer', '$toolMaterial', '$toolWeight', '$toolWidth', '$toolLength', '$toolPurchasePrice', '$powerSource');";
    
    $result=mysqli_query($db,$query);
    if(!$result){
           array_push($error_msg,  "Insert tools table failed!");
           
       }
    
    //find out the tool_id just inserted
    $insertedToolid = mysqli_insert_id($db);

    //update toolinfo form

    $updateToolinfo = "INSERT INTO toolinfo(tool_id, tool_type, tool_subtype, tool_suboption) ".
                    "VALUES ('$insertedToolid', '$toolType', '$toolSubType', '$toolSubOption');";
    $result=mysqli_query($db, $updateToolinfo);
    if(!$result){
           array_push($error_msg,  "Insert toolinfo table failed!");

       }
    //update the add form
    $updateAddinfo = "INSERT INTO `add` VALUES ('$clerk_username', '$insertedToolid');";
    $result=mysqli_query($db, $updateAddinfo);
    if(!$result){
           array_push($error_msg,  "Insert 'add' table failed!");

       }
    
    //update each individual table under each subtypes
    switch ($toolType){
        case 'Hand Tool':
            $result = mysqli_query($db,"INSERT INTO handtools VALUES ('$insertedToolid')");
            if(!$result){
                array_push($error_msg,  "Insert handtools table failed!");
            }
       
            switch ($toolSubType){
                    case 'Screwdriver':
                    $screwSize = mysqli_real_escape_string($db, $_POST['screw-size']);
                    $result = mysqli_query($db,"INSERT INTO screwdriver VALUES ('$insertedToolid', '$screwSize')");
                    if(!$result){
                        array_push($error_msg,  "Insert screwdriver table failed!");
                    }
            
                    break;
                    case 'Socket':
                    $socketDriveSize = mysqli_real_escape_string($db, $_POST['socket_drive-size']);
                    $seaSize = mysqli_real_escape_string($db, $_POST['sae-size']);
                    $deepSocket = mysqli_real_escape_string($db, $_POST['deep-socket']);
                    $result = mysqli_query($db,"INSERT INTO socket VALUES ('$insertedToolid', '$socketDriveSize', '$seaSize', '$deepSocket')");
                    if(!$result){
                        array_push($error_msg,  "Insert socket table failed!");
                    }
                    break;
                    case 'Ratchet':
                    $ratchetDriveSize = mysqli_real_escape_string($db, $_POST['ratchet_drive-size']);
                    $result = mysqli_query($db,"INSERT INTO ratchet VALUES ('$insertedToolid', '$ratchetDriveSize')");
                    if(!$result){
                        array_push($error_msg,  "Insert ratchet table failed!");
                    }
                    break;
                    case 'Wrench':
                    $result = mysqli_query($db,"INSERT INTO wrench VALUES ('$insertedToolid')");
                    if(!$result){
                        array_push($error_msg,  "Insert wrench table failed!");
                    }
                    break;
                    case 'Pliers':
                    $pliersAdjustable = mysqli_real_escape_string($db, $_POST['adjustable']);
                    $result = mysqli_query($db,"INSERT INTO pliers VALUES ('$insertedToolid', '$pliersAdjustable')");
                    if(!$result){
                        array_push($error_msg,  "Insert pliers table failed!");
                    }
                    break;
                    case 'Gun':
                    $gunGaugeRating = mysqli_real_escape_string($db, $_POST['gauge-rating']);
                    $gunCapacity = mysqli_real_escape_string($db, $_POST['capacity']);
                    $result = mysqli_query($db,"INSERT INTO gun VALUES ('$insertedToolid', '$gunGaugeRating', '$gunCapacity')");
                    if(!$result){
                        array_push($error_msg,  "Insert gun table failed!");
                    }
                    break;
                    case 'Hammer':
                    $hammerAntivibration = mysqli_real_escape_string($db, $_POST['anti-vibration']);
                    $result = mysqli_query($db,"INSERT INTO hammer VALUES ('$insertedToolid', '$hammerAntivibration')");
                    if(!$result){
                        array_push($error_msg,  "Insert hammer table failed!");
                    }
                    break;
            }
            break;
        case 'Garden Tool':
            $handleMaterial = mysqli_real_escape_string($db, $_POST['handle-material']);
            $result = mysqli_query($db,"INSERT INTO gardentools VALUES ('$insertedToolid', '$handleMaterial')");
            if(!$result){
                array_push($error_msg,  "Insert gardentools table failed!");
            }
            
            switch ($toolSubType){
                    case 'Digger':
                    $diggerBladeWidth = mysqli_real_escape_string($db, $_POST['blade-width']);
                    $diggerBladeLength = mysqli_real_escape_string($db, $_POST['digger_blade-length']);
                    $result = mysqli_query($db,"INSERT INTO digger VALUES ('$insertedToolid', '$diggerBladeWidth', '$diggerBladeLength')");
                    if(!$result){
                        array_push($error_msg,  "Insert digger table failed!");
                    }
            
            
                    break;
                    case 'Pruner':
                    $prunerBladeMaterial = mysqli_real_escape_string($db, $_POST['blade-material']);
                    $prunerBladeLength = mysqli_real_escape_string($db, $_POST['pruner_blade-length']);
                    $result = mysqli_query($db,"INSERT INTO pruner VALUES ('$insertedToolid', '$prunerBladeMaterial', '$prunerBladeLength')");
                    if(!$result){
                        array_push($error_msg,  "Insert pruner table failed!");
                    }
                    break;
                    case 'Rakes':
                    $rakesTineCount = mysqli_real_escape_string($db, $_POST['tine-count']);
                    $result = mysqli_query($db,"INSERT INTO rakes VALUES ('$insertedToolid', '$rakesTineCount')");
                    if(!$result){
                        array_push($error_msg,  "Insert rakes table failed!");
                    }
                    break;
                    case 'Wheelbarrows':
                    $wheelbarrowsBinMaterial = mysqli_real_escape_string($db, $_POST['bin-material']);
                    $wheelbarrowsBinVolume = mysqli_real_escape_string($db, $_POST['bin-volume']);
                    $wheelbarrowsWheelCount = mysqli_real_escape_string($db, $_POST['wheel-count']);
                    $result = mysqli_query($db,"INSERT INTO wheelbarrows VALUES ('$insertedToolid', '$wheelbarrowsBinMaterial', '$wheelbarrowsBinVolume', '$wheelbarrowsWheelCount')");
                    if(!$result){
                        array_push($error_msg,  "Insert wheelbarrows table failed!");
                    }
                    
                    break;
                    case 'Striking':
                    $strikingHeadWeight = mysqli_real_escape_string($db, $_POST['head-weight']);
                    $result = mysqli_query($db,"INSERT INTO striking VALUES ('$insertedToolid', '$strikingHeadWeight')");
                    if(!$result){
                        array_push($error_msg,  "Insert striking table failed!");
                    }
                    break;
            }
            break;
        case 'Ladder':
            $stepCount = mysqli_real_escape_string($db, $_POST['step-count']);
            $weightCapacity = mysqli_real_escape_string($db, $_POST['weight-capacity']);
            $result = mysqli_query($db,"INSERT INTO ladders VALUES ('$insertedToolid')");
            if(!$result){
                array_push($error_msg,  "Insert ladders table failed!");
            }
                    
            switch ($toolSubType){
                    case 'Straight':
                    $straightRubberFeet = mysqli_real_escape_string($db, $_POST['rubber-feet']);
                    $result = mysqli_query($db,"INSERT INTO straight VALUES ('$insertedToolid', '$straightRubberFeet')");
                    if(!$result){
                        array_push($error_msg,  "Insert straight table failed!");
                    }
            
                    break;
                    case 'Step':
                    $stepPailShelf = mysqli_real_escape_string($db, $_POST['pail-shelf']);
                    $result = mysqli_query($db,"INSERT INTO step VALUES ('$insertedToolid', '$stepPailShelf')");
                    if(!$result){
                        array_push($error_msg,  "Insert step table failed!");
                    }
                    break;
            }
            break;
        case 'Power Tool':
            $voltRaing = mysqli_real_escape_string($db, $_POST['ac_volt_raing']);
            $ampRating = mysqli_real_escape_string($db, $_POST['amp_rating']);
            $ampRatingUnit = mysqli_real_escape_string($db, $_POST['amp_unit']);
            $minRpmRating = mysqli_real_escape_string($db, $_POST['min_rpm_rating']);
            $maxRpmRating = mysqli_real_escape_string($db, $_POST['max_rpm_rating']);
            $toolAccessoryQuantity = $_POST['accessory_quantity'];
            $toolAccessoryDescription = $_POST['accessory_description'];
            var_dump($toolAccessoryQuantity);
            //ampraing unit transfer
            if ($ampRatingUnit == "mili") {
                $ampRating = $ampRating * 0.001;
            }
            else if ($ampRatingUnit == "kilo") {
                $ampRating = $ampRating * 1000;
            }
            
            $result = mysqli_query($db,"INSERT INTO powertools VALUES ('$insertedToolid', '$voltRaing', '$ampRating', '$minRpmRating', '$maxRpmRating')");
            if(!$result){
                array_push($error_msg,  "Insert powertools table failed!");
            }
            if($powerSource == 'cordless(D/C)') {
                $batteryType = mysqli_real_escape_string($db, $_POST['battery_type']);
                $batteryQuantity = mysqli_real_escape_string($db, $_POST['battery_quantity']);
                $batteryVoltRating = mysqli_real_escape_string($db, $_POST['dc_volt_rating']);
                for($i = 0; $i < sizeof($toolAccessoryQuantity); $i++){
                    $result = mysqli_query($db,"INSERT INTO power_accessories VALUES ('$insertedToolid', CONCAT('$batteryQuantity', ' ', '$batteryType', ' ', '$batteryVoltRating', ' V'), '$toolAccessoryQuantity[$i]', '$toolAccessoryDescription[$i]')");
                    if(!$result){
                        array_push($error_msg,  "Insert power_accessories with cordless table failed!");
                    }
                }     
            } else {
                for($i = 0; $i < sizeof($toolAccessoryQuantity); $i++){
                    $result = mysqli_query($db,"INSERT INTO power_accessories VALUES ('$insertedToolid', '', '$toolAccessoryQuantity[$i]', '$toolAccessoryDescription[$i]')");
                    if(!$result){
                        array_push($error_msg,  "Insert power_accessories table failed!");
                    }
                }
                    
            }
            
            switch ($toolSubType){
                    case 'Drill':
                    $drillAdjustableClutch = mysqli_real_escape_string($db, $_POST['adjustable-clutch']);
                    $drillMinTorque = mysqli_real_escape_string($db, $_POST['min-torque-rating']);
                    $drillMaxTorque = mysqli_real_escape_string($db, $_POST['max-torque-rating']);
                    $result = mysqli_query($db,"INSERT INTO drill VALUES ('$insertedToolid', '$drillAdjustableClutch', '$drillMinTorque', '$drillMaxTorque')");
                    if(!$result){
                        array_push($error_msg,  "Insert drill table failed!");
                    }
            
                    break;
                    case 'Saw':
                    $sawBladeSize = mysqli_real_escape_string($db, $_POST['blade-size']);
                    $result = mysqli_query($db,"INSERT INTO saw VALUES ('$insertedToolid', '$sawBladeSize')");
                    if(!$result){
                        array_push($error_msg,  "Insert saw table failed!");
                    }
                    break;
                    case 'Sander':
                    $sanderDustBag = mysqli_real_escape_string($db, $_POST['dust-bag']);
                    $result = mysqli_query($db,"INSERT INTO sander VALUES ('$insertedToolid', '$sanderDustBag')");
                    if(!$result){
                        array_push($error_msg,  "Insert sander table failed!");
                    }
                    break;
                    case 'Air-Compressor':
                    $acTankSize = mysqli_real_escape_string($db, $_POST['tank-size']);
                    $acPressureRating = mysqli_real_escape_string($db, $_POST['pressure-rating']);
                    $result = mysqli_query($db,"INSERT INTO air_compressor VALUES ('$insertedToolid', '$acTankSize', '$acPressureRating')");
                    if(!$result){
                        array_push($error_msg,  "Insert saw air_compressor failed!");
                    }
                    break;
                    case 'Mixer':
                    $mixerMotorRating = mysqli_real_escape_string($db, $_POST['mixer_motor-rating']);
                    $mixerDrumSize = mysqli_real_escape_string($db, $_POST['drum-size']);
                    $result = mysqli_query($db,"INSERT INTO mixer VALUES ('$insertedToolid', '$mixerMotorRating', '$mixerDrumSize')");
                    if(!$result){
                        array_push($error_msg,  "Insert saw mixer failed!");
                    }
                    break;
                    case 'Generator':
                    $generatorMotorRating = mysqli_real_escape_string($db, $_POST['generator_motor-rating']);
                    $result = mysqli_query($db,"INSERT INTO generator VALUES ('$insertedToolid', '$generatorMotorRating')");
                    if(!$result){
                        array_push($error_msg,  "Insert generator table failed!");
                    }
                    break;
            }
            break;
    }
    
    include('lib/show_queries.php');
    mysqli_close($query);
}
?>

<script>
    function appendPage() {
        var cont=document.getElementById("powerTool");
        var html = "<h3>Power Tools Only</h3><strong>Power Source</strong> " + '<select id="power_source" name="power_source" onchange="appendCordless()" style = "width:150px" required></select><br />'
        +"<br/><strong>A/C Volt Rating </strong>" + '<select id = "ac_volt_raing" name = "ac_volt_raing" style = "width:150px" disabled><option value=""></option><option value="110">110</option><option value="120">120</option><option value="220">220</option><option value="240">240</option></select>Volts&nbsp'
        + '<strong>Amp Rating </strong>'+ '<input type="text" name ="amp_rating" style = "width:100px"/>&nbsp'
        + '<strong>Amp Unit </strong>'+'<select name ="amp_unit" style = "width:150px"><option value="mili">mili</option><option value=""></option><option value="kilo">kilo</option></select>Amps<br/>'
        + '<br/><strong>min-rpm-rating </strong>'+'<input type="text" name ="min_rpm_rating" style = "width:200px"/> RPM&nbsp&nbsp&nbsp'
        + '<strong>max-rpm-rating </strong>'+'<input type="text" name ="max_rpm_rating" style = "width:200px"/>RPM<br/>'
        + '<h3>Power Tools Accessory</h3>'  
        +'<button type = "button" onclick = "addAccessories()">Add Accessory</button>';
        cont.innerHTML=html;
    }
    
    function appendCordless(){
        var cont1=document.getElementById("power_source");
        var cont2=document.getElementById("cordlessTool");
        var cont3=document.getElementById("ac_volt_raing");
        if (cont1.options[cont1.selectedIndex].value == "cordless(D/C)"){
            cont3.disabled = true;
            cont2.innerHTML="";
            cont2.innerHTML += "<h3>Cordless Tools Only</h3>"
                + '<strong>Battery Type </strong>' + '<select id="battery_type" name="battery_type" style = "width:100px">'
                +'<option value="Li-Ion">Li-Ion</option>'
                +'<option value="NiCd">NiCd</option>'
                +'<option value="NiMH">NiMH</option></select>&nbsp'
                + '<strong>Battery Quantity </strong>' + '<input type="number" name="battery_quantity" value=1 min = "1" style = "width:100px"/>&nbsp'
                + '<strong>D/C Volt Rating (7.2-80.0 Volts) </strong>' 
                + '<input type="number" name="dc_volt_rating" value= "7.2" min="7.2" max = "80.0" step = "0.1" style = "width:100px"/>&nbsp';
        } else if (cont1.options[cont1.selectedIndex].value == "electric(A/C)"){
            cont3.disabled = false;
            cont2.innerHTML="";
        } else{
            cont3.disabled = true;
            cont2.innerHTML="";
        }
    }
    
    //reference: https://www.abeautifulsite.net/adding-and-removing-elements-on-the-fly-using-javascript
    var accessoryId = 0;
    function addAccessories(){
        accessoryId++;
        var accessaryID = 'accessory_'+accessoryId;
        var html = '<br/><strong>Accessory Quantity </strong>' +'<input type="number" name ="accessory_quantity[]" min = "0" style = "width:100px"/>&nbsp'+'<strong>Accessory Description </strong>'+'<input type="text" name ="accessory_description[]" placeholder = "Enter accessory description" style = "width:250px"/>'+"<button type='button' onclick='removeAccesory("+ '"' +accessaryID + '"'+");'>Remove</button><br/>";
        addAccessory('accessory_description_list', accessaryID, html);
    }

    function addAccessory(accessoriesId, accessoryID, html) {
        var cont = document.getElementById(accessoriesId);
        cont.innerHTML += '<p id ="' + accessoryID + '">' + html + '</p>';
    }
    
    function removeAccesory(accessoryId) {
        var cont = document.getElementById(accessoryId);
        cont.parentNode.removeChild(cont);
    }
    
    function removePage() {
        var cont=document.getElementById("powerTool");
        cont.innerHTML="";
    }

    function generateSubtype(type){
        var curSubtype = document.getElementById("sub_type");
        var curExtradetail = document.getElementById("extraDetail");
        var curSuboption = document.getElementById("sub_option");
        var availablePowerSource = document.getElementById("power_source");
        var cont=document.getElementById("cordlessTool");
        cont.innerHTML="";
        curSubtype.options.length=0;
        curSuboption.options.length = 0;
        switch (type)
                {
                  case "HandTool": 
                        curSubtype.add(new Option("",""));
                        curSubtype.add(new Option("Screwdriver","Screwdriver"));
                        curSubtype.add(new Option("Socket","Socket"));
                        curSubtype.add(new Option("Ratchet","Ratchet"));
                        curSubtype.add(new Option("Wrench","Wrench"));
                        curSubtype.add(new Option("Pliers","Pliers"));
                        curSubtype.add(new Option("Gun","Gun"));
                        curSubtype.add(new Option("Hammer","Hammer"));
                        curExtradetail.innerHTML=""; 
                        break;
                  case "GardenTool": 
                        curSubtype.add(new Option("",""));
                        curSubtype.add(new Option("Digger","Digger"));
                        curSubtype.add(new Option("Pruner","Pruner"));
                        curSubtype.add(new Option("Rakes","Rakes"));
                        curSubtype.add(new Option("Wheelbarrows","Wheelbarrows"));
                        curSubtype.add(new Option("Striking","Striking"));
                        curExtradetail.innerHTML="";
                        curExtradetail.innerHTML+='<strong>handle-material </strong>'
                                                    +'<select name="handle-material" style="width:100px">'
                                                    +'<option value="wooden">wooden</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option>'
                                                    +'<option value="metal">metal</option></select>';
                        break;
                  case "Ladder": 
                        curSubtype.add(new Option("",""));
                        curSubtype.add(new Option("Straight","Straight"));
                        curSubtype.add(new Option("Step","Step"));
                        curExtradetail.innerHTML="";
                        curExtradetail.innerHTML+='<strong>step-count </strong>'
                                                    +'<select name="step-count" style="width:100px">'
                                                    +'<option value=" "> </option>'
                                                    +'<option value="2">2</option>'
                                                    +'<option value="8">8</option>'
                                                    +'<option value="20">20</option></select>&nbsp';
                        curExtradetail.innerHTML+='<strong>weight-capacity </strong>'
                                                    +'<select name="weight-capacity" style="width:100px">'
                                                    +'<option value=" "> </option>'
                                                    +'<option value="250">250</option>'
                                                    +'<option value="300">300</option>'
                                                    +'<option value="380">380</option></select>pound';
                        break;
                  case "PowerTool": 
                        availablePowerSource.options.length=0;
                        curSubtype.add(new Option("",""));
                        curSubtype.add(new Option("Drill","Drill"));
                        curSubtype.add(new Option("Saw","Saw"));
                        curSubtype.add(new Option("Sander","Sander"));
                        curSubtype.add(new Option("Air-Compressor","Air-Compressor"));
                        curSubtype.add(new Option("Mixer","Mixer"));
                        curSubtype.add(new Option("Generator","Generator"));
                        curExtradetail.innerHTML="";
                                }
                        }
                        
      function generateSuboption() {
                  var curSubtype = document.getElementById("sub_type");
                  var curSuboption = document.getElementById("sub_option");
                  var curExtradetail = document.getElementById("extraDetail");
                  var availablePowerSource = document.getElementById("power_source");
                  var cont=document.getElementById("cordlessTool");
                  var cont2=document.getElementById("ac_volt_raing");
                  cont.innerHTML="";
                  curSuboption.options.length = 0; 
                  if (document.getElementById("type4").checked) {
                      availablePowerSource.options.length = 0;
                  }
                  var selectedSubtype = curSubtype.options[curSubtype.selectedIndex].value;
                  switch (selectedSubtype)
                    {
                                    case "Screwdriver":
                                        curSuboption.add(new Option("phillips(cross)","phillips"));
                                        curSuboption.add(new Option("hex","hex"));
                                        curSuboption.add(new Option("torx","torx"));
                                        curSuboption.add(new Option("slotted(flat)","slotted"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>screw-size </strong>'
                                                                +'<select name="screw-size" style="width:100px">'
                                                                +'<option value="#2">#2</option>'
                                                                +'<option value="#2">#3</option>'
                                                                +'<option value="#2">#8</option></select>';
                                        break;
                                    case "Socket":
                                        curSuboption.add(new Option("deep","deep"));
                                        curSuboption.add(new Option("standard","standard"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>drive-size </strong>'
                                                                +'<select name="socket_drive-size" style="width:100px">'
                                                                +'<option value="1/2">1/2</option>'
                                                                +'<option value="3/8">3/8</option></select> in.&nbsp';
                                        curExtradetail.innerHTML+='<strong>sae-size </strong>'
                                                                +'<select name="sae-size" style="width:100px">'
                                                                +'<option value="1/4">1/4</option>'
                                                                +'<option value="5/16">5/16</option></select> in.&nbsp';
                                        curExtradetail.innerHTML+='<strong>deep-socket </strong>'
                                                                +'<select name="deep-socket" style="width:100px">'
                                                                +'<option value=""></option>'
                                                                +'<option value="true">true</option>'
                                                                +'<option value="false">false</option></select>';
                                        break;
                                    case "Ratchet":
                                        curSuboption.add(new Option("adjustable","adjustable"));
                                        curSuboption.add(new Option("fixed","fixed"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>drive-size </strong>'
                                                                +'<select name="ratchet_drive-size" style="width:100px">'
                                                                +'<option value="1/2">1/2</option>'
                                                                +'<option value="3/8">3/8</option></select> in.';
                                        break;
                                    case "Wrench":
                                        curSuboption.add(new Option("crescent","crescent"));
                                        curSuboption.add(new Option("torque","torque"));
                                        curSuboption.add(new Option("pipe","pipe"));
                                        curExtradetail.innerHTML="";
                                        break;
                                    case "Pliers":
                                        curSuboption.add(new Option("needle nose","needle nose"));
                                        curSuboption.add(new Option("cutting","cutting"));
                                        curSuboption.add(new Option("crimper","crimper"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>adjustable </strong>'
                                                                +'<select name="adjustable" style="width:100px">'
                                                                +'<option value="true">true</option>'
                                                                +'<option value="false">false</option></select>';
                                        break;
                                    case "Gun":
                                        curSuboption.add(new Option("nail","nail"));
                                        curSuboption.add(new Option("staple","staple"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>gauge-rating </strong>'
                                                                +'<select name="gauge-rating" style="width:100px">'
                                                                +'<option value=""></option>'
                                                                +'<option value="18">18</option>'
                                                                +'<option value="20">20</option>'
                                                                +'<option value="22">22</option>'
                                                                +'<option value="24">24</option></select> G &nbsp';
                                        curExtradetail.innerHTML+='<strong>capacity </strong>'
                                                                +'<select name="capacity" style="width:100px">'
                                                                +'<option value="20">20</option>'
                                                                +'<option value="100">100</option>'
                                                                +'<option value="1000">1000</option></select> number of nails/staples&nbsp';
                                        break;
                                    case "Hammer":
                                        curSuboption.add(new Option("claw","claw"));
                                        curSuboption.add(new Option("sledge","sledge"));
                                        curSuboption.add(new Option("framing","framing"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>anti-vibration </strong>'
                                                                +'<select name="anti-vibration" style="width:100px">'
                                                                +'<option value="true">true</option>'
                                                                +'<option value="false">false</option></select>';
                                        break;
                                    case "Digger":
                                        curSuboption.add(new Option("pointed shovel","pointed shovel"));
                                        curSuboption.add(new Option("flat shovel","flat shovel"));
                                        curSuboption.add(new Option("scoop shovel","scoop shovel"));
                                        curSuboption.add(new Option("edger","edger"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>handle-material </strong>'
                                                    +'<select name="handle-material" style="width:100px">'
                                                    +'<option value="wooden">wooden</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option>'
                                                    +'<option value="metal">metal</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>blade-width </strong>'
                                                    +'<select name="blade-width" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="9-3/4">9-3/4</option>'
                                                    +'<option value="6-1/2">6-1/2</option></select> in.&nbsp';
                                        curExtradetail.innerHTML+='<strong>blade-length </strong>'
                                                    +'<select name="digger_blade-length" style="width:100px">'
                                                    +'<option value="6-1/2">6-1/2</option>'
                                                    +'<option value="10-1/8">10-1/8</option></select>in.';
                                        break;
                                    case "Pruner":
                                        curSuboption.add(new Option("sheer","sheer"));
                                        curSuboption.add(new Option("loppers","loppers"));
                                        curSuboption.add(new Option("hedge","hedge"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>handle-material </strong>'
                                                    +'<select name="handle-material" style="width:100px">'
                                                    +'<option value="wooden">wooden</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option>'
                                                    +'<option value="metal">metal</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>blade-material </strong>'
                                                    +'<select name="blade-material" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="steel">steel</option>'
                                                    +'<option value="titanium">titanium</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>blade-length </strong>'
                                                    +'<select name="pruner_blade-length" style="width:100px">'
                                                    +'<option value="24">24</option>'
                                                    +'<option value="5-1/8">5-1/8</option></select>in.';
                                        break;
                                    case "Rakes":
                                        curSuboption.add(new Option("leaf","leaf"));
                                        curSuboption.add(new Option("landscaping","landscaping"));
                                        curSuboption.add(new Option("rock","rock"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>handle-material </strong>'
                                                    +'<select name="handle-material" style="width:100px">'
                                                    +'<option value="wooden">wooden</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option>'
                                                    +'<option value="metal">metal</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>tine-count </strong>'
                                                    +'<select name="tine-count" style="width:100px">'
                                                    +'<option value="14">14</option>'
                                                    +'<option value="16">16</option></select>tine';
                                        break;
                                    case "Wheelbarrows":
                                        curSuboption.add(new Option("1-wheel","1-wheel"));
                                        curSuboption.add(new Option("2-wheel","2-wheel"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>handle-material </strong>'
                                                    +'<select name="handle-material" style="width:100px">'
                                                    +'<option value="wooden">wooden</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option>'
                                                    +'<option value="metal">metal</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>bin-material </strong>'
                                                    +'<select name="bin-material" style="width:100px">'
                                                    +'<option value="steel">steel</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>bin-volume </strong>'
                                                    +'<select name="bin-volume" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="5.9">5.9</option>'
                                                    +'<option value="10.2">10.2</option></select> cu ft.<br />';
                                        curExtradetail.innerHTML+='<br /><strong>wheel-count </strong>'
                                                    +'<select name="wheel-count" style="width:100px">'
                                                    +'<option value="1">1</option>'
                                                    +'<option value="2">12</option></select>';
                                        break;
                                    case "Striking":
                                        curSuboption.add(new Option("bar pry","bar pry"));
                                        curSuboption.add(new Option("rubber mallet","rubber mallet"));
                                        curSuboption.add(new Option("tamper","tamper"));
                                        curSuboption.add(new Option("pick axe","pick axe"));
                                        curSuboption.add(new Option("single bit axe","single bit axe"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>handle-material </strong>'
                                                    +'<select name="handle-material" style="width:100px">'
                                                    +'<option value="wooden">wooden</option>'
                                                    +'<option value="fiberglass">fiberglass</option>'
                                                    +'<option value="poly">poly</option>'
                                                    +'<option value="metal">metal</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>head-weight </strong>'
                                                    +'<select name="head-weight" style="width:100px">'
                                                    +'<option value="3.5">3.5</option>'
                                                    +'<option value="8.9">8.9</option></select>lb.';
                                        break;
                                    case "Straight":
                                        curSuboption.add(new Option("rigid","rigid"));
                                        curSuboption.add(new Option("telescoping","telescoping"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>step-count </strong>'
                                                    +'<select name="step-count" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="2">2</option>'
                                                    +'<option value="8">8</option>'
                                                    +'<option value="20">20</option>&nbsp';
                                        curExtradetail.innerHTML+='<strong>weight-capacity </strong>'
                                                    +'<select name="weight-capacity" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="250">250</option>'
                                                    +'<option value="300">300</option>'
                                                    +'<option value="380">380</option></select>pound&nbsp';
                                        curExtradetail.innerHTML+='<strong>rubber-feet </strong>'
                                                    +'<select name="rubber-feet" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="true">true</option>'
                                                    +'<option value="false">false</option></select>';
                                        break;
                                    case "Step":
                                        curSuboption.add(new Option("folding","floding"));
                                        curSuboption.add(new Option("multi-position","multi-position"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>step-count </strong>'
                                                    +'<select name="step-count" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="2">2</option>'
                                                    +'<option value="8">8</option>'
                                                    +'<option value="20">20</option>&nbsp';
                                        curExtradetail.innerHTML+='<strong>weight-capacity </strong>'
                                                    +'<select name="weight-capacity" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="250">250</option>'
                                                    +'<option value="300">300</option>'
                                                    +'<option value="380">380</option></select>pound&nbsp';
                                        curExtradetail.innerHTML+='<strong>pail-shelf </strong>'
                                                    +'<select name="pail-shelf" style="width:100px">'
                                                    +'<option value=""></option>'
                                                    +'<option value="true">true</option>'
                                                    +'<option value="false">false</option></select>';
                                        break;
                                    case "Drill":
                                        availablePowerSource.options.length=0;
                                        cont2.disabled=true;
                                        curSuboption.add(new Option("driver","driver"));
                                        curSuboption.add(new Option("hammer","hammer"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>adjustable-clutch </strong>'
                                                                +'<select name="adjustable-clutch" style="width:100px">'
                                                                +'<option value="true">true</option>'
                                                                +'<option value="false">false</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>min-torque-rating </strong>'
                                                                +'<select name="min-torque-rating" style="width:100px">'
                                                                +'<option value="80.0">80.0</option>'
                                                                +'<option value="3500">3500</option></select> ft-lb&nbsp';
                                        curExtradetail.innerHTML+='<strong>max-torque-rating </strong>'
                                                                +'<select name="max-torque-rating" style="width:100px">'
                                                                +'<option value=" "> </option>'
                                                                +'<option value="120.2">120.2</option>'
                                                                +'<option value="7500">7500</option>ft-lb</select>';
                                        availablePowerSource.add(new Option("", ""));
                                        availablePowerSource.add(new Option("electric(A/C)", "electric(A/C)"));
                                        availablePowerSource.add(new Option("cordless(D/C)", "cordless(D/C)"));
                                        break;
                                    case "Saw":
                                        cont2.disabled=true;
                                        availablePowerSource.options.length=0;
                                        curSuboption.add(new Option("circular","circular"));
                                        curSuboption.add(new Option("reciprocating","reciprocating"));
                                        curSuboption.add(new Option("jig","jig"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>blade-size </strong>'
                                                                +'<select name="blade-size" style="width:100px">'
                                                                +'<option value="7-3/4">7-3/4</option>'
                                                                +'<option value="6-1/2">6-1/2</option></select>&nbsp';
                                        availablePowerSource.add(new Option("", ""));
                                        availablePowerSource.add(new Option("electric(A/C)", "electric(A/C)"));
                                        availablePowerSource.add(new Option("cordless(D/C)", "cordless(D/C)"));
                                        break;
                                    case "Sander":
                                        cont2.disabled=true;
                                        availablePowerSource.options.length=0;
                                        curSuboption.add(new Option("finish","finish"));
                                        curSuboption.add(new Option("sheet","sheet"));
                                        curSuboption.add(new Option("belt","belt"));
                                        curSuboption.add(new Option("random orbital","random orbital"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>dust-bag </strong>'
                                                                +'<select name="dust-bag" style="width:100px">'
                                                                +'<option value="true">true</option>'
                                                                +'<option value="false">false</option></select>&nbsp';
                                        availablePowerSource.add(new Option("", ""));
                                        availablePowerSource.add(new Option("electric(A/C)", "electric(A/C)"));
                                        availablePowerSource.add(new Option("cordless(D/C)", "cordless(D/C)"));
                                        break;
                                    case "Air-Compressor":
                                        cont2.disabled=true;
                                        availablePowerSource.options.length=0;
                                        curSuboption.add(new Option("reciprocating","reciprocating"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>tank-size </strong>'
                                                                +'<select name="tank-size" style="width:100px">'
                                                                +'<option value="7">7</option>'
                                                                +'<option value="10">10</option>'
                                                                +'<option value="30">30</option></select>&nbsp';
                                        curExtradetail.innerHTML+='<strong>pressure-rating </strong>'
                                                                +'<select name="pressure-rating" style="width:100px">'
                                                                +'<option value=" "> </option>'
                                                                +'<option value="300.0">300.0</option>'
                                                                +'<option value="25000">25000</option></select> psi&nbsp';
                                        availablePowerSource.add(new Option("", ""));
                                        availablePowerSource.add(new Option("electric(A/C)", "electric(A/C)"));
                                        availablePowerSource.add(new Option("gas", "gas"));
                                        break;
                                    case "Mixer":
                                        cont2.disabled=true;
                                        availablePowerSource.options.length=0;
                                        curSuboption.add(new Option("concrete","concrete"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>motor-rating </strong>'
                                                                +'<select name="mixer_motor-rating" style="width:100px">'
                                                                +'<option value="1/2">1/2</option>'
                                                                +'<option value="3/4">3/4</option>'
                                                                +'<option value="2/3">2/3</option></select>HP&nbsp';
                                        curExtradetail.innerHTML+='<strong>drum-size </strong>'
                                                                +'<select name="drum-size" style="width:100px">'
                                                                +'<option value="3.5">3.5</option>'
                                                                +'<option value="6.0">6.0</option></select> cu ft.&nbsp';
                                        availablePowerSource.add(new Option("", ""));
                                        availablePowerSource.add(new Option("electric(A/C)", "electric(A/C)"));
                                        availablePowerSource.add(new Option("gas", "gas"));
                                        break;
                                    case "Generator":
                                        cont2.disabled=true;
                                        availablePowerSource.options.length=0;
                                        curSuboption.add(new Option("electric","electric"));
                                        curExtradetail.innerHTML="";
                                        curExtradetail.innerHTML+='<strong>motor-rating </strong>'
                                                                +'<select name="generator_motor-rating" style="width:100px">'
                                                                +'<option value="18.0">18.0</option>'
                                                                +'<option value="30">30</option>'
                                                                +'<option value="88">88</option>'
                                                                +'<option value="10000">10000</option></select>Watts&nbsp';
                                        availablePowerSource.add(new Option("", ""));
                                        availablePowerSource.add(new Option("gas", "gas"));
                                        break;             
                                }                      
                        }                  
</script>



<?php include("lib/header.php"); ?>
<title>Add New Tool</title>
</head>
<body>
<div id="main_container">
    <?php include("lib/clerk_menu.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
            </div>          
            <div class="features">   
                <div class="add_tool_section">
                    <div class="subtitle">Add New Tool</div>
                     <div>
                        <form name = "add_new_tool" action = "add_new_tool.php" method = "POST">
                         <strong>Type:</strong> 
                            <input type="radio" id = "type1" name="tool_type" value="Hand Tool" checked onclick= 'removePage(); generateSubtype("HandTool");'/> Hand Tool
                            <input type="radio" id = "type2" name="tool_type" value="Garden Tool" onclick='removePage(); generateSubtype("GardenTool");'/> Garden Tool
                            <input type="radio" id = "type3" name="tool_type" value="Ladder" onclick='removePage(); generateSubtype("Ladder");'/> Ladder
                            <input type="radio" id = "type4" name="tool_type" value="Power Tool" onclick='appendPage(); generateSubtype("PowerTool");'/>Power Tool
                            <br/><br/>
                            <strong>Sub-Type </strong><select id="sub_type" name="sub_type" style = "width:250px" onchange="generateSuboption()" required>
                            <option value=""></option>
                            <option value="Screwdriver">Screwdriver</option>
                            <option value="Socket">Socket</option>
                            <option value="Ratchet">Ratchet</option>
                            <option value="Wrench">Wrench</option>
                            <option value="Pliers">Pliers</option>
                            <option value="Gun">Gun</option>
                            <option value="Hammer">Hammer</option>
                            </select> 
                            <strong>Sub-Option </strong><select id="sub_option" name="sub_option" style = "width:250px" required></select>
                            <br/><br/>
                            <strong>Purchase_Price </strong><input type="number" step="0.1" min="0" name="purcahse_price" style = "width:100px" required/>
                            <strong>Material </strong><input type="text" name="material" style = "width:100px"/>
                            <strong>Manufacturer </strong><input type="text" name="manufacturer" placeholder ="Enter tool manufacturer" style = "width:250px" required/>
                            <br/><br/>
                            <strong>Width </strong><input type="number" step="0.1" name="width" min="0" style = "width:150px" required/>
                            <strong>Width Fraction </strong><select name="width_fraction" style = "width:70px">
                            <option value = '0'></option>
                            <option value='0.125'>1/8"</option>
                            <option value='0.25'>1/4"</option>
                            <option value='0.375'>3/8"</option>
                            <option value='0.5'>1/2"</option>
                            <option value='0.625'>5/8"</option>
                            <option value='0.75'>3/4"</option>
                            <option value='0.875'>7/8"</option>
                            </select>
                            <strong>Width Unit </strong><select name="width_unit" style = "width:70px">
                            <option value="inches">inches</option>
                            <option value="feet">feet</option>
                            </select>
                            <strong>Weight(lbs) </strong><input type="number" step="0.1" min="0" name="weight"/style = "width:50px" required />
                            <br/><br/>
                            <strong>Length </strong><input type="number" step="0.1" min="0" name="length" style = "width:150px"/>
                            <strong>Length Fraction </strong><select name="length_fraction" style = "width:70px">
                            <option value = '0'></option>
                            <option value='0.125'>1/8"</option>
                            <option value='0.25'>1/4"</option>
                            <option value='0.375'>3/8"</option>
                            <option value='0.5'>1/2"</option>
                            <option value='0.625'>5/8"</option>
                            <option value='0.75'>3/4"</option>
                            <option value='0.875'>7/8"</option>
                            </select>
                            <strong>Length Unit </strong><select name="length_unit" style = "width:70px">
                            <option value="inches">inches</option>
                            <option value="feet">feet</option>
                            </select>
                            <br/><br/>                  
                            <div id="extraDetail"></div>
                            <div id="powerTool"></div>
                            <div id="accessory_description_list"></div>
                            <div id="cordlessTool"></div>
                            <br/><input type="submit" name = "confirm_btn" value = "Confirm"/>
                        </form>
                    </div>
                    <br />
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