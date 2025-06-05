<?php
session_start();
require('connection_database.php');
$stats = [
    'voitures' => $connexion->query("SELECT COUNT(*) FROM voiture")->fetch_row()[0],
    'locations' => $connexion->query("SELECT COUNT(*) FROM location")->fetch_row()[0],
    'clients' => $connexion->query("SELECT COUNT(*) FROM utilisateur WHERE Roletilutilisateur=0")->fetch_row()[0],
    'paiements' => $connexion->query("SELECT COUNT(*) FROM paiement")->fetch_row()[0]
];
if (isset($_GET['changer_statut'])) {
    $id = $_GET['id'];
    $statut = $_GET['statut'];
    mysqli_query($connexion, "UPDATE Location SET status = '$statut' WHERE id_location = $id");
    header('Location: reservations.php?success=1');
}
$sql = "SELECT * FROM Location 
    JOIN utilisateur ON Location.cinutilisateur = utilisateur.cinutilisateur
    JOIN voiture ON Location.Matricule = voiture.Matricule
    ORDER BY Location.date_debut DESC";
$result = mysqli_query($connexion, $sql);
$reservations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - driveNow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.admin-container {
    display: flex;
    min-height: 100vh;
    background-color: #f5f7fa;
}
.sidebar {
    width: 250px !important;
    background-color: #2B2E4A !important;
    color: white !important;
    padding: 20px 0 !important;
}

