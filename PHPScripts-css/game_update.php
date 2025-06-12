<?php
session_start();

if(!isset($_SESSION["id_creator"])){
    exit();
}

if (!isset($_POST["game_title"]) || !isset($_POST["game_price"]) || !isset($_POST["game_id"])) {
    die("ERROR 1: Formulario no enviado");
}

$title = trim($_POST["game_title"]);
$price = trim($_POST["game_price"]);
$trailer = trim($_POST["game_trailer"]);
$link = trim($_POST["game_link"]);
$id = (int)$_POST["game_id"];
$creator_id = (int)$_SESSION["id_creator"];

if (strlen($title) <= 2) {
    die("ERROR 2:Game Title demasiado corto");
}

if (strlen($link) >= 128) {
    die("ERROR 3: Demasiado largo");
}

if (!filter_var($link, FILTER_VALIDATE_URL)) {
    die("ERROR 10: Link mal formado");
}

if (!filter_var($trailer, FILTER_VALIDATE_URL)) {
    die("ERROR 11: TrailerLink mal formado");
}

require_once("db_config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$query = "UPDATE games g
          JOIN creators_games cg ON g.id_game = cg.id_game
          SET g.title = '".mysqli_real_escape_string($conn, $title)."',
              g.link = '".mysqli_real_escape_string($conn, $link)."',
              g.price = '".mysqli_real_escape_string($conn, $price)."',
              g.trailer = '".mysqli_real_escape_string($conn, $trailer)."'
          WHERE cg.id_creator = $creator_id AND g.id_game = $id";

$result = mysqli_query($conn, $query);

if(!$result){
    die("ERROR 13: No se ha hecho el update en la base de datos: ".mysqli_error($conn));
}

header("Location: dashboard_games.php?id_game=".$id);
exit();
?>



