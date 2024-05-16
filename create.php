<?php
header("Access-Control-Allow-Origin: https://esquema.github.io");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Verificar si se está recibiendo una solicitud POST
if ($_SERVER["REQUEST_METHOD"] ?? '' == "POST") {
    // Obtener datos JSON del cuerpo de la solicitud
    $data = json_decode(file_get_contents("php://input"));

    // Verificar si se recibieron los campos necesarios
    if (isset($data->nombre, $data->email, $data->mensaje)) {
        // Obtener los datos del objeto JSON
        $nombre = $data->nombre;
        $email = $data->email;
        $mensaje = $data->mensaje;

        // Crear una conexión a la base de datos
        $servername = "localhost";
        $username = "useresquema"; // Cambia al nombre de usuario creado
        $password = "xuniko"; // Cambia a la contraseña del usuario
        $dbname = "dbdistribuido";

        $conn = new mysqli($servername, $username, $password, $dbname);
        error_log("Error en la conexión a la base de datos: " . $conn->connect_error);


        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Preparar y ejecutar la consulta SQL para insertar datos
        $sql = "INSERT INTO tb_contacto (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')";

        if ($conn->query($sql) === TRUE) {
            // Si la inserción fue exitosa
            echo json_encode(array("success" => true));
        } else {
            // Si ocurrió un error durante la inserción
            echo json_encode(array("success" => false, "message" => "Error al ejecutar la consulta: " . $conn->error));
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        // Si faltan datos en la solicitud
        echo json_encode(array("success" => false, "message" => "Datos incompletos."));
    }
} else {
    // Si no se recibió una solicitud POST válida
    echo json_encode(array("success" => false, "message" => "Método incorrecto."));
}
?>
