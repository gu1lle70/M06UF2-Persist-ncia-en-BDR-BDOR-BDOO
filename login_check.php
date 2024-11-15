<?php

if (!isset($_POST["login_username"]) ||
    !isset($_POST["login_password"])){

	die("ERROR 1: Formulario no enviado");    
}

$username = trim($_POST["login_username"]);

if (strlen($username) <= 2){
	die("ERROR 2: Nombre del usuario mal formado");
}

$tmp = addslashes($username);
if ($username != $tmp){
	die("ERROR 3: Nombre de usuario mal formado");
}

$pass = addslashes($_POST["login_password"]);
if ($pass != $_POST["login_password"]){
	die("ERROR 4: Password con caracteres no validos");
}

$pass = md5($pass);

$query = "SELECT * FROM creators WHERE username='$username' AND password='$pass'";

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if (!$result){
	die("ERROR 5: USUARIO y/o password incorrectos");
}

if (mysqli_num_rows($result) != 1){
	die("ERROR 6: Usuario y/o password incorrecto");
}

$creator = mysqli_fetch_array($result);

session_start();

$_SESSION["id_creator"] = $creator["id_creator"];

header("Location: dashboard.php");

exit();

?>