.sidebar .logo {
    text-align: left !important;
    padding: 20px !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

.sidebar .logo h1 {
    font-size: 1.5rem !important;
    margin-bottom: 5px !important;
    color: white !important;
    padding-left: 10px !important;
}

.sidebar .logo p {
    font-size: 0.8rem !important;
    color: rgba(255, 255, 255, 0.7) !important;
    padding-left: 10px !important;
}

.sidebar nav ul {
    list-style: none !important;
    margin-top: 20px !important;
    padding-left: 0 !important;
}

.sidebar nav ul li {
    margin: 5px 0 !important;
}

.sidebar nav ul li a {
    display: flex !important;
    align-items: center !important;
    padding: 12px 20px 12px 25px !important;
    color: #ecf0f1 !important;
    text-decoration: none !important;
    transition: all 0.3s !important;
    background-color: transparent !important;
    border: none !important;
}

.sidebar nav ul li a:hover {
    background-color: #34495e !important;
    color: #ecf0f1 !important;
}

.sidebar nav ul li a i {
    margin-right: 10px !important;
    width: 20px !important;
    text-align: center !important;
}

.sidebar nav ul li.active a {
    background-color: #F4F5F8 !important;
    color: #2B2E4A !important;
}
.main-content {
    flex: 1;
    padding: 20px;
}
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #ddd;
}
.admin-profile {
    display: flex;
    align-items: center;
}
.admin-profile span {
    margin-right: 10px;
}
.avatar {
    width: 40px;
    height: 40px;
    background-color: #2B2E4A;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background-color: white;
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 1.2rem;
}
.stat-icon.blue { background-color: #75564d;}
.stat-icon.green { background-color: #75564d;}
.stat-icon.orange { background-color: #75564d;}
.stat-icon.red { background-color : #75564d;}
.stat-info h3 {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin-bottom: 5px;
}
.stat-info .number {
    font-size: 1.5rem;
    font-weight: bold;
}
.recent-activity {
    background-color: white;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.recent-activity h3 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table th, table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}
table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #2c3e50;
}
.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}
.badge.loan { background-color: #d4edda; color: #155724; }
.badge.return { background-color: #d1ecf1; color: #0c5460; }
.badge.reserve { background-color: #fff3cd; color: #856404; }
@media (max-width: 768px) {
    .admin-container {
        flex-direction: column;
    }
    .sidebar {
        width: 100%;
    }
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
};
}
#succes{ 
  color:green;   
}
#danger{
color:red;
}

</style>
    <div class="admin-container">
        <!-- Sidebar -->
     <aside class="sidebar text-end">
        <div class="logo">
            <h1>driveNow</h1>
            <p>Administration</p>
        </div>
        <nav>
            <ul>
                <li><a href="index1.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="acceuil.php"><i class="bi bi-car-front"></i> Gestion Voitures</a></li>
                <li><a href="gestion_clients.php"><i class="fas fa-users"></i> Utilisateurs</a></li>
                <li class="active"><a href="reservations.php"><i class="bi bi-calendar-check"></i> Réservations</a></li>
                <li><a href="paiements.php"><i class="bi bi-credit-card"></i> Paiements</a></li>
                <li><a href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
                <li><a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </nav>
    </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="admin-header">
                <h2>Tableau de bord</h2>
                <div class="admin-profile">
                <?php if(isset($_SESSION['nom'])): ?>
                  <span><?=$_SESSION['prenom']." ".$_SESSION['nom']?></span>
                  <div class="avatar"><?= substr($_SESSION['prenom'], 0, 1)?></div>
                <?php else: ?>
                  <span>Admin</span>
                  <div class="avatar">A</div>
                <?php endif; ?>
              </div>
            </header>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                       <i class="bi bi-car-front"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Cars</h3>
                        <p class="number"><?= $stats['voitures'] ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>utilisateurs</h3>
                        <p class="number"><?= $stats['clients'] ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>locations</h3>
                        <p class="number"><?= $stats['locations'] ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red">
                      <i class="bi bi-credit-card"></i>
                    </div>
                    <div class="stat-info">
                        <h3>paiements</h3>
                        <p class="number"><?= $stats['paiements'] ?></p>
                    </div>
                </div>
            </div>            
  
        <div class="recent-activity">
                    <h2 class="mb-4">Gestion des Réservations</h2>
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Statut de réservation mis à jour avec succès!</div>
                    <?php endif; ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Client</th>
                                            <th>Voiture</th>
                                            <th>Dates</th>
                                            <th>Montant</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reservations as $res): ?>
                                        <tr>
                                            <td><?= $res['id_location'] ?></td>
                                            <td><?= $res['prenomutilisateur'] ?> <?= $res['nomutilisateur'] ?></td>
                                            <td><?= $res['marque'] ?> <?= $res['modele'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($res['date_debut'])) ?> - <?= date('d/m/Y', strtotime($res['date_fin'])) ?></td>
                                            <td><?= $res['montant_total'] ?> €</td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $res['status'] == 'confirmé' ? 'success' : 
                                                    ($res['status'] == 'annulé' ? 'danger' : 'warning') 
                                                ?>">
                                                    <?= $res['status'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown d-inline">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        Changer statut
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="reservations.php?changer_statut&id=<?= $res['id_location'] ?>&statut=en attente">En attente</a></li>
                                                        <li><a class="dropdown-item" href="reservations.php?changer_statut&id=<?= $res['id_location'] ?>&statut=confirmé">Confirmé</a></li>
                                                        <li><a class="dropdown-item" href="reservations.php?changer_statut&id=<?= $res['id_location'] ?>&statut=terminé">terminé</a></li>
                                                    </ul>
                                                </div>
                                                <a href="contrat.php?id=<?= $res['id_location'] ?>" class="btn btn-sm btn-info" target="_blank">
                                                    <i class="bi bi-file-earmark-text"></i> Contrat
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
        </div>
    <div class="recent-activity mt-5">
                    <div class="card-header">
                        <h2>retard réservations</h2>
                    </div>
<?php
if (isset($_GET['retour']) && is_numeric($_GET['retour'])) {
    $id_location = intval($_GET['retour']);
    $date_retour_reel = date('Y-m-d');
    $sql_get_dates = "SELECT date_fin FROM location WHERE Id_location = $id_location";
    $res_dates = $connexion->query($sql_get_dates);
    if ($res_dates && $res_dates->num_rows > 0) {
        $row_date = $res_dates->fetch_assoc();
        $date_fin = $row_date['date_fin'];
        $retard_jours = 0;
        if ($date_retour_reel > $date_fin) {
            $retard_jours = (strtotime($date_retour_reel) - strtotime($date_fin)) / (60 * 60 * 24);
        }
        $status = $retard_jours > 0 ? 'retardé' : 'terminé';

        $sql_retour = "UPDATE location 
                       SET date_retour_reel = '$date_retour_reel', status = '$status' 
                       WHERE Id_location = $id_location";

        if ($connexion->query($sql_retour)) {
            echo "<div class='alert alert-success'>Retour confirmé avec statut : <strong>$status</strong>.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur : " . $connexion->error . "</div>";
        }
    }
}
    $sql = "SELECT l.*, v.marque, v.modele, u.nom AS nomutilisateur, u.prenom AS prenomutilisateur
            FROM location l
            JOIN voiture v ON l.Matricule = v.Matricule
            JOIN utilisateur u ON l.cinutilisateur = u.cinutilisateur
            WHERE l.date_fin < CURDATE() AND l.status != 'terminé'";

    $result = $connexion->query($sql);
?>
<table >
    <thead>
        <tr>
            <th>Voiture</th>
            <th>Date début</th>
            <th>Date fin prévue</th>
            <th>Client</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['marque']) . ' ' . htmlspecialchars($row['modele']) ?></td>
                    <td><?= htmlspecialchars($row['date_debut']) ?></td>
                    <td><?= htmlspecialchars($row['date_fin']) ?></td>
                    <td><?= htmlspecialchars($row['prenomutilisateur']) . ' ' . htmlspecialchars($row['nomutilisateur']) ?></td>
                    <td>
                        <a href="locations.php?retour=<?= $row['Id_location'] ?>" 
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Confirmer le retour de cette voiture ?')">
                           Confirmer retour
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Aucune location en retard.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
           </div>        
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>