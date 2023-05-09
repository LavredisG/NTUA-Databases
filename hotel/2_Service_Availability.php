<?php include 'connect.php'; 

$conn = new mysqli($servername,$username,$password,'hotel');
if($conn->connect_error){
    die("Connection_failed: ".$conn->connect_error);
}

$visitquerry = "SELECT NULL LIMIT 0"; 

if(!empty($_POST['save'])){
  	$visitquerry = "SELECT DISTINCT S.Service_Description, V.Entrance_Date, V.Entrance_Time, V.Exit_Date, V.Exit_Time
    FROM services as S, places as PL, visits as V, is_provided as PR, service_charge as CH 
    WHERE V.Place_ID = PL.Place_ID and PL.Place_ID = PR.Place_ID and PR.Service_ID = S.Service_ID";
	if(!empty($_POST['checkbox_date'])){
		if (!empty($_POST['birthdate'])) {
			$visitquerry = $visitquerry . " and V.Entrance_Date = '{$_POST['birthdate']}'";
		}
	}
   if(!empty($_POST['checkbox_service'])){
	   $visitquerry = $visitquerry . " and S.Service_Description = '{$_POST['dropdownlist']}'";
   }
   if(!empty($_POST['checkbox_price'])){
	   if(!empty($_POST['numberbox'])){
		  $visitquerry = $visitquerry . " and CH.Service_ID = S.Service_ID and CH.Charge_Price < {$_POST['numberbox']}";
	   }
   }
   $visitquerry = $visitquerry . " ORDER BY V.Entrance_Date DESC, V.Entrance_Time DESC";
}
$visitquerryfinal = mysqli_query($conn,$visitquerry);
$conn->close();
?>

<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="style.css">
 <title>
    Service Availability
  </title>
  <button onclick="window.location.href='1_Homepage.php';" class="submit_button" align="center"> <b>Go Back to Homepage</b> </button>
  <h1>Service Availability</h1>
  <h2>Please fill in the search criteria:</h2>
</head>
<body>
<form action="#" method="post">
  <table>
  
  <tr>
      
      <th><input type="checkbox" name="checkbox_date" value="date">Date of interest:</th>
      <th><input type="checkbox" name="checkbox_service" value="type">Service:</th>
      <th><input type="checkbox" name="checkbox_price" value="price">Maximum Price:</th>
  </tr>
  <tr>
      <td><input type="date" name="birthdate" autocomplete="off" class="input_field"></td>
      <td><select name = 'dropdownlist' class="input_field">
      <?php
        while($myrow = mysqli_fetch_assoc($dropdowncontents)){
          echo "<option value={$myrow['Service_Description']}> {$myrow['Service_Description']} </option>";
        }
      ?>
      </select></td>
      <td><input name="numberbox" type="number" value="0" class="input_field"></td>
      <td colspan="2" align="center" ><input type="submit" name="save" value="Search" style="font-size:25px" class="submit_button"></td>
  </tr>

</form>
   
     <table class="results"> 
    <tr>
      <th class = "header">Service</th>
      <th class = "header">Entrance_Date</th>
      <th class = "header">Entrance_Time</th>
      <th class = "header">Exit_Date</th>
      <th class = "header">Exit_Time</th>  
    </tr>
    <?php 
		while($myrow = mysqli_fetch_assoc($visitquerryfinal)){
			echo "<tr>
				<td>{$myrow['Service_Description']}</td>
				<td>{$myrow['Entrance_Date']}</td>
				<td>{$myrow['Entrance_Time']}</td>
				<td>{$myrow['Exit_Date']}</td>
				<td>{$myrow['Exit_Time']}</td>
				</tr>";
		}
    ?>
  </table>
</body>
</html>