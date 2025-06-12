<?php
session_start();
require_once("template.php");
require_once("db_config.php");

if(!isset($_GET['id_game'])) {
    header("Location: index.php");
    exit();
}

$id_game = (int)$_GET['id_game'];
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
$query = "SELECT * FROM games WHERE id_game = $id_game";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) != 1) {
    header("Location: index.php");
    exit();
}

$game = mysqli_fetch_assoc($result);

printHead("ENTIch: ".$game['title']);
openBody();

echo '<h2>'.htmlspecialchars($game['title']).'</h2>';

    echo '<figure style="margin: 20px 0; text-align: left;">';
    echo '<img src="imgs/lol.png" 
         alt="'.htmlspecialchars($game['title']).'"
         style="max-width: 50%; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
    echo '</figure>';

echo '<p>'.htmlspecialchars($game['price']).' euros</p>';
echo '<br>';
echo '<a href="'.htmlspecialchars($game['link']).'" target="_blank">Jugar ahora</a>';
echo '<br><br>';

if(!empty($game['trailer'])) {
    echo '<a href="'.htmlspecialchars($game['trailer']).'" target="_blank">Ver trailer</a>';
}

// SECCIÓN DE COMENTARIOS
echo '<h3 style="margin-top:40px;">Comentarios</h3>';

// Mostrar comentarios existentes
$comments_query = "SELECT c.*, cr.name AS creator_name 
                  FROM comments c
                  JOIN creators cr ON c.id_creator = cr.id_creator
                  WHERE c.id_game = $id_game";
$comments_result = mysqli_query($conn, $comments_query);

if(mysqli_num_rows($comments_result) > 0) {
    while($comment = mysqli_fetch_assoc($comments_result)) {
        echo '<div style="border:1px solid #ddd; padding:10px; margin:10px 0;">';
        echo '<strong>'.htmlspecialchars($comment['creator_name']).'</strong>';
        echo '<p>'.htmlspecialchars($comment['comment']).'</p>';
        echo '</div>';
    }
} else {
    echo '<p>No hay comentarios todavia.</p>';
}

// Formulario para nuevos comentarios
if(isset($_SESSION['id_creator'])) {
    echo '<form method="POST" action="comment_insert.php" style="margin-top:30px;">';
    echo '<h4>Add comentario</h4>';
    echo '<input type="hidden" name="id_game" value="'.$id_game.'">';
    echo '<textarea name="comment" rows="4" style="width:100%;" required></textarea><br>';
    echo '<input type="submit" value="Enviar comentario">';
    echo '</form>';
}

closeBody();
?>