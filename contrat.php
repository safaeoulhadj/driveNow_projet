<?php
require('connection_database.php');
session_start();

if (!isset($_GET['id'])) {
    die("ID de location non spécifié");
}

$id_location = intval($_GET['id']);

$sql = "  SELECT *
    FROM Location l
    JOIN utilisateur u ON l.cinutilisateur = u.cinutilisateur
    JOIN voiture v ON l.Matricule = v.Matricule
    JOIN contrat c ON l.numContrat = c.numContrat
    WHERE l.Id_location = $id_location
";

$resultat = $connexion->query($sql);

if (!$resultat || $resultat->num_rows === 0) {
    die("Location introuvable");
}

$location = $resultat->fetch_assoc();

if (isset($_SESSION['client_id']) && $_SESSION['client_id'] !== $location['cinutilisateur']) {
    die("Accès non autorisé");
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrat de Location N°<?= $location['numContrat'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .contract-container { max-width: 800px; margin: 30px auto; background: white; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .contract-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .contract-title { font-size: 24px; font-weight: bold; }
        .contract-section { margin-bottom: 20px; }
        .section-title { font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; }
        .signature-area { margin-top: 50px; }
        .signature-line { border-top: 1px solid #333; width: 200px; display: inline-block; margin-top: 50px; }
        .print-button { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="contract-container">
            <!-- En-tête du contrat -->
            <div class="contract-header">
                <img src="LOGO.png" alt="Logo" style="height: 80px; margin-bottom: 15px;">
                <div class="contract-title">CONTRAT DE LOCATION DE VÉHICULE</div>
                <div>N° <?= $location['numContrat'] ?></div>
                <div>Date: <?= date('d/m/Y', strtotime($location['dateEtablissement'])) ?></div>
            </div>

            <!-- Parties contractantes -->
            <div class="contract-section">
                <div class="section-title">ENTRE LES SOUSSIGNÉS :</div>
                <p>
                    La société <strong>driveNow</strong>, dont le siège social est situé à errachidia, 
                    représentée par ............ dûment habilité à l'effet des présentes,
                </p>
                <p class="text-center"><strong>ET</strong></p>
                <p>
                    <strong>
                        <?= $location['typeutilisateur'] == 'entreprise' ? 'La société ' : 'Monsieur/Madame ' ?>
                        <?= $location['nomutilisateur'] ?> <?= $location['prenomutilisateur'] ?>
                    </strong>,<br>
                    demeurant <?= $location['adresseutilisateur'] ?>, <?= $location['villeutilisateur'] ?>,<br>
                    <?= $location['typeutilisateur'] == 'entreprise' ? 'Immatriculée au ' : 'de nationalité [Nationalité], né(e) le ............ à ............,' ?>
                    titulaire de la <?= $location['typeutilisateur'] == 'entreprise' ? 'RC ' : 'CIN ' ?> N° <?= $location['cinutilisateur'] ?>,
                </p>
            </div>

            <!-- Objet du contrat -->
            <div class="contract-section">
                <div class="section-title">IL A ÉTÉ CONVENU CE QUI SUIT :</div>
                <div class="section-title">Article 1 - Objet</div>
                <p>Le présent contrat a pour objet la location du véhicule décrit ci-après au client, aux conditions définies dans les présentes.</p>
            </div>

            <!-- Description du véhicule -->
            <div class="contract-section">
                <div class="section-title">Article 2 - Véhicule loué</div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Marque:</strong> <?= $location['marque'] ?></p>
                        <p><strong>Modèle:</strong> <?= $location['modele'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Immatriculation:</strong> <?= $location['Matricule'] ?></p>
                        <p><strong>Couleur:</strong> <?= $location['couleur'] ?></p>
                    </div>
                </div>
                <p><strong>Numéro de série:</strong>.................</p>
            </div>

            <!-- Durée de location -->
            <div class="contract-section">
                <div class="section-title">Article 3 - Durée de la location</div>
                <p>
                    La location prend effet le <strong><?= date('d/m/Y', strtotime($location['date_debut'])) ?></strong><br>
                    et expire le <strong><?= date('d/m/Y', strtotime($location['date_fin'])) ?></strong> 
                </p>
            </div>

            <!-- Prix et modalités -->
            <div class="contract-section">
                <div class="section-title">Article 4 - Prix et modalités de paiement</div>
                <p>Le prix total de la location s'élève à <strong><?= $location['montant_total'] ?> DH</strong>.</p>
                <p><strong>Modalités de paiement:</strong> [Description des modalités]</p>
                <p><strong>État du paiement:</strong> <?= $location['status'] ?></p>
            </div>

            <!-- État du véhicule -->
            <div class="contract-section">
                <div class="section-title">Article 5 - État du véhicule</div>
                <p>
                    Le véhicule est remis au locataire en parfait état de fonctionnement et de propreté. 
                    Le locataire reconnaît avoir vérifié l'état du véhicule et déclare n'avoir relevé 
                    aucun dommage autre que ceux mentionnés au constat établi conjointement.
                </p>
            </div>

            <!-- Conditions générales -->
            <div class="contract-section">
                <div class="section-title">Article 6 - Conditions générales</div>
                <ol>
                    <li>Le locataire s'engage à utiliser le véhicule conformément à sa destination et dans le respect du code de la route.</li>
                    <li>Tous les dommages causés au véhicule pendant la durée de la location seront à la charge du locataire.</li>
                    <li>Le véhicule est assuré tous risques. La franchise est à la charge du locataire en cas de sinistre.</li>
                    <li>Le locataire s'engage à restituer le véhicule à la date et à l'heure prévues au contrat.</li>
                    <li>En cas de retard dans la restitution, des frais supplémentaires seront appliqués.</li>
                    <li>Le carburant est à la charge du locataire.</li>
                </ol>
            </div>

            <!-- Signatures -->
            <div class="signature-area">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <p>Fait à <?= $location['villeutilisateur'] ?></p>
                        <p>Le <?= date('d/m/Y') ?></p>
                        <div class="signature-line"></div>
                        <p>Signature du client</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <p>Pour LOCAVOIT</p>
                        <div class="signature-line"></div>
                        <p>Signature du responsable</p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="text-center print-button">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Imprimer le contrat
                </button>
                <?php if (isset($_SESSION['client_id'])): ?>
                    <a href="reservations.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour aux réservations
                    </a>
                <?php else: ?>
                    <a href="../mon-compte.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour à mon compte
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>