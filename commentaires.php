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
    <h1>Blog</h1>
    <p class="lastBill">Derniers billets</p>


<?php 
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blogPHP;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
$req = $bdd->query("SELECT id, titre, contenu, date_creation, DATE_FORMAT(date_creation, '%e %b %Y à %H:%i') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5");
while($donnees = $req->fetch())
{
?>
<div class="news">
    <h3>
        <?php echo htmlspecialchars($donnees['titre']); ?><br/>
        <span class="date-parution"><em>Le <?php echo $donnees['date_creation_fr']; ?></em></span>
    </h3>
    <p class="contenu-billet">
        <?php echo nl2br(htmlspecialchars($donnees['contenu'])); ?>
        </br>
        <em><a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a></em>
    </p>
</div>
<?php
}
$req->closeCursor();
?>
</body>
</html>