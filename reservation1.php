<?php
session_start();
require('connection_database.php');

if (!isset($_SESSION['client_id'])) {
    header("Location: connexionClient.php");
    exit();
}

// Récupérer les détails de la voiture à réserver
$car_id = $_GET['car_id'] ?? null;
if ($car_id) {
    $sql = "SELECT * FROM voiture WHERE Matricule = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("s", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $jours = (strtotime($date_fin) - strtotime($date_debut)) / (60 * 60 * 24);
    $montant_total = $jours * $car['prix'];
    $numContrat = strtoupper(uniqid("CNTR"));
    
    $sql = "INSERT INTO location (montant_total, date_debut, date_fin, status, numContrat, Matricule, cinutilisateur) 
            VALUES (?, ?, ?, 'confirmé', ?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("dsssss", $montant_total, $date_debut, $date_fin, $numContrat, $car_id, $_SESSION['client_id']);

    if ($stmt->execute()) {
        header("Location: mes_reservations.php?success=1");
        exit();
    } else {
        $erreur = "Une erreur s'est produite lors de la réservation. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Réserver <?php echo htmlspecialchars($car['marque'] ?? ''); ?> - driveNow</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .reservation-form {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #2B2E4A;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group label {
            font-weight: 600;
            color: #2B2E4A;
        }
        .form-control {
            height: 50px;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        .form-control:focus {
            border-color: #75564d;
            box-shadow: none;
        }
        .price-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .price-amount {
            font-size: 28px;
            font-weight: 700;
            color: #75564d;
        }
        .car-features {
            list-style: none;
            padding: 0;
        }
        .car-features li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .btn-confirm {
            background-color: #2B2E4A;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            width: 100%;
            margin-top: 20px;
        }
        .btn-confirm:hover {
            background-color: #75564d;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <div class="container-fluid py-2 px-lg-5 d-none d-lg-block" style="background-color: #2B2E4A;">
        <div class="row justify-content-end">
            <div class="col-auto">
                <div class="d-inline-flex align-items-center">
                    <span class="text-white px-2">Bienvenue, <?php echo htmlspecialchars($_SESSION['client_prenom'] ?? ''); ?></span>
                    <a class="text-white px-2" href="mes_reservations.php"><i class="fas fa-calendar-alt"></i></a>
                    <a class="text-white px-2" href="deconnexion.php"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3" style="background-color: #F4F5F8;">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="LOGO.png" alt="driveNow" height="40">
            </a>
            <div class="collapse navbar-collapse">
                <div class="navbar-nav ml-auto">
                    <a class="nav-item nav-link text-dark" href="car.php"><i class="fas fa-car mr-1"></i> Voitures</a>
                    <a class="nav-item nav-link text-dark" href="mes_reservations.php"><i class="fas fa-calendar-alt mr-1"></i> Mes réservations</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="reservation-form">
            <h2 class="form-title">RÉSERVER <?php echo htmlspecialchars($car['marque'] ?? ''); ?> <?php echo htmlspecialchars($car['modele'] ?? ''); ?></h2>
            
            <?php if (isset($erreur)): ?>
                <div class="alert alert-danger"><?php echo $erreur; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Date de début</label>
                    <input type="date" class="form-control" name="date_debut" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label>Date de fin</label>
                    <input type="date" class="form-control" name="date_fin" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label>Lieu de prise en charge</label>
                    <select class="form-control" name="lieu_prise" required>
                        <option value="Agence centrale">Agence centrale</option>
                        <option value="Aéroport">Aéroport</option>
                        <option value="Gare">Gare</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Lieu de retour</label>
                    <select class="form-control" name="lieu_retour" required>
                        <option value="Agence centrale">Agence centrale</option>
                        <option value="Aéroport">Aéroport</option>
                        <option value="Gare">Gare</option>
                    </select>
                </div>
                
                <div class="price-section">
                    <h5>Prix: <span class="price-amount">$<?php echo htmlspecialchars($car['prix'] ?? '0'); ?> / jour</span></h5>
                </div>
                
                <ul class="car-features">
                    <li><i class="fas fa-calendar mr-2"></i> Année: <?php echo htmlspecialchars($car['annee'] ?? ''); ?></li>
                    <li><i class="fas fa-cogs mr-2"></i> Transmission: <?php echo htmlspecialchars($car['transmission'] ?? ''); ?></li>
                    <li><i class="fas fa-tachometer-alt mr-2"></i> Kilométrage: <?php echo htmlspecialchars($car['kilometrage'] ?? ''); ?> km</li>
                </ul>
                
                <button type="submit" class="btn btn-confirm">
                    <i class="fas fa-check-circle mr-2"></i> Confirmer la réservation
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-secondary text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">© 2025 driveNow. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>