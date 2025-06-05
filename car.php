<?php
    session_start();
    require('connection_database.php');
    $sql = "SELECT * FROM voiture";
    $resultat = $connexion->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>projet_driveNow</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
        <style>
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
                        <?php if (isset($_SESSION['client_id'])): ?>
                            <a href="mes_reservations.php" class="nav-item nav-link">Car Rental</a>
                        <?php endif; ?>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Search Start -->
    <div class="container-fluid bg-white pt-3 px-lg-5">
        <div class="row mx-n2">
            <div class="col-xl-2 col-lg-4 col-md-6 px-2">
                <select class="custom-select px-4 mb-3" style="height: 50px;">
                    <option selected>Pickup Location</option>
                    <option value="errachidia">errachidia</option>
                    <option value="midelt">midelt</option>
                </select>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6 px-2">
                <select class="custom-select px-4 mb-3" style="height: 50px;">
                    <option selected>Drop Location</option>
                    <option value="errachidia">errachidia</option>
                    <option value="midelt">midelt</option>
                </select>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6 px-2">
                <div class="date mb-3" id="date" data-target-input="nearest">
                    <input type="date" class="form-control p-4 datetimepicker-input" placeholder="Pickup Date" />
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6 px-2">
                <div class="date mb-3" id="date" data-target-input="nearest">
                    <input type="date" class="form-control p-4 datetimepicker-input" placeholder="Drop Date">
                </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-6 px-2">
                <select class="custom-select px-4 mb-3" style="height: 50px;">
                    <option selected>Select A Car</option>
                    <?php         
                    $resultat->data_seek(0);
                    while ($car = $resultat->fetch_assoc()) { 
                    ?>
                        <option value="<?= $car['Matricule'] ?>"><?= $car['marque'] ?></option>
                    <?php } ?>
                </select>
            </div>          
            <div class="col-xl-2 col-lg-4 col-md-6 px-2">
                <button class="btn btn-block mb-3" type="submit" style="height: 50px; background-color: #75564d; color: #ffffff;">Search</button>
            </div>
        </div>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Car Listing</h1>
        <div class="d-inline-flex text-white">
            <h6 class="text-uppercase m-0"><a class="text-white" href="">Home</a></h6>
            <h6 class="text-body m-0 px-3">/</h6>
            <h6 class="text-uppercase text-body m-0">Car Listing</h6>
        </div>
    </div>
    <div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <h1 class="display-4 text-uppercase text-center mb-5">Find Your Car</h1>
        <div class="row">
            <?php 
            $resultat->data_seek(0);
            while ($car = $resultat->fetch_assoc()) { 
            ?>
                <div class="col-lg-4 col-md-6 mb-2">
                    <div class="rent-item mb-4">
                        <img class="img-fluid mb-4" src="<?php echo htmlspecialchars($car['photo']); ?>" alt="">
                        <h4 class="text-uppercase mb-4"><?php echo htmlspecialchars($car['marque']) . ' ' . htmlspecialchars($car['modele']); ?></h4>
                        <div class="d-flex justify-content-center mb-4">
                            <div class="px-2">
                                <i class="fa fa-car text-secondary mr-1"></i>
                                <span><?php echo htmlspecialchars($car['annee']); ?></span>
                            </div>
                            <div class="px-2 border-left border-right">
                                <i class="fa fa-cogs text-secondary mr-1"></i>
                                <span><?php echo htmlspecialchars($car['transmission']); ?></span>
                            </div>
                            <div class="px-2">
                                <i class="fa fa-road text-secondary mr-1"></i>
                                <span><?php echo htmlspecialchars($car['kilometrage']); ?></span>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['client_id'])): ?>
                            <a class="btn px-3" href="reserver.php?car_id=<?php echo urlencode($car['Matricule']); ?>" style="background-color: #2B2E4A; color: #ffffff;">
                                $<?php echo htmlspecialchars($car['prix']); ?>/Day
                            </a>
                        <?php else: ?>
                            <a class="btn px-3" href="connexionClient.php?redirect=reserver.php?car_id=<?php echo urlencode($car['Matricule']); ?>" style="background-color: #2B2E4A; color: #ffffff;">
                                $<?php echo htmlspecialchars($car['prix']); ?>/Day
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>
    <!-- Rent A Car End -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mx-0">
                <div class="col-lg-6 px-0">
                    <div class="px-5 d-flex align-items-center justify-content-between" style="height: 350px; background-color: #F4F5F8; color: #2B2E4A;">
                        <img class="img-fluid flex-shrink-0 ml-n5 w-50 mr-4" src="img/banner-left.png" alt="">
                        <div class="text-right">
                            <h3 class="text-uppercase mb-3" style="color: #2B2E4A;">Want to be driver?</h3>
                            <p class="mb-4">Lorem justo sit sit ipsum eos lorem kasd, kasd labore</p>
                            <a class="btn btn-secondary py-2 px-4" href="">Start Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-0">
                    <div class="px-5 d-flex align-items-center justify-content-between" style="height: 350px; background-color: #2B2E4A; color: #F4F5F8">
                        <div class="text-left">
                            <h3 class="text-uppercase mb-3" style="color:#F4F5F8; ">Looking for a car?</h3>
                            <p class="mb-4">Lorem justo sit sit ipsum eos lorem kasd, kasd labore</p>
                            <a class="btn btn-light py-2 px-4" href="">Start Now</a>
                        </div>
                        <img class="img-fluid flex-shrink-0 mr-n5 w-50 ml-4" src="img/banner-right.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <!-- Footer Start -->
    <div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5" style="margin-top: 90px; ">
        <div class="row pt-5">
                <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Get In Touch</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-white mr-3"></i>errachidia</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-white mr-3"></i>+212 6 37 56 67 76 </p>
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
                    <a class="text-body mb-2" href="index.php"><i class="fa fa-angle-right text-white mr-2 "></i>Home</a>
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
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-dark btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>