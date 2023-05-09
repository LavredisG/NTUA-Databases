<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<?php
include 'connect.php'; 

$conn = new mysqli($servername,$username,$password,'hotel');
if($conn->connect_error){
    die("Connection_failed: ".$conn->connect_error);
}

if(!empty($_POST['save'])){
	if(!empty($_POST['NFC'])){
		$query9 = "SELECT PL.Place_Name, V.Entrance_Date, V.Entrance_Time, V.Exit_Date, V.Exit_Time
		FROM clients as C, visits as V, places as PL
		WHERE C.NFC_ID = V.NFC_ID AND PL.Place_ID = V.Place_ID AND C.NFC_ID = {$_POST['NFC']}";

		$query10 = "select distinct  clients.NFC_ID, Name, Surname
		from    clients, visits, (select NFC_ID, Place_ID,Entrance_Time, Exit_Time, Entrance_Date, Exit_Date
			from    visits
			where   visits.NFC_ID = {$_POST['NFC']}) as infected
		where   (infected.Place_ID = visits.Place_ID) 
				and (not (infected.NFC_ID = visits.NFC_ID)) and
				(clients.NFC_ID = visits.NFC_ID)     and 
				(infected.Entrance_Date = visits.Entrance_Date) and
				(((visits.Entrance_Time >= infected.Entrance_Time) and
				(visits.Entrance_Time <= infected.Exit_Time + 010000)) or
				((visits.Exit_Time >= infected.Entrance_Time) and
				(visits.Exit_Time <= infected.Exit_Time + 010000)))";
	}
}
$final9 = mysqli_query($conn,$query9);
$final10 = mysqli_query($conn,$query10);
$conn->close();
?>
	<title>
		COVID-19 Tracking
	</title>
	<button onclick="window.location.href='1_Homepage.php';" class="submit_button" > <b>Go Back to Homepage</b> </button>
	<h1>COVID-19 Tracking</h1>
</head>
<body>
<form action="#" method="post">
	
	<table>
	<tr>
	<td><h2 style="width: 400px;">Please enter your NFC number:</h2></td>
	<td><input type="number" min="1" max ="<?php echo $maxnumber;?>" name="NFC" autocomplete="off" class="input_field"></td>
	<td colspan="2" align="center" ><input type="submit" name="save" value="Search" style="font-size:25px" class="submit_button"></td>
	</tr>
	
	</table>
	<p style="color: transparent;">Filler</p>

</form>
<?php
	if(!empty($_POST['save'])){
		if(!empty($_POST['NFC'])){
		echo '<table > 
		<table class="results" width="71% padding-bottom="50%">
		<tr><th></th><th >Possibly Infected</th></tr>
		<tr>

		<tr>
		<th class="header">NFC</th>
		<th class="header">Name</th>
		<th class="header">Surname</th>
		</tr>';
		while($myrow = mysqli_fetch_assoc($final10)){
			echo "<tr>
			<td>{$myrow['NFC_ID']}</th>
			<td>{$myrow['Name']}</th>
			<td>{$myrow['Surname']}</th>
			</tr>";}

			echo '</table>
			</tr>
			<p></p>
			<tr>
			<table class="results" width = "71%"> 
			<tr> 
				<th></th>
				<th></th>
				<th>Client Visits</th>
			</tr>
						<tr>
						<th class="header">Place</th>
						<th class="header">Entrance Date</th>
							<th class="header">Entrance Time</th>
							<th class="header">Exit Date</th>
							<th class="header">Exit Time</th>
							</tr>';
						while($myrow = mysqli_fetch_assoc($final9)){
							echo "<tr>
							<td>{$myrow['Place_Name']}</th>
							<td>{$myrow['Entrance_Date']}</th>
							<td>{$myrow['Entrance_Time']}</th>
							<td>{$myrow['Exit_Date']}</th>
							<td>{$myrow['Exit_Time']}</th>
							</tr>";
						}
						
					echo '</table>
				</tr>
				
				
	
	</table>';
		}
	else echo '<table class="results"> 
	<tr>
	<th class="header">Please enter a valid NFC</th>
	</tr>';	
	}
?>
</body>
</html>