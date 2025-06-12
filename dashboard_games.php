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
    // Mostrar lista de juegos del creador
    echo <<<EOD
    <h2>Tus Juegos</h2>
    <p><a href="dashboard_games.php?add_game=true">Nuevo Juego</a></p>
EOD;

    $query = "SELECT g.* FROM games g 
              JOIN creators_games cg ON g.id_game = cg.id_game 
              WHERE cg.id_creator = ".$_SESSION["id_creator"];
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result)) {
        echo '<ul>';
        while($game = mysqli_fetch_array($result)) {
            echo '<li><a href="dashboard_games.php?id_game='.$game['id_game'].'">'.htmlspecialchars($game['title']).'</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No hay juegos.</p>';
    }

    // --- NUEVA SECCIÓN DE COMENTARIOS ---
    echo '<h2>Comentarios en tus juegos</h2>';
    
    $comments_query = "SELECT c.*, g.title AS game_title, cr.name AS commenter_name
                      FROM comments c
                      JOIN games g ON c.id_game = g.id_game
                      JOIN creators cr ON c.id_creator = cr.id_creator
                      JOIN creators_games cg ON g.id_game = cg.id_game
                      WHERE cg.id_creator = ".$_SESSION["id_creator"]."
                      ORDER BY c.id_comment DESC";
    
    $comments_result = mysqli_query($conn, $comments_query);
    
    if(mysqli_num_rows($comments_result) > 0) {
        echo '<div class="comments-container">';
        while($comment = mysqli_fetch_array($comments_result)) {
            echo '<div class="comment">';
            echo '<h3>'.htmlspecialchars($comment['game_title']).'</h3>';
            echo '<p><strong>De:</strong> '.htmlspecialchars($comment['commenter_name']).'</p>';
            echo '<p>'.htmlspecialchars($comment['comment']).'</p>';
            echo '</div>';
            echo '<hr>';
        }
        echo '</div>';
    } else {
        echo '<p>No hay comentarios en tus juegos.</p>';
    }
    // --- FIN SECCIÓN COMENTARIOS ---
}

closeDashboard();
closeBody();
?>
