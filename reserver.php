<?php
session_start();
require('connection_database.php');

if (!isset($_SESSION['client_id'])) {
    header("Location: connexionClient.php?redirect=reserver.php?car_id=" . urlencode($_GET['car_id']));
    exit();
}

if (!isset($_GET['car_id'])) {
    header("Location: car.php");
    exit();
}

$car_id = $_GET['car_id'];
$sql = "SELECT * FROM voiture WHERE Matricule = '$car_id'";
$result = $connexion->query($sql);
if ($result->num_rows === 0) {
    header("Location: car.php");
    exit();
}
$car = $result->fetch_assoc();

$erreur = null;
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $lieu_prise = $_POST['lieu_prise'];
    $lieu_retour = $_POST['lieu_retour'];

    $today = date('Y-m-d');
    $timestamp_debut = strtotime($date_debut);
    $timestamp_fin = strtotime($date_fin);
    $jours = ($timestamp_fin - $timestamp_debut) / (60 * 60 * 24);

    if ($date_debut < $today) {
        $erreur = "❌ La date de début ne peut pas être dans le passé.";
    } elseif ($date_fin < $date_debut) {
        $erreur = "❌ La date de fin doit être après la date de début.";
    } elseif ($jours <= 0) {
        $erreur = "❌ La durée de location doit être d'au moins 1 jour.";
    } else {
        $montant_total = $jours * $car['prix'];
        $client_id = $_SESSION['client_id'];
        $typeContrat = 'Standard';
        $dateEtablissement = date('Y-m-d');
        $sql_check = "SELECT * FROM location 
                      WHERE Matricule = '$car_id' 
                      AND status IN ('en attente', 'confirmé', 'retardé')
                      AND (
                          ('$date_debut' BETWEEN date_debut AND date_fin)
                          OR ('$date_fin' BETWEEN date_debut AND date_fin)
                          OR (date_debut BETWEEN '$date_debut' AND '$date_fin')
                          OR (date_fin BETWEEN '$date_debut' AND '$date_fin')
                      )";

        $result_check = $connexion->query($sql_check);

        if ($result_check->num_rows > 0) {
            $erreur = "❌ Désolé, cette voiture est déjà réservée pour cette période.";
        } else {

            $sqlContrat = "INSERT INTO contrat (typeContrat, dateEtablissement, cinetUtilisateur)
                           VALUES ('$typeContrat', '$dateEtablissement', '$client_id')";

            if ($connexion->query($sqlContrat)) {
                $numContrat = $connexion->insert_id;

                $sqlLocation = "INSERT INTO location (montant_total, date_debut, date_fin, status, numContrat, Matricule, cinutilisateur, lieu_prise, lieu_retour) 
                                VALUES ('$montant_total', '$date_debut', '$date_fin', 'en attente', '$numContrat', '$car_id', '$client_id', '$lieu_prise', '$lieu_retour')";

                if ($connexion->query($sqlLocation)) {
                    $success = true;
                } else {
                    $connexion->rollback();
                    $erreur = "❌ Erreur lors de l'enregistrement de la location : " . $connexion->error;
                }
            } else {
                $connexion->rollback();
                $erreur = "❌ Erreur lors de la création du contrat : " . $connexion->error;
            }
        }
    }
}
if (isset($_GET['matricule'], $_GET['date_debut'], $_GET['date_fin'])) {
    $matricule = $_GET['matricule'];
    $date_debut = $_GET['date_debut'];
    $date_fin = $_GET['date_fin'];

    $sql = "SELECT * FROM location 
            WHERE Matricule = '$matricule'
            AND status IN ('en attente', 'confirmé')
            AND (
                ('$date_debut' BETWEEN date_debut AND date_fin)
                OR ('$date_fin' BETWEEN date_debut AND date_fin)
                OR (date_debut BETWEEN '$date_debut' AND '$date_fin')
                OR (date_fin BETWEEN '$date_debut' AND '$date_fin')
            )";

    $res = $connexion->query($sql);
    echo $res->num_rows > 0 ? 'indisponible' : 'disponible';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Réserver une voiture - driveNow</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .reservation-container {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .car-image {
            transition: transform 0.3s;
        }
        .car-image:hover {

        }
        .form-control {
            height: 50px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
        .form-control:focus {
            border-color: #75564d;
            box-shadow: 0 0 0 0.2rem rgba(117, 86, 77, 0.25);
        }
        .btn-reserver {
            background-color: #75564d;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-reserver:hover {
            background-color: #75564d;
            color: white;
            transform: translateY(-2px);
        }
        .price-display {
            font-size: 24px;
            font-weight: 700;
            color: #75564d;
            margin: 20px 0;
        }
        .detail-item {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .detail-item i {
            color: #75564d;
            margin-right: 10px;
            width: 20px;
        }
        .avatar {
            background-color: #fff;
            color: #2B2E4A;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-left: 10px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid py-3 px-lg-5 d-none d-lg-block" style="background-color: #2B2E4A;">
         <div class="row justify-content-end">
            <div class="col-auto">
                <div class="d-inline-flex align-items-center">
                        <?php if (isset($_SESSION['client_id'])): ?>   
                        <a class="text-white px-3" href="deconnexion.php">
                            <div style="display: inline;">Logout</div>
                                <i class="fas fa-sign-out-alt" style="margin-left: 5px;"></i>
                        </a>                        
                        <span class="text-white">Welcome,<?= $_SESSION['client_prenom']?></span>
                        <div class="avatar"><?= strtoupper(substr($_SESSION['client_prenom'], 0, 1)) ?></div>

                        <?php else: ?>
                            <a class="text-white px-3" href="connexionClient.php">Sign in</a>
                            <span class="text-white">|</span>
                            <a class="text-white px-3" href="inscription.php">Sign Up</a>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>   
    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="position-relative px-lg-5" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0 pl-3 pl-lg-5" style="background-color: #F4F5F8;">
                <a href="" class="navbar-brand">
                    <img src="LOGO.png" alt="" width="170px">
                </a>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="service.php" class="nav-item nav-link">Services</a>
                        <a href="car.php" class="nav-item nav-link">Cars</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        <?php if (isset($_SESSION['client_id'])): ?>
                            <a href="reserver.php" class="nav-item nav-link">Car Rental</a>
                        <a class="text-white px-3" href="deconnexion.php">
                            <div style="display: inline;">Logout</div>
                                <i class="fas fa-sign-out-alt" style="margin-left: 5px;"></i>
                        </a>  
                        <?php endif; ?>
                       
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="reservation-container">
                <h1 class="display-4 text-uppercase text-center mb-5" style="color: #2B2E4A;">Réserver <span style="color: #75564d;"><?php echo htmlspecialchars($car['marque'] . ' ' . htmlspecialchars($car['modele'])); ?></span></h1>
                
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <img src="<?php echo $car['photo']; ?>" class="img-fluid car-image " alt="<?php echo htmlspecialchars($car['marque'] . ' ' . htmlspecialchars($car['modele'])); ?>">
                        
                        <div class="mt-4">
                    
                            <div class="price-display text-center">
                                Prix: $<?php echo htmlspecialchars($car['prix']); ?> / jour
                            </div>
                            <div id="etat-disponibilite" class="mt-3 text-center font-weight-bold"></div>
                            <div class="detail-item">
                                <i class="fa fa-car"></i>
                                <span>Année: <?php echo htmlspecialchars($car['annee']); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fa fa-cogs"></i>
                                <span>Transmission: <?php echo htmlspecialchars($car['transmission']); ?></span>
                            </div>
                            <div class="detail-item">
                                <i class="fa fa-road"></i>
                                <span>Kilométrage: <?php echo htmlspecialchars($car['kilometrage']); ?> km</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <?php if ($success): ?>
                            <div class="alert alert-success">Votre réservation a bien été enregistrée !</div>
                        <?php elseif ($erreur): ?>
                            <div class="alert alert-danger"><?php echo $erreur; ?></div>
                        <?php endif; ?>                      
                        <form method="POST">
                            <div class="form-group">
                                <label for="date_debut">Date de début</label>
                                <input type="date" class="form-control" id="date_debut" name="date_debut" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_fin">Date de fin</label>
                                <input type="date" class="form-control" id="date_fin" name="date_fin" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="lieu_prise">Lieu de prise en charge</label>
                                <select class="form-control" id="lieu_prise" name="lieu_prise" required>
                                    <option value="errachidia">errachidia</option>
                                    <option value="midelt">midelt</option>
                                    <option value="Gare">Gare</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lieu_retour">Lieu de retour</label>
                                <select class="form-control" id="lieu_retour" name="lieu_retour" required>
                                    <option value="errachidia">errachidia</option>
                                    <option value="midelt">midelt</option>
                                    <option value="Gare">Gare</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-reserver">
                                    <i class="fa fa-check-circle mr-2"></i> Confirmer la réservation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5" style="margin-top: 90px;">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Get In Touch</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-white mr-3"></i>errachidia</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-white mr-3"></i>+212 6 37 56 67 76</p>
                <p><i class="fa fa-envelope text-white mr-3"></i>driveNow@example.com</p>
                <h6 class="text-uppercase text-white py-2">Follow Us</h6>
                <div class="d-flex justify-content-start">
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-lg btn-dark btn-lg-square" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 mb-2">
                <h4 class="text-uppercase text-light mb-4">Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-body mb-2" href="index.php"><i class="fa fa-angle-right text-white mr-2"></i>Home</a>
                    <a class="text-body mb-2" href="about.php"><i class="fa fa-angle-right text-white mr-2"></i>About</a>
                    <a class="text-body mb-2" href="service.php"><i class="fa fa-angle-right text-white mr-2"></i>Services</a>
                    <a class="text-body mb-2" href="car.php"><i class="fa fa-angle-right text-white mr-2"></i>Cars</a>
                    <a class="text-body" href="contact.php"><i class="fa fa-angle-right text-white mr-2"></i>contact</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Car Gallery</h4>
                <div class="row mx-n1">
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-1.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-2.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-3.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-4.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-5.jpg" alt=""></a>
                    </div>
                    <div class="col-4 px-1 mb-2">
                        <a href=""><img class="w-100" src="img/gallery-6.jpg" alt=""></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Newsletter</h4>
                <p class="mb-4">Volup amet magna clita tempor. Tempor sea eos vero ipsum. Lorem lorem sit sed elitr sed kasd et</p>
                <div class="w-100 mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control bg-dark border-dark" style="padding: 25px;" placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-light text-uppercase px-3">Sign Up</button>
                        </div>
                    </div>
                </div>
                <i>Lorem sit sed elitr sed kasd et</i>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-dark btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    const etatDiv = document.getElementById('etat-disponibilite');
    const carId = "<?= $car_id ?>";

    function verifierDisponibilite() {
        const debut = dateDebut.value;
        const fin = dateFin.value;

        if (debut && fin && fin >= debut) {
            fetch(`verifier_disponibilite.php?matricule=${carId}&date_debut=${debut}&date_fin=${fin}`)
                .then(response => response.text())
                .then(status => {
                    if (status.trim() === 'disponible') {
                        etatDiv.innerHTML = "<span style='color: green;'>✅ Disponible</span>";
                    } else {
                        etatDiv.innerHTML = "<span style='color: red;'>❌ Indisponible</span>";
                    }
                });
        } else {
            etatDiv.innerHTML = "";
        }
    }

    dateDebut.addEventListener('change', verifierDisponibilite);
    dateFin.addEventListener('change', verifierDisponibilite);
</script>

</body>
</html>