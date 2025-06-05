<?php
require('connection_database.php');
$originalcinUtilisateur = $_GET['cinUtilisateur'];
$sql = "SELECT * FROM utilisateur WHERE cinUtilisateur = '$originalcinUtilisateur'";
$resultat = $connexion->query($sql);
$infoUser = $resultat->fetch_assoc();
$erreur = null;
if (isset($_POST['modifier'])) {
    $cinUtilisateur = $_POST['cinUtilisateur'];
    $nomUtilisateur= $_POST['nomUtilisateur'];
    $prenomUtilisateur= $_POST['prenomUtilisateur'];
    $adresseUtilisateur= $_POST['adresseUtilisateur'];
    $villeUtilisateur= $_POST['villeUtilisateur'];
    $telUtilisateur= $_POST['telUtilisateur'];
    $typeUtilisateur= $_POST['typeUtilisateur'];
    $loginUtilisateur= $_POST['loginUtilisateur'];
    $passwordUtilisateur= $_POST['passwordUtilisateur'];
    $updateSql = "UPDATE utilisateur SET 
    cinUtilisateur = '$cinUtilisateur',
    nomUtilisateur = '$nomUtilisateur',
    prenomUtilisateur = '$prenomUtilisateur',
    adresseUtilisateur = '$adresseUtilisateur',
    villeUtilisateur = '$villeUtilisateur',
    telUtilisateur = '$telUtilisateur',
    typeUtilisateur = '$typeUtilisateur',
    loginUtilisateur = '$loginUtilisateur',
    passwordUtilisateur = '$passwordUtilisateur'
    WHERE cinUtilisateur = '$originalcinUtilisateur'";


    if ($connexion->query($updateSql)) {
        $erreur = true;
    } else {
        $erreur = false;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Voiture</title>
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
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
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="registration-form">
                <h1 class="display-4 text-uppercase text-center mb-5">modification</h1>
                <form method="POST" action="">
                    <?php if (isset($erreur)): ?>
                        <?php if ($erreur === true) : ?>
                            <div class="alert alert-success text-center">Modification réussie.</div>
                        <?php elseif ($erreur === false) : ?>
                            <div class="alert alert-danger text-center">Erreur lors de la modification.</div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="cin" name="cinUtilisateur" value="<?= $infoUser['cinUtilisateur'] ?>"  required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nom" name="nomUtilisateur" value="<?= $infoUser['nomUtilisateur'] ?>"  required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Prenom" name="prenomUtilisateur" value="<?= $infoUser['prenomUtilisateur'] ?>" required>
                        </div>
                         <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="adresse" name="adresseUtilisateur" value="<?= $infoUser['adresseUtilisateur'] ?>" required>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="tel" class="form-control" placeholder="telephone" name="telUtilisateur" value="<?= $infoUser['telUtilisateur'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Ville" name="villeUtilisateur" value="<?= $infoUser['villeUtilisateur'] ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="login" name="loginUtilisateur" value="<?= $infoUser['loginUtilisateur'] ?>" required minlength="8">
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="password" name="passwordUtilisateur" value="<?= $infoUser['passwordUtilisateur'] ?>" required>
                        </div>
                    </div>
                    <div class="form-row"> 
                            <select class="form-control" name="typeUtilisateur" required>
                                <option value="<?= $infoUser['typeUtilisateur'] ?>"><?= $infoUser['typeUtilisateur'] ?></option>
                                <option value="Personal">Personal</option>
                                <option value="Business">Business</option>
                            </select>              
                    </div>
                    <input type="submit" name="modifier" value="modifier" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

</body>
</html>
