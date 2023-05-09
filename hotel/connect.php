<?php
$servername = "localhost";
$username = "root";
$password = "";
//Create connecrtion
$conn = new mysqli($servername,$username,$password,'hotel');
if($conn->connect_error){
    die("Connection_failed: ".$conn->connect_error);
}


$dropdowncontents = mysqli_query($conn,"SELECT * FROM services");

$forview1 = "SELECT * FROM sales_per_service";
$forview2 = "SELECT * FROM client_info";

$view1 = mysqli_query($conn,$forview1);
$view2 = mysqli_query($conn,$forview2);
$query9 = "SELECT NULL LIMIT 0";
$query10 = "SELECT NULL LIMIT 0";
$query11a = "SELECT NULL LIMIT 0";
$query11b = "SELECT NULL LIMIT 0";
$query11c = "SELECT NULL LIMIT 0";
$totalclients = mysqli_query($conn,"SELECT COUNT(*) AS TOTAL FROM clients");
$maxnumber = mysqli_fetch_assoc($totalclients);
$maxnumber = $maxnumber['TOTAL'];


$conn->close();
?>