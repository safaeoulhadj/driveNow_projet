<?php
session_start();
require('connection_database.php');
if (isset($_POST['connecter'])) {
    $email = $_POST['email'];
    $passWord = $_POST['password'];
    $sql = "SELECT * FROM utilisateur WHERE loginutilisateur = '$email' AND passwordutilisateur = '$passWord' AND Roletilutilisateur=0";
    $resultat = $connexion->query($sql);
    if ($resultat && $resultat->num_rows > 0) {
            $infoAdmin = $resultat->fetch_assoc();
            $_SESSION['client_id'] = $infoAdmin['cinutilisateur'];
            $_SESSION['client_prenom'] = $infoAdmin['prenomutilisateur'];
            header('Location: index.php');
  } else {
            $erreur = "Login ou mot de passe est invalide";
        }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DriveNow - Connexion Client</title>
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Login Form Start -->
  <div class="container-fluid py-5 px-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="bg-light mb-4" style="padding: 30px;">
                <div class="text-center mb-4">
                    <h2 class="text-dark">Connectez-vous</h2>
                    <p class="text-muted">Accédez à votre espace client DriveNow</p>
                </div>
                <form action=" " method="POST">
                    <div class="form-group mb-3">
                        <label for="email" class="text-dark">Email</label>
                        <input type="email" class="form-control p-4 bg-white" id="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="text-dark">Mot de passe</label>
                        <input type="password" class="form-control p-4 bg-white" placeholder="password" name="password" required>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" required>
                            <label class="form-check-label text-muted" for="remember">Se souvenir de moi</label>
                        </div>
                        <a href="forgot-password.php" class="text-primary">Mot de passe oublié ?</a>
                    </div>
                        
                    <input type="submit" class="btn btn-block py-3 text-light" style="background-color: #75564d;" value="Se connecter" name="connecter">
                        <?php if (isset($erreur)) : ?>
                            <div class="  text-danger text-center m-3 " role="alert">
                                <?= $erreur?>
                            </div>
                        <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Login Form End -->
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>