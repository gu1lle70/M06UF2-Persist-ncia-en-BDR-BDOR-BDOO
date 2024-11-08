<?php
session_start();
if(!isset($_SESSION["id_creator"])){
	header("Location: login.php");
	exit();
}

require_once("template.php");

$query = "SELECT * FROM creators WHERE id_creator=".$_SESSION["id_creator"];

require_once("db_config.php");

// Conexión a la base de datos y ejecución de la consulta
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$result = mysqli_query($conn, $query);

if(!$result){
	header("Location: login.php");
	exit();
}

if(mysqli_num_rows($result) != 1){
	header("Location: login.php");
	exit();
}

$creator = mysqli_fetch_array($result);

printHead("Dashboard de ".$creator["name"]);

openBody("Dashboard de ".$creator["name"]);

echo <<<EOD

<p><strong>Nombre:</strong> {$creator["name"]}</p>
<p><strong>Username:</strong> {$creator["username"]}</p>
<p><strong>e-mail:</strong> {$creator["email"]}</p>
<p><strong>Password:</strong> {$creator["password"]}</p>
<p><strong>Descripción:</strong> {$creator["description"]}</p>

EOD;

closeBody();

?>
