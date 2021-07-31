<?php
require('connexionBDD.php');

if(isset($_POST["titre"]) && isset($_POST["contenu"]))
{
    $titre = htmlspecialchars($_POST["titre"]);
    $contenu = htmlspecialchars($_POST["contenu"]);

    $data = array(
        ':titre' =>$titre,
        ':contenu' =>$contenu
    );
    
    $req = $bdd->prepare('INSERT INTO billets(titre, contenu, date_creation) VALUES (:titre, :contenu, NOW())');
    $req->execute($data);

    header('Location: ../page_admin.php?success=1&billet_send=1');
}

?>