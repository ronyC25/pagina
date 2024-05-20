<?php

//-----------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registrospagina";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Manejar las solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar los datos JSON recibidos del cliente
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar si se proporcionó un ID para determinar si es una inserción o una actualización
    if (isset($data['id'])) {
        // Actualizar usuario
        $id = $data['id'];
        $name = $data['name'];
        $apell = $data['apell'];
        $email = $data['email'];
        $numero = $data['numero'];
        $fecha = $data['fecha'];

        $sql = "UPDATE users SET nombre='$name', apell='$apell', email='$email', numero='$numero', fecha='$fecha' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        // Insertar nuevo usuario
        $name = $data['name'];
        $apell = $data['apell'];
        $email = $data['email'];
        $numero = $data['numero'];
        $fecha = $data['fecha'];

        $sql = "INSERT INTO users (nombre, apell, email, numero, fecha) VALUES ('$name', '$apell', '$email', '$numero', '$fecha')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Manejar solicitud de eliminación
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    // Manejar solicitud GET para obtener todos los usuarios
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = array("id" => $row["id"], "name" => $row["nombre"], "apell" => $row["apell"], "email" => $row["email"], "numero" => $row["numero"], "fecha" => $row["fecha"]);
        }
    }
    echo json_encode($users);
}

// Cerrar la conexión
$conn->close();
?>
