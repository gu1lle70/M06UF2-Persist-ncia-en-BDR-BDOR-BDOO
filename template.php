<?php

function printHead ($title )
{
	echo <<<EOD

<!doctype html>
<html>
<head>
	<title>{$title}</title>
</head>
EOD;
}

function openBody($title="ENTIch"){
	echo <<<EOD

<body>

<header>
<h1>{$title}</h1>
<nav>
	<ul>
	<li><a href="index.php">Home</a></li>
	<li>Juegos</li>
	<li>Creadores</li>
	<li>Tags</li>
	<li><a href="dashboard.php">Dashboard</a></li>
	<li><a href="logout.php">Logout</a></li>
	
	
	</ul>

</nav>
</header>

<main>
EOD;
}
function closeBody ()
{

	echo <<<EOD


</main>

<footer>

</footer>

</body>
</html>
EOD;
}
?>
