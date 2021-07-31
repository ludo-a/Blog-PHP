<?php
require('connexionBDD.php');

if(isset($_POST["auteur"]) && isset($_POST["commentaire"]) && isset($_POST["id_billet"]) && isset($_POST["titre"]))
{
    $auteur = htmlspecialchars($_POST["auteur"]);
    $commentaire = htmlspecialchars($_POST["commentaire"]);
    $id_billet = htmlspecialchars($_POST["id_billet"]);
    $data = array(
        ':auteur' =>$auteur,
        ':comm' =>$commentaire,
        ':id_billet' =>$id_billet
    );
    $titre = $_POST['titre'];

    $req = $bdd->prepare('INSERT INTO commentaires(id_billet, auteur, commentaire, date_commentaire) VALUES (:id_billet, :auteur, :comm, NOW())');
    $req->execute($data);

    header('Location: ../commentaires.php?billet='.$id_billet.'&titre='.$titre);
}

?>