<?php
$servername = "localhost";
$username = "admin";     
$password = "admin123";   
$dbname = "flight_reservation";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Reservar vuelo
$user_id = $_POST['user_id'];
$flight_id = $_POST['flight_id'];
$sql = "INSERT INTO Reservations (user_id, flight_id) VALUES ('$user_id', '$flight_id')";
if ($conn->query($sql) === TRUE) {
    echo "Reservation successful";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

