<!DOCTYPE html>
<html>
<head>
	<style>
	table, th, td {
		border: 1px solid black;
	}

table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: center;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}

</style>

</head>
<body>
	<div class="container">
	<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$conn = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");

	if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT ID, item_section, location,item,feature,price FROM cato";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
echo "<table class=\"blueTable\"><thead><tr><th>ID</th><th>Item_section</th><th>Location</th><th>Item</th><th>Feature</th><th>Price</th></tr></thead>";
	while($row = $result->fetch_assoc()) {
	echo "<tdata><tr><td>" . $row["ID"]. "</td><td>" . $row["item_section"]. "</td><td>" . $row["location"]. "</td><td>" . $row["item"]."</td><td>" . $row["feature"]."</td><td>" . $row["price"]."</td></tr></tdata>";
}
echo "</table>";
} else {
echo "0 results";
}
$conn->close();
?> 
</div>
</body>
</html>
