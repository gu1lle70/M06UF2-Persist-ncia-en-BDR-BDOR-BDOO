<?php
session_start();
require_once("template.php");
require_once("db_config.php");

printHead("ENTIch: Home");
openBody();

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
$query = "SELECT * FROM games";
$result = mysqli_query($conn, $query);

echo '<h1>Listado de Juegos</h1>';

if(mysqli_num_rows($result) > 0) {
    while($game = mysqli_fetch_assoc($result)) {
        echo '<h2>'.htmlspecialchars($game['title']).'</h2>';
        echo '<p>'.htmlspecialchars($game['price']).' euros</p>';
        echo '<a href="game.php?id_game='.(int)$game['id_game'].'">Ver detalles</a>';
        echo '<br><br>';
    }
} else {
    echo '<p>No hay juegos disponibles</p>';
}
closeBody();
?>