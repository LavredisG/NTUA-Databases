<!DOCTYPE html>
<?php include 'connect.php';  ?>
<html>
<head>
<link rel="stylesheet" href="style.css">
	<title>
	Sales and Client Info
	</title>
	<button onclick="window.location.href='1_Homepage.php';" class="submit_button" > <b>Go Back to Homepage</b> </button>
	<h1>Sales and Client Info</h1>
	<form action="#" method="post">
		<table style="padding-bottom:10px">
			<tr>
				<th><input type="submit" name="view1" value="Sales" style="font-size:25px; width:120px;" class="submit_button"></th>
				<th><input type="submit" name="view2" value="Client Info" style="font-size:25px; width:150px;" class="submit_button"></th>
			</tr>
		</table>
	</form>
</head>
<body>

	<table class="results">
	<?php 
	if(!empty($_POST['view1'])){
		echo '<tr>
			<th class = "header">Services
			</th>
			<th class = "header">Sales
			</th>
			</tr>';
			while($myrow = mysqli_fetch_assoc($view1)){
				echo "<tr>
				<td>{$myrow['Service_Description']}</td>
				<td>{$myrow['SALES']}</td>
				</tr>
				";
			}
		}


		if(!empty($_POST['view2'])){
			echo '<tr>
				<th class = "header">NFC_ID
				</th>
				<th class = "header">Name
				</th>
				<th class = "header">Surname
				</th>
				<th class = "header">Birthdate
				</th>
				<th class = "header">ID Num
				</th>
				<th class = "header">ID Type
				</th>
				<th class = "header">ID Issuer
				</th>
				<th class = "header">E-mail
				</th>
				<th class = "header">Phone
				</th>
				</tr>';
				while($myrow = mysqli_fetch_assoc($view2)){
					echo "<tr>
					<td>{$myrow['NFC_ID']}</td>
					<td>{$myrow['Name']}</td>
					<td>{$myrow['Surname']}</td>
					<td>{$myrow['Birthdate']}</td>
					<td>{$myrow['ID_Num']}</td>
					<td>{$myrow['ID_type']}</td>
					<td>{$myrow['ID_Issuer']}</td>
					<td>{$myrow['Email']}</td>
					<td>{$myrow['Phone']}</td>
					</tr>
					";
				}
			}

	?> 
	
	</table>
</body>
</html>