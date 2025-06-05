<?php
require('connection_database.php');

if (isset($_POST['createAccount'])) {
    $cinUtilisateur = $_POST['cinUtilisateur'];
    $nomUtilisateur      = $_POST['nomUtilisateur'];
    $prenomUtilisateur       = $_POST['prenomUtilisateur'];
    $adresseUtilisateur          = $_POST['adresseUtilisateur'];
    $villeUtilisateur    = $_POST['villeUtilisateur'];
    $telUtilisateur        = $_POST['telUtilisateur'];
    $typeUtilisateur           = $_POST['typeUtilisateur'];
    $loginUtilisateur       = $_POST['loginUtilisateur'];
    $passwordUtilisateur      = $_POST['passwordUtilisateur'];
    $passwordUtilisateur2           = $_POST['passwordUtilisateur2'];

    if ($passwordUtilisateur == $passwordUtilisateur2) {
$sql = "INSERT INTO utilisateur (cinutilisateur,nomutilisateur,prenomutilisateur,adresseutilisateur,villeutilisateur,telutilisateur,typeutilisateur,loginutilisateur,passwordutilisateur,Roletilutilisateur)
         VALUES ('$cinUtilisateur','$nomUtilisateur','$prenomUtilisateur','$adresseUtilisateur','$villeUtilisateur','$telUtilisateur','$typeUtilisateur','$loginUtilisateur','$passwordUtilisateur', 0)"; 
         $resultat=$connexion->query($sql);
        if ($resultat) {
           $erreur=true; 
        } else {
           $erreur=false;
        }
    }else{
        $erreur="mismatch";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DriveNow - Inscription</title>
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
        .registration-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .registration-form h1 {
            color: #75564d;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .registration-form .form-control {
            height: 50px;
            margin-bottom: 15px;
        }
        
        .registration-form .btn-primary {
            background-color:#75564d;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            margin-top: 20px;
        }
        
        .registration-form .btn-primary:hover {
            background-color: #75564d;
        }
        
        .form-row {
            margin-bottom: 15px;
        }
        
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
 <!-- Registration Form Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="registration-form">
                <h1 class="display-4 text-uppercase text-center mb-5">Create Your Account</h1>
                <form method="POST" action="">
                    <?php if (isset($erreur)) : ?>
                        <?php if ($erreur === true) : ?>
                            <div class="alert alert-success text-center">✅ Inscription réussie. <a href="connexionClient.php">Connectez-vous</a></div>
                        <?php elseif ($erreur === false) : ?>
                            <div class="alert alert-danger text-center">❗ Erreur lors de l'inscription. Veuillez réessayer.</div>
                        <?php elseif ($erreur === "mismatch") : ?>
                            <div class="alert alert-danger text-center">Les mots de passe ne correspondent pas.</div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cin Utilisateur" name="cinUtilisateur" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nom Utilisateur" name="nomUtilisateur" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Prenom Utilisateur" name="prenomUtilisateur" required>
                        </div>
                        <div class="col-md-6">
                            <input type="tel" class="form-control" placeholder="Adresse Utilisateur" name="adresseUtilisateur" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Ville Utilisateur" name="villeUtilisateur" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Tel Utilisateur" name="telUtilisateur" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Password" name="passwordUtilisateur" required minlength="8">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Login Utilisateur" name="loginUtilisateur" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="passwordUtilisateur2" required minlength="8">
                        </div>
                        <div class="col-md-6" >
                            <select class="form-control" name="typeUtilisateur" required>
                                <option value="" selected disabled>type Utilisateur</option>
                                <option value="Personal">Personal</option>
                                <option value="Business">Business</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">I agree to the <a href="#">Terms and Conditions</a></label>
                    </div>
                    <input type="submit" name="createAccount" value="Create Account" class="btn btn-primary">
                    <p class="text-center mt-3">Already have an account? <a href="connexionClient.php">Sign in</a></p>
                </form>
            </div>
        </div>
    </div>
    <!-- Registration Form End -->    
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