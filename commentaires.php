<?php 
require('connexionBDD.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php include("menu.php") ?>
    <h1>Blog</h1>
    <p class="lastBill">Les Commentaires de : <?php echo $_GET['titre']; ?></p>

<?php 

$req = $bdd->prepare("SELECT auteur, commentaire, date_commentaire, DATE_FORMAT(date_commentaire, '%e %b %Y à %H:%i') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire");
$req->execute(array($_GET['billet']));

while($donnees = $req->fetch())
{
?>
<div class="textDesc">
    <h3>
        <?php echo htmlspecialchars($donnees['auteur']); ?>
        <span class="date-parution"><em>Le <?php echo $donnees['date_commentaire_fr']; ?></em></span>
    </h3>
    <p class="contenu-text">
        <?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?>
    </p>
</div>
<?php
}
$req->closeCursor();
?>
<div class="textDesc">
    <h3>Ajouter un commentaire</h3>
    <form method="post" action="commentaire_post.php">
        <label>Nom ou Pseudo</label></br>
        <input type="text" name="auteur"></br>
        <input class="nonvisible" type="text" name="id_billet" value="<?php echo $_GET['billet'] ?>" readonly></br>
        
        <label>Commentaire</label></br>
        <textarea name="commentaire" id="" cols="45" rows="5"></textarea>
        
        <input class="nonvisible" type="text" name="titre" value="<?php echo $_GET['titre'] ?>" readonly></br>
        <button type="submit">Envoyer</button>
    </form>
</div>
</body>
</html>