<!DOCTYPE html>
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>

table, th, td {
    border: 1px solid black;
}
table.paleBlueRows {
  font-family: "Times New Roman",Times,serif;
  border: 1px solid #FFFFFF;
  width: 350px;
  height: 200px;
  text-align: center;
  border-collapse: collapse;
}
table.paleBlueRows td, table.paleBlueRows th {
  border: 1px solid #FFFFFF;
  padding: 3px 2px;
}
table.paleBlueRows tbody td {
  font-size: 18px;
}
table.paleBlueRows tr:nth-child(even) {
  background: #D0E4F5;
}
table.paleBlueRows thead {
  background: #0B6FA4;
  border-bottom: 5px solid #FFFFFF;
}
table.paleBlueRows thead th {
  font-size: 21px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
  border-left: 2px solid #FFFFFF;
}
table.paleBlueRows thead th:first-child {
  border-left: none;
}

table.paleBlueRows tfoot td {
  font-size: 14px;
}
</style>
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

   $conn = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, qty, price,name FROM data";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
echo "<table class=\"paleBlueRows\"><thead><tr><th>ID</th><th>Item Name</th><th>Quantity</th><th>Price</th></tr></thead><tbody>";

    while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"] . "</td><td>" . $row["qty"]. "</td><td>" . $row["price"]."</td></tr>";
    
}
echo "</tbody></table>";

} else {
echo "0 results";
}

$conn->close();


$conn1 = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");
    if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
} 
$sql1 = "SELECT SUM(price) AS s FROM data";
$result1 = $conn1->query($sql1);
$tot = 0;
if ($result1->num_rows > 0) {
     while($row1 = $result1->fetch_assoc()) {
     $tot = $row1["s"];
    }
    echo "THE TOTAL IS: " . $tot;
}else{
    echo "THE TOTAL IS UNKNOWN" ;
}
$conn1->close();

?>
 
<br/>
<button onclick="myFunction()" class="btn btn-info">Refresh</button>

<script>
function myFunction() {
    location.reload();
}
</script>

</body>
</html>
