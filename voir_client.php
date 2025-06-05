<?php
require('connection_database.php');

if (!isset($_GET['cinutilisateur']) || empty($_GET['cinutilisateur'])) {
    echo "Aucun client sélectionné.";
    exit;
}

$cin = $_GET['cinutilisateur'];
$sql = "SELECT * FROM utilisateur WHERE cinutilisateur = '$cin'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows == 0) {
    echo "Client non trouvé.";
    exit;
}

$client = $resultat->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du client</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }
        .container {
             max-width: 700px; 
             margin: 40px auto; 

            }
        .table th {
             width: 200px;
             }
        .badge-success {
             background-color: #28a745;
             }
        .badge-danger {
             background-color: #dc3545; 
            }

        th{
            background-color: #2B2E4A;
            color:white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">📋 Détails du client</h2>
        <table class="table table-bordered">
            <tr><th>CIN</th><td><?= $client['cinutilisateur'] ?></td></tr>
            <tr><th>Nom</th><td><?= $client['nomutilisateur'] ?></td></tr>
            <tr><th>Prénom</th><td><?= $client['prenomutilisateur'] ?></td></tr>
            <tr><th>Email</th><td><?= $client['loginutilisateur'] ?></td></tr>
            <tr><th>Téléphone</th><td><?= $client['telutilisateur'] ?></td></tr>
            <tr><th>Adresse</th><td><?= $client['adresseutilisateur'] ?></td></tr>
            <tr><th>Ville</th><td><?= $client['villeutilisateur'] ?></td></tr>
            <tr><th>Type de compte</th><td><?= $client['typeutilisateur'] ?></td></tr>
        </table>
        <a href="gestion_clients.php" class="btn btn-secondary">⬅ Retour</a>
        <a href="modifierUser.php?cinUtilisateur=<?= $client['cinutilisateur'] ?>" class="btn btn-success"> Modifier</a>
        <a href="deletUser.php?cinUtilisateur=<?= $client['cinutilisateur'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');"> Supprimer</a>
    </div>
</body>
</html>
