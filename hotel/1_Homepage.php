<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" href="style.css">

	<title>
		Starting Page
	</title>
	<h1 style="padding-bottom: 10px; padding-top: 20px;">Welcome to ASDF Palace!</h1>
	<h2 style="padding-bottom: 20px;">What would you like to see?</h2>
</head>
<body>
	<table>
		<tr>
			<td><input type="button" name="service_avail" value="[7] Service Availability" class="button" onclick="window.location.href='2_Service_Availability.php';"></td>
			<td><input type="button" name="quest8" value="[8]Sales and Client Info" class="button" onclick="window.location.href='4_Question8.php';"></td>
			
		</tr>
		<tr>
		    <td><input type="button" name="covid_tracking" value="[9&10] COVID-19 Tracking" class="button" onclick="window.location.href='3_COVID_Tracking.php';"></td>
			<td><input type="button" name="usr_stats" value="[11] Usage Statistics Per Age Group" class="button" onclick="window.location.href='5_User_Stats.php';"></td>
		</tr>
	</table>
</body>
</html>