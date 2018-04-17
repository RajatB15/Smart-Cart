<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn2 = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
} 
$sql1 = "SELECT * FROM data WHERE data.username= '" . $_POST['username'] . "' AND id= " . $_POST['id'] . "";
$result = $conn2->query($sql1);
if ($result->num_rows > 0) {
    $conn = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $price = ((int)$_POST['price'] + (int)getprice());
    $qty = getqty();
    
    $sql = "INSERT INTO data(username, id, qty, price, name) VALUES ('" . $_POST['username'] . "'," . $_POST['id'] . "," . $qty . "," . $price . ",'" . $_POST['name'] . "')" ;
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}else{
    $conn = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "INSERT INTO data(username, id, qty, price, name) VALUES ('" . $_POST['username'] . "'," . $_POST['id'] . ",1" . "," . $_POST['price'] . ",'" . $_POST['name'] . "')";
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
$conn2->close();
function getqty()
{
    $conn3 = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");
    if ($conn3->connect_error) {
        die("Connection failed: " . $conn3->connect_error);
    } 
    $sql3 = "SELECT qty FROM data WHERE username= '" . $_POST['username'] . "' AND id= '" . $_POST['id'] . "'";
    $result3 = $conn3->query($sql3);
    $qty = 0;
    if ($result3->num_rows > 0) {
        while($row3 = $result3->fetch_assoc()) {
            $qty = $row3["qty"];
            $sql3 = "DELETE FROM data WHERE username= '" . $_POST['username'] . "' AND id= '" . $_POST['id'] . "'";
            $conn3->query($sql3);
        }
    }
    return $qty + 1;
}
function getprice()
{
    $conn3 = new mysqli("localhost", "rajahgty_rajatmb", "rajatb@gmail.com", "rajahgty_cart");
    if ($conn3->connect_error) {
        die("Connection failed: " . $conn3->connect_error);
    } 
    $sql3 = "SELECT price FROM data WHERE username= '" . $_POST['username'] . "' AND id= '" . $_POST['id'] . "'";
    $result3 = $conn3->query($sql3);
    $price = 0;
    if ($result3->num_rows > 0) {
        while($row3 = $result3->fetch_assoc()) {
            $price = $row3["price"];
        }
    }
    return $price;
}
?>
