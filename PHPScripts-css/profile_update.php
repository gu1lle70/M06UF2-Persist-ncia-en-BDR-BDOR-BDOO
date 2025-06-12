<?php

session_start();

if(!isset($_SESSION["id_creator"])){
    exit();
}

if (!isset($_POST["profile_name"]) ||
    !isset($_POST["profile_username"]) ||
    !isset($_POST["profile_email"]) ||
    !isset($_POST["profile_description"])) {

    die("ERROR 1: Formulario no enviado");
}

$name = trim($_POST["profile_name"]);

if (strlen($name) <= 2) {
    die("ERROR 2: Nombre demasiado corto");
}

$username = trim($_POST["profile_username"]);

if (strlen($username) <= 4) {
    die("ERROR 3: Nombre de usuario demasiado corto");
}

$email = trim($_POST["profile_email"]);

if (strlen($email) <= 4) {
    die("ERROR 4: Email demasiado corto");
}
$description = trim($_POST["profile_description"]);

$tmp = addslashes($name);

if ($tmp != $name) {
    die("ERROR 5: Caracter no valido en NAME");
}

$tmp = addslashes($username);

if ($tmp != $username) {
    die("ERROR 6: Caracter no valido en USERNAME");
}

$tmp = addslashes($email);

if ($tmp != $email) {
    die("ERROR 7: Caracter no valido en EMAIL");
}
// Validación de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("ERROR 8: Email mal formado");
}
$tmp = addslashes($description);

if ($tmp != $description) {
    die("ERROR 9: Caracter no valido en DESCRIPTON");
}

require_once("db_config.php");

// Conexión a la base de datos
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("ERROR 10: No se pudo conectar a la base de datos");
}

// Verificar si el username o email ya existen en la base de datos
$check_query = <<<EOD
SELECT id_creator 
FROM creators 
WHERE (username = '{$username}' OR email = '{$email}')
AND id_creator != {$_SESSION['id_creator']}
EOD;

$check_result = mysqli_query($conn, $check_query);
if (!$check_result) {
    die("ERROR 11: Error al verificar username/email en la base de datos");
}

if (mysqli_num_rows($check_result) > 0) {
    die("ERROR 12: El username o el email ya están en uso");
}

$update_query = <<<EOD
UPDATE creators
SET 
    name='{$name}', 
    username='{$username}',
    email='{$email}', 
    description='{$description}'
WHERE id_creator={$_SESSION['id_creator']}
EOD;

$result = mysqli_query($conn, $update_query);

if(!$result){
    die("ERROR 13: No se ha hecho el update en la base de datos");
}

header("Location: dashboard.php");
exit();

?>
