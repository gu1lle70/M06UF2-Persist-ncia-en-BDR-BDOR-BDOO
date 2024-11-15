<?php

if (!isset($_POST["register_name"]) ||
    !isset($_POST["register_username"]) ||
    !isset($_POST["register_email"]) ||
    !isset($_POST["register_password"]) ||
    !isset($_POST["register_repassword"])) {
    die("ERROR 1: Formulario no enviado");
}

$name = trim($_POST["register_name"]);

if (strlen($name) <= 2) {
    die("ERROR 2: Nombre demasiado corto");
}

$username = trim($_POST["register_username"]);

if (strlen($username) <= 4) {
    die("ERROR 3: Nombre de usuario demasiado corto");
}

$email = trim($_POST["register_email"]);

if (strlen($email) <= 4) {
    die("ERROR 4: Email demasiado corto");
}

$pass = trim($_POST["register_password"]);

if (strlen($pass) < 6) {
    die("ERROR 5: Password muy corto");
}

$tmp = addslashes($name);

if ($tmp != $name) {
    die("ERROR 6: Caracter no valido en NAME");
}

$tmp = addslashes($username);

if ($tmp != $username) {
    die("ERROR 7: Caracter no valido en USERNAME");
}

$tmp = addslashes($pass);

if ($tmp != $pass) {
    die("ERROR 8: Caracter no valido en CONTRASEÑA");
}

$tmp = addslashes($email);

if ($tmp != $email) {
    die("ERROR 9: Caracter no valido en EMAIL");
}

// Validación de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("ERROR 10: Email mal formado");
}

$pass = addslashes($pass);

if ($pass != $_POST["register_repassword"]) {
    die("ERROR 11: Password con caracteres no validos");
}

$repass = $_POST["register_repassword"];

if ($pass != $repass) {
    die("ERROR 12: El pass y repass no cuadran");
}

// Encriptación de la contraseña
$pass = md5($pass);

$query = <<<EOD
INSERT INTO creators (name, username, password, email)
VALUES ('{$name}', '{$username}', '{$pass}', '{$email}');
EOD;

require_once("db_config.php");

// Conexión a la base de datos y ejecución de la consulta
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);


$result = mysqli_query($conn, $query);

if(!$result){
	die("ERROR 13: No se ha insertado en la base de datos");
}

$id_creator = mysqli_insert_id($conn);


session_start();

$_SESSION["id_creator"] = $id_creator;

header("Location: dashboard.php");

exit();

?>
