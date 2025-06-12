<?php

session_start();

if(!isset($_SESSION["id_creator"])){
    exit();
}

if (!isset($_POST["game_title"]) ||
    !isset($_POST["game_price"])) {

    die("ERROR 1: Formulario no enviado");
}

$title = trim($_POST["game_title"]);
$price = trim($_POST["game_price"]);
$trailer = trim($_POST["game_trailer"]);


if (strlen($title) <= 2) {
    die("ERROR 2:Game Title demasiado corto");
}

$link = trim($_POST["game_link"]);

if (strlen($link) >= 128) {
    die("ERROR 3: Demasiado largo");
}

$tmp = addslashes($title);

if ($tmp != $title) {
    die("ERROR 4: Caracter no valido en TITLE");
}

$tmp = addslashes($link);

if ($tmp != $link) {
    die("ERROR 5: Caracter no valido en LINK");
}

$tmp = addslashes($price);

if ($tmp != $price) {
    die("ERROR 7: Caracter no valido en PRICE");
}
$tmp = addslashes($link);

if ($tmp != $link) {
    die("ERROR 8: Caracter no valido en LINK");
}
$tmp = addslashes($trailer);

if ($tmp != $trailer) {
    die("ERROR 9: Caracter no valido en TRAILER");
}
// Validación de link
if (!filter_var($link, FILTER_VALIDATE_URL)) {
    die("ERROR 10: Link mal formado");
}
// Validación de link
if (!filter_var($trailer, FILTER_VALIDATE_URL)) {
    die("ERROR 11: TrailerLink mal formado");
}

$query = <<<EOD
INSERT INTO games (title, link, price, trailer)
VALUES ('{$title}', '{$link}', '{$price}', '{$trailer}');
EOD;

require_once("db_config.php");

// Conexión a la base de datos y ejecución de la consulta
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);


$result = mysqli_query($conn, $query);

if(!$result){
	die("ERROR 13: No se ha insertado en la base de datos");
}
$id_game = mysqli_insert_id($conn);

$creator_id = $_SESSION["id_creator"];
$relation_query = "INSERT INTO creators_games (id_creator, id_game) VALUES ('{$creator_id}', '{$id_game}')";
$relation_result = mysqli_query($conn, $relation_query);

if(!$relation_result){
    die("ERROR 14: No se pudo relacionar el juego con el creador");
}

header("Location: dashboard_games.php?id_game=".$id_game);

exit();

?>
