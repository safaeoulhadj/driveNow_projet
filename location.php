<?php
session_start();
require('connection_database.php');

// Get status filter if set
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Build SQL query with optional status filter
$sql = "SELECT * FROM utilisateur NATURAL JOIN location NATURAL JOIN voiture WHERE Roletilutilisateur=0";
if (!empty($status_filter)) {
    $sql .= " AND status = '" . $connexion->real_escape_string($status_filter) . "'";
}
$result = $connexion->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - driveNow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    width: 250px;
    background-color: #2B2E4A;
    color: white;
    padding: 20px 0;
}
.logo {
    text-align: center;
    padding: 0 20px 20px;
    border-bottom: 1px solid #34495e;
}
.logo h1 {
    font-size: 1.5rem;
    margin-bottom: 5px;
}
.logo p {
    font-size: 0.8rem;
    color: #bdc3c7;
}
.sidebar nav ul {
    list-style: none;
    margin-top: 20px;
}
.sidebar nav ul li {
    margin: 5px 0;
}
.sidebar nav ul li a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #ecf0f1;
    text-decoration: none;
    transition: all 0.3s;
}
.sidebar nav ul li a:hover {
    background-color: #34495e;
}
.sidebar nav ul li a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}
.sidebar nav ul li.active a {
    background-color: #F4F5F8;
    color: #2B2E4A;
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
.badge-success {
    background-color: #d4edda;
    color: #155724;
}
.badge-danger {
    background-color: #f8d7da;
    color: #721c24;
}
.badge-warning {
    background-color: #fff3cd;
    color: #856404;
}
.badge-info {
    background-color: #d1ecf1;
    color: #0c5460;
}
.badge-secondary {
    background-color: #e2e3e5;
    color: #383d41;
}
.btn {
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.8rem;
    margin-right: 5px;
    display: inline-block;
}
.btn-success {
    background-color: #28a745;
    color: white;
}
.btn-danger {
    background-color: #dc3545;
    color: white;
}
.btn-info {
    background-color: #17a2b8;
    color: white;
}
.btn-warning {
    background-color: #ffc107;
    color: #212529;
}
.search-filter {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}
.search-filter label {
    margin-right: 10px;
    font-weight: 500;
}
.search-filter select {
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #ddd;
    margin-right: 10px;
}
.search-filter button {
    padding: 8px 15px;
    background-color: #2B2E4A;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.search-filter button:hover {
    background-color: #34495e;
}
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
    }
    .search-filter {
        flex-direction: column;
        align-items: flex-start;
    }
    .search-filter label,
    .search-filter select,
    .search-filter button {
        margin-bottom: 10px;
        width: 100%;
    }
}
#succes{ 
    color:green;   
}
#danger{
    color:red;
}
.sidebar {
    width: 250px;
    background-color: #2B2E4A;
    color: white;
    padding: 20px 0;
}
.sidebar nav ul {
    list-style: none;
    margin-top: 20px;
}
.sidebar nav ul li {
    margin: 5px 0;
}
.sidebar nav ul li a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #ecf0f1;
    text-decoration: none;
    transition: all 0.3s;
}
.sidebar nav ul li a:hover {
    background-color: #34495e;
}
.sidebar nav ul li a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}
.sidebar nav ul li.active a {
    background-color: #F4F5F8;
    color: #2B2E4A;
}
</style>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <h1>driveNow</h1>
                <p>Administration</p>
            </div>
            <nav>
                <ul>
                    <li><a href="acceuil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m20.772 10.155l-1.368-4.104A2.995 2.995 0 0 0 16.559 4H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.104A2 2 0 0 0 2 12v5c0 .738.404 1.376 1 1.723V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2h12v2a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2.277A1.99 1.99 0 0 0 22 17v-5a2 2 0 0 0-1.228-1.845M7.441 6h9.117c.431 0 .813.274.949.684L18.613 10H5.387l1.105-3.316A1 1 0 0 1 7.441 6M5.5 16a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 5.5 16m13 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 18.5 16"/></svg> Cars</a></li>
                    <li><a href="gestion_clients.php"><i class="fas fa-users"></i>Utilisateurs</a></li>
                    <li class="active"><a href="gestion_location.php"><i class="fas fa-exchange-alt"></i> location</a></li>
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
                  <span><?=$_SESSION['nom']." ".$_SESSION['prenom']?></span>
                  <div class="avatar"><?= substr($_SESSION['nom'], 0, 1).substr($_SESSION['prenom'], 0, 1) ?></div>
                <?php else: ?>
                  <span>Admin</span>
                  <div class="avatar">A</div>
                <?php endif; ?>
              </div>
            </header>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m20.772 10.155l-1.368-4.104A2.995 2.995 0 0 0 16.559 4H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.104A2 2 0 0 0 2 12v5c0 .738.404 1.376 1 1.723V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2h12v2a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2.277A1.99 1.99 0 0 0 22 17v-5a2 2 0 0 0-1.228-1.845M7.441 6h9.117c.431 0 .813.274.949.684L18.613 10H5.387l1.105-3.316A1 1 0 0 1 7.441 6M5.5 16a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 5.5 16m13 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 18.5 16"/></svg>
                    </div>
                    <div class="stat-info">
                        <h3>Cars</h3>
                        <p class="number">1,245</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Utilisateurs</h3>
                        <p class="number">568</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Emprunts</h3>
                        <p class="number">324</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Retards</h3>
                        <p class="number">28</p>
                    </div>
                </div>
            </div>
            <div class="container my-4">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form method="GET" action="" class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label for="status" class="form-label fw-bold">Filtrer par statut :</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="">Tous les statuts</option>
                                            <option value="En attente" <?= $status_filter == 'En attente' ? 'selected' : '' ?>>En attente</option>
                                            <option value="Acceptée" <?= $status_filter == 'Acceptée' ? 'selected' : '' ?>>Acceptée</option>
                                            <option value="Refusée" <?= $status_filter == 'Refusée' ? 'selected' : '' ?>>Refusée</option>
                                            <option value="Terminée" <?= $status_filter == 'Terminée' ? 'selected' : '' ?>>Terminée</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                                    </div>

                                    <?php if (!empty($status_filter)): ?>
                                    <div class="col-md-2">
                                        <a href="gestion_location.php" class="btn btn-danger w-100">Réinitialiser</a>
                                    </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="recent-activity">
                <table>
                    <thead>
                      <tr>
                         <th scope="col">Nom & Prénom</th>
                         <th scope="col">Voiture (marque + modèle)</th>
                         <th scope="col">Date début / fin</th>
                         <th scope="col">Prix total</th>
                         <th scope="col">Statut</th>
                         <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
       <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['nomutilisateur']." ".$row['prenomutilisateur'] ?></td>
            <td><?= $row['Matricule']." ". $row['modele'] ?></td>
            <td><?=  $row['date_debut']."  à ".$row['date_fin']?></td>
            <td><?= $row['montant_total'] ?></td>
            <td>
              <?php
                $status = strtolower($row['status']);
                switch ($status) {
                  case 'acceptée':
                    echo '<span class="badge badge-success">✅ Acceptée</span>';
                    break;
                  case 'refusée':
                    echo '<span class="badge badge-danger">❌ Refusée</span>';
                    break;
                  case 'en attente':
                    echo '<span class="badge badge-warning">⌛ En attente</span>';
                    break;
                  case 'terminée':
                    echo '<span class="badge badge-info">✔️ Terminée</span>';
                    break;
                  default:
                    echo '<span class="badge badge-secondary">'.$row['status'].'</span>';
                }
              ?>
            </td>
            <td>
                <a href="accepter_location.php?id=<?= $row['id_location'] ?>" class="btn btn-success">Accepter</a>
                <a href="refuser_location.php?id=<?= $row['id_location'] ?>" class="btn btn-danger">Refuser</a>
                <a href="terminer_location.php?id=<?= $row['id_location'] ?>" class="btn btn-info">Terminée</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">Aucune location trouvée.</td>
        </tr>
      <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>