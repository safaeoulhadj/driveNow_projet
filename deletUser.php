<?php

require('connection_database.php');

if (isset($_GET['cinUtilisateur'])) {
    $cinUtilisateur = $_GET['cinUtilisateur'];
    $sql = "DELETE FROM utilisateur WHERE cinUtilisateur = '$cinUtilisateur'";
    $resultat = $connexion->query($sql);

    if ($resultat) {
        header('Location: gestion_clients.php');
        exit(); // optionnel, mais recommandé après header()
    } else {
        echo 'Erreur lors de la suppression.';
    }
}
?>
