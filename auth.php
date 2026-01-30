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

// --- CASO 1: REGISTRO ---
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $user = $_POST['username'];
    // Encriptamos la contraseña
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    
    $sql = "INSERT INTO Users (username, password, email) VALUES ('$user', '$pass', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        // ÉXITO: Alerta y mandar al Login
        echo "<script>
                alert('¡Registro exitoso! Ahora inicia sesión.');
                window.location.href='login.html';
              </script>";
    } else {
        // ERROR: Alerta y regresar al Registro
        echo "<script>
                alert('Error al registrar: " . $conn->error . "');
                window.history.back();
              </script>";
    }
}

// --- CASO 2: LOGIN ---
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    $sql = "SELECT * FROM Users WHERE username='$user'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            // ÉXITO: Guardar ID en una variable de sesión (opcional pero útil) y redirigir
            // Aquí mandamos al usuario a Reservaciones
            echo "<script>
                    alert('¡Bienvenido " . $row['username'] . "!');
                    // Guardamos el ID en localStorage por si lo necesitas en el frontend
                    localStorage.setItem('user_id', '" . $row['user_id'] . "');
                    window.location.href='reservations.html';
                  </script>";
        } else {
            // ERROR PASSWORD
            echo "<script>
                    alert('Contraseña incorrecta.');
                    window.location.href='login.html';
                  </script>";
        }
    } else {
        // ERROR USUARIO NO EXISTE
        echo "<script>
                alert('El usuario no existe.');
                window.location.href='login.html';
              </script>";
    }
}

$conn->close();
?>
