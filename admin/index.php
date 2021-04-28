<?php
include '../inc/connexion.php';
if (empty($_SESSION['user'])) {
	header('Location: ./login.php');
}

include('inc/header.php');
?>

		<div id="content">
			<h1>Bienvenue !</h1>
		</div>

<?php
include('inc/footer.php');
?>