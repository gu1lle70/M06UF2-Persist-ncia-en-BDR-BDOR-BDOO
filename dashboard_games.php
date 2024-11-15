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

if (isset($_GET["add_game"])) {
    echo <<<EOD
<form method="POST" action="dashboard_game_add.php">
<h2>Nuevo juego</H2>
    <p><label for="game_title">Title:</label>
    <input type="text" id="game_title" name="game_title" /></p>
    <p><label for="game_price">Price:</label>
    <input type="text" id="game_price" name="game_price" /></p>
    <p><label for="game_link">Link:</label>
    <input type="text" id="game_link" name="game_link" /></p>
    <p><label for="game_trailer">Trailer:</label>
    <input type="text" id="game_trailer" name="game_trailer" /></p>
    
    <p><input type="submit" name="game_submit" id="game_submit" /></p>
    
</form>
EOD;
//Formulario de añadir juego

} else if (isset($_GET["id_game"])) {
    echo "<h2>Modificar juegos</h2>";
    //Formulario modificar juego
    $query = "SELECT * FROM games WHERE id_game=".$_GET["id_game"];
    require_once("db_config.php");

    // Conexión a la base de datos y ejecución de la consulta
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    $result = mysqli_query($conn, $query);

    $game = mysqli_fetch_array($result);
    echo <<<EOD
<form method="POST" action="game_update.php">

<input type="hidden" value="{$_GET["id_game"]}" name="game_id" id="game_id" />
<p><label for="game_title">Title:</label>
<input type="text" value="{$game["title"]}" name="game_title" id="game_title" /></p>
<p><label for="game_price">Price:</label>
<input type="text" value="{$game["price"]}" name="game_price" id="game_price" /></p>
<p><label for="game_link">Lik:</label>
<input type="text" value="{$game["link"]}" name="game_link" id="game_link" /></p>
<p><label for="game_trailer">Trailer:</label>
<input type="text" value="{$game["trailer"]}" name="game_trailer" id="game_trailer" /></p>

<p><input type="submit" value="Actualizar" /> </p>
</form>
EOD;

} else {
    echo <<<EOD
<p><a href="dashboard_games.php?add_game=true">Add Game</a></p>
//Listado de juegos con el enlace en el título tipo dashboard_game.php?id_game="ID_JUEGO"
EOD;
}

closeDashboard();
closeBody();
?>
