<?php include 'connect.php'; 

$conn = new mysqli($servername,$username,$password,'hotel');
if($conn->connect_error){
    die("Connection_failed: ".$conn->connect_error);
}
if(!empty($_POST['save'])){
	$firstpartA = "SELECT PL.Place_Name, COUNT(*) AS TOTAL
	FROM visits AS V, places as PL,clients as C
	WHERE V.Place_ID = PL.Place_ID AND V.NFC_ID = C.NFC_ID AND (YEAR(C.Birthdate) BETWEEN "; //for query 11a
	
	$prevdate=getdate(date("U"));
	$today = $prevdate['year'] . "-" . $prevdate['mon'] . "-". $prevdate['mday']; //to get today's date
	if($prevdate['mon'] == 1){
		$lastmonth = $prevdate['year']-1 . "-" . "12" . "-". $prevdate['mday'];
	}
	else $lastmonth = $prevdate['year'] . "-" . $prevdate['mon']-1 . "-". $prevdate['mday'];
	$lastyear = $prevdate['year']-1 . "-" . $prevdate['mon'] . "-". $prevdate['mday'];
	
	$monthpart = " AND V.Entrance_Date > '$lastmonth' ";
	$yearpart = " AND V.Entrance_Date > '$lastyear' ";

	$secondpartA=" GROUP BY V.Place_ID
	ORDER BY TOTAL DESC";

	if($_POST['agegroup'] == '1'){$firstpartA = $firstpartA . "1981 AND 2000)"; }
	if($_POST['agegroup'] == '2'){$firstpartA = $firstpartA . "1961 AND 1980)";}
	if($_POST['agegroup'] == '3'){$firstpartA = $firstpartA . "1000 AND 1960)"; }

	if($_POST['timep'] == '1' ){$firstpartA = $firstpartA . $monthpart;}
	if($_POST['timep'] == '2'){$firstpartA = $firstpartA . $yearpart;}
	$query11a = $firstpartA . $secondpartA;
	



	$firstpartB = "SELECT S.Service_Description, COUNT(*) AS TOTAL
	FROM services AS S, service_charge AS CH, clients as C
	WHERE S.Service_ID = CH.Service_ID AND C.NFC_ID = CH.NFC_ID AND (YEAR(C.Birthdate) BETWEEN ";

	$secondpartB = "GROUP BY CH.Service_ID
	ORDER BY TOTAL DESC";

	$monthpartB = " AND CH.Charge_Date > '$lastmonth' ";
	$yearpartB = " AND CH.Charge_Date > '$lastyear' ";

	if($_POST['agegroup'] == '1'){$firstpartB = $firstpartB . "1981 AND 2000)"; }
	if($_POST['agegroup'] == '2'){$firstpartB = $firstpartB . "1961 AND 1980)";}
	if($_POST['agegroup'] == '3'){$firstpartB = $firstpartB . "1000 AND 1960)"; }

	if($_POST['timep'] == '1' ){$firstpartB = $firstpartB . $monthpartB;}
	if($_POST['timep'] == '2'){$firstpartB = $firstpartB . $yearpartB;}
	$query11b = $firstpartB . $secondpartB;

	$firstpartC = "SELECT S.Service_Description, COUNT(DISTINCT CH.NFC_ID) AS CLIENTS_VISITED
	FROM service_charge as CH, services as S, clients as C
	WHERE S.Service_ID = CH.Service_ID AND CH.NFC_ID = C.NFC_ID AND (YEAR(C.Birthdate) BETWEEN ";
	
	$secondpartC = "GROUP BY CH.Service_ID ORDER BY CLIENTS_VISITED DESC"; 
	
	if($_POST['agegroup'] == '1'){$firstpartC = $firstpartC . "1981 AND 2000)"; }// monthpartC = monthpartB (same relation service_charge on both queries)
	if($_POST['agegroup'] == '2'){$firstpartC = $firstpartC . "1961 AND 1980)";}
	if($_POST['agegroup'] == '3'){$firstpartC = $firstpartC . "1000 AND 1960)"; }

	if($_POST['timep'] == '1' ){$firstpartC = $firstpartC . $monthpartB;}
	if($_POST['timep'] == '2'){$firstpartC = $firstpartC . $yearpartB;}
	$query11c = $firstpartC . $secondpartC;

}
$query11afinal = mysqli_query($conn,$query11a);
$query11bfinal = mysqli_query($conn,$query11b);
$query11cfinal = mysqli_query($conn,$query11c);

$conn->close();
?>

<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="style.css">
	<title>
		Usage Stats
	</title>
	<button onclick="window.location.href='1_Homepage.php';" class="submit_button" > <b>Go Back to Homepage</b> </button>
	<h1>Usage Statistics Per Age Group</h1>
</head>
<body>
<form action="#" method="post">
	
	<table>
	<tr>
	<td><h2 style="width: 400px;">Please enter your Age Group:</h2></td>
	<td>
	<select name="agegroup" class="input_field">
  <option value="1">20-40</option>
  <option value="2">41-60</option>
  <option value="3">61+</option>
	</select></td>
	<td>
	<select name="timep" class="input_field">
  <option value="1">Monthly</option>
  <option value="2">Yearly</option>
	</select></td>
	<td colspan="2" align="center" ><input type="submit" name="save" value="Search" style="font-size:25px" class="submit_button"></td>
	</tr>
	
	</table>
	<p style="color: transparent;">Filler</p>

</form>
	<div style="padding-left:8%; padding-right:5%" >
		<table class = "results" style="float: left"> 
		<tr>
		<th class="header">Most Visited Places</th>
		<th class="header">Total Visits</th>
		</tr>
		<?php
		while($myrow = mysqli_fetch_assoc($query11afinal)){
			echo "<tr>
			<td>{$myrow['Place_Name']}</td>
			<td>{$myrow['TOTAL']}</td>
			</tr>"; 
		}
		?>
		</table>

		<table class = "results" style="float: left"> 
		<tr>
		<th class="header">Most Used Services</th>
		<th class="header">Total Uses</th>
		</tr>
		<?php
		while($myrow = mysqli_fetch_assoc($query11bfinal)){
			echo "<tr>
			<td>{$myrow['Service_Description']}</td>
			<td>{$myrow['TOTAL']}</td>
			</tr>"; 
		}
		?>
		</table>

		<table class = "results" style="float: left"> 
		<tr>
		<th class="header">Services Used by People</th>
		<th class="header">Distinct People</th>
		</tr>
		<?php
		while($myrow = mysqli_fetch_assoc($query11cfinal)){
			echo "<tr>
			<td>{$myrow['Service_Description']}</td>
			<td>{$myrow['CLIENTS_VISITED']}</td>
			</tr>"; 
		}
		?>
		</table>
	</div>
