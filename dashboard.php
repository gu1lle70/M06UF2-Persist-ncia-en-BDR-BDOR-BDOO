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

require_once("dashboard_template.php");

openDashboard();
echo <<<EOD
<form method="POST" action="profile_update.php">

<p><label for="profile_name">Nombre:</label>
<input type="text" value="{$creator["name"]}" name="profile_name" id="profile_name" /></p>

<p><label for="profile_username">Username:</label>
<input type="text" value="{$creator["username"]}" name="profile_username" id="profile_username" /></p>

<p><label for="profile_email">E-mail:</label>
<input type="text" value="{$creator["email"]}" name="profile_email" id="profile_email" /></p>

<p><label for="profile_description">Description:</label>
<textarea name="profile_description" id="profile_description">
{$creator["description"]}
</textarea></p>

<p><input type="submit" value="Actualizar" /> </p>


EOD;
closeDashboard();
closeBody();

?>
