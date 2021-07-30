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
    <title>Blog</title>
</head>
<body>

<?php include("menu.php") ?>

<h1>Blog</h1>
    
<?php 
//Verification en cas de modification de l'url
$req = $bdd->prepare("SELECT id_billet FROM commentaires WHERE id_billet = ?");
$req->execute(array($_GET['billet']));
$condition = $req->fetch();
if($condition == false){
//var_dump($condition); //Affichage valeur de retour DEBUG MODE
?>
<div class="textDesc">
    <h3>
        OUPS !!!
    </h3>
    <p class="contenu-text">
        Il semblerait que le contenu n'existe pas.</br>
        Vous êtes prié(e) de ne pas modifier l'URL, Merci.
    </p>
</div>

<?php
}
else{ // sinon affichage de la BDD
    $req2 = $bdd->prepare("SELECT auteur, commentaire, date_commentaire, DATE_FORMAT(date_commentaire, '%e %b %Y à %H:%i') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire");
    $req2->execute(array($_GET['billet']));
?>

<p class="lastBill">Les Commentaires de : <?php //echo $_GET['titre']; ?></p>

<?php while($donnees = $req2->fetch())
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

<?php }
$req2->closeCursor(); 
?>

<!-- Formulaire d'ajout de commentaire -->
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

<?php } ?>

</body>
</html>