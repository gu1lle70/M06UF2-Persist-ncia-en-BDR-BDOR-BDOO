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
$id =($_POST["game_id"]);

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
require_once("db_config.php");

// Conexión a la base de datos
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$query = <<<EOD
UPDATE games
SET 
    title='{$title}', 
    link='{$link}',
    price='{$price}', 
    trailer='{$trailer}'
WHERE id_creator={$_SESSION['id_creator']} AND id_game='{$id}'
EOD;

$result = mysqli_query($conn, $query);

if(!$result){
    die("ERROR 13: No se ha hecho el update en la base de datos");
}

header("Location: dashboard_games.php?id_game".$id);
exit();

?>




