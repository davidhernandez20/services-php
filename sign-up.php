<?php
// Verificar que la solicitud sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configuración CORS
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    // Datos de conexión a la base de datos
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "usuarios";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        http_response_code(500); // Error interno del servidor
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener datos del formulario y realizar validación y escape
    $username = mysqli_real_escape_string($conn, $_POST['txt']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pswd']);

    // Cifrar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar y ejecutar la consulta SQL para insertar datos
    $sql = "INSERT INTO users (nombre_usuario, correo, contraseña) VALUES ('$username', '$email', '$passwordHash')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        http_response_code(500); // Error interno del servidor
        echo "Error al registrar. Por favor, inténtalo de nuevo más tarde.";
        // Puedes registrar el error en un archivo de registro
        error_log("Error al registrar en la base de datos: " . $conn->error);
    }

    // Cerrar la conexión
    $conn->close();
} else {
    http_response_code(405); // Método no permitido
    echo "Método no permitido";
}
?>
