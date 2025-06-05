<?php

require('connection_database.php');

if (isset($_GET['matricule'])) {
    $matricule = $_GET['matricule'];
    $sql = "DELETE FROM Voiture WHERE matricule = '$matricule'";
    $resultat = $connexion->query($sql);

    if ($resultat) {
        header('Location: acceuil.php');
        exit(); // optionnel, mais recommandé après header()
    } else {
        echo 'Erreur lors de la suppression.';
    }
}
?>
