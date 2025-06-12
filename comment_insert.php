<?php
session_start();

if(!isset($_SESSION['id_creator'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_POST['id_game']) || !isset($_POST['comment'])) {
    header("Location: index.php");
    exit();
}

$id_game = (int)$_POST['id_game'];
$comment = trim($_POST['comment']);
$id_creator = (int)$_SESSION['id_creator'];

if(empty($comment)) {
    header("Location: game.php?id_game=$id_game");
    exit();
}

require_once("db_config.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

$comment = mysqli_real_escape_string($conn, $comment);

$query = "INSERT INTO comments (comment, id_creator, id_game) 
          VALUES ('$comment', $id_creator, $id_game)";

if(mysqli_query($conn, $query)) {
    header("Location: game.php?id_game=$id_game");
} else {
    die("Error al insertar el comentario");
}

exit();
?>