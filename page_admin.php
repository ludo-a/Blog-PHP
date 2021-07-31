<?php
session_start();
//Si Session ok = redirection
if(isset($_SESSION['connect'])){
require('./src/connexionBDD.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Administration Blog</title>
</head>
<body>
    <ul>
        <li>
            <a class="decobouton" href="./src/deconnexion.php">DECONNEXION</a>
        </li>
    </ul>
    <hr class="hr-class">
<h1>Administration</h1>

<?php
	if(isset($_GET['billet_send'])){
        $msg = "Votre billet a été ajouté avec Succès !";
		echo"<script type='text/javascript'>alert('$msg');</script>";
	}
?>

<!-- Formulaire d'ajout de commentaire -->
<div class="textDesc">
    <h3>Ajouter un billet</h3>
    <form method="post" action="./src/billet_post.php">
        <textarea name="titre" cols="45" rows="2" placeholder="Titre"></textarea></br>
        <textarea name="contenu" id="" cols="45" rows="18" placeholder="Contenu..."></textarea> 
        <button type="submit">Ajouter</button>
    </form>
</div>
   <?php } ?>
</body>
</html>