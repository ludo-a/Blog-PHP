<?php require('./src/connexionBDD.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/style.css">
    <title>Blog</title>
</head>
<body>

<?php include("menu.php") ?>

<h1>Blog</h1>
<?php
if((isset($_GET['page'])) && (intval($_GET['page']) ===1)){
echo "<p class='lastBill'>Derniers billets</p>";
}
?>
    
<?php 
//PAGINATION 
//Connaitre la page en cours
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = intval($_GET['page']);
}else{
    $currentPage = 1;
    header('location:index.php?page=1');
}

//Connaitre le nombre de billet
$reqOne = $bdd->query('SELECT COUNT(*) AS nb_billets FROM billets');
$reqOne->execute();
$result = $reqOne->fetch();
$nbBillets = intval($result['nb_billets']);

//Nombre de billets par page
$nbParPage = 2;

//Calcul du nombre de page total
$totalPages = intval(ceil($nbBillets/$nbParPage));

//valeurs pour appel sql
$debut = $nbParPage * ($currentPage-1);
$fin = $nbParPage; // indication du nombre de billets par page pour la requete MySQL

$req = $bdd->prepare("SELECT id, titre, contenu, date_creation, DATE_FORMAT(date_creation, '%e %b %Y à %H:%i') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT :debut, :fin;");

$req->bindvalue(':debut', $debut, PDO::PARAM_INT);
$req->bindvalue(':fin', $fin, PDO::PARAM_INT);

$req->execute();
while($donnees = $req->fetch()){ ?>

<div class="textDesc">
    <h3>
        <?php echo htmlspecialchars($donnees['titre']); ?><br/>
        <span class="date-parution"><em>Le <?php echo $donnees['date_creation_fr']; ?></em></span>
    </h3>
    <p class="contenu-text">
        <?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
        </br>
        <em><a href="commentaires.php?billet=<?php echo $donnees['id']; ?>&titre=<?php echo $donnees['titre']; ?>">Commentaires</a></em>
    </p>
</div>

<?php 
}
$req->closeCursor(); 
?>
<!-- PAGINATION AFFICHAGE HTML -->
<div id="changePage">
    <ul>

<?php
if((isset($_GET['page'])) && (intval($_GET['page']) ===1)){
    echo "<li>Page Précédente</li>";
    echo "<li><a href='index.php?page=2'>Page Suivante</a></li>";
}else if((isset($_GET['page'])) && (intval($_GET['page']) == $totalPages)){
    ?>
    <li><a href="index.php?page=<?php echo ($currentPage-1)?>">Page Précédente</a></li>
    <li>Page Suivante</li>
    <?php
}else{
?>
    <li><a href="index.php?page=<?php echo ($currentPage-1)?>">Page Précédente</a></li>
    <li><a href="index.php?page=<?php echo ($currentPage+1)?>">Page Suivante</a></li>
<?php  
}
?>
    </ul>
</div>
</body>
</html>