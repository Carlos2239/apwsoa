<?php
$servername = "localhost";
$username = "admin";
$password = "admin123";
$dbname = "flight_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST['user_id'];

// EL TRUCO: Usamos JOIN para mezclar la tabla de Reservas con la de Vuelos
// Así obtenemos el origen y destino en lugar de solo el flight_id
$sql = "SELECT R.reservation_id, R.reservation_date, F.origin, F.destination, F.departure_date, F.price 
        FROM Reservations R
        JOIN Flights F ON R.flight_id = F.flight_id
        WHERE R.user_id = '$user_id'
        ORDER BY R.reservation_date DESC";

$result = $conn->query($sql);

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

echo json_encode($reservations);
$conn->close();
?>
