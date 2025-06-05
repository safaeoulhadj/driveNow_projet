<?php
require('connection_database.php');

if (isset($_POST['ajouter'])) {
    $matricule = $_POST['Matricule'];
    $couleur = $_POST['couleur'];
    $prix = $_POST['prix'];
    $marque = $_POST['marque'];
    $model = $_POST['Model'];
    $photo = $_FILES['photo']['tmp_name'];
    $image = "img/" . $_FILES['photo']['name'];
    move_uploaded_file($photo, $image) ;
    $sql = "INSERT INTO Voiture (matricule, couleur, photo, prix,  modele, marque, disponible)
            VALUES ('$matricule', '$couleur', '$image', '$prix', '$model', '$marque','1')";
    $resultat = $connexion->query($sql);
    if ($resultat) {   
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
    <title>DriveNow - Connexion Client</title>
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

    </style>
</head>
<body>
   <div class="container-fluid py-5">
    <div class="container pt-5 pb-3">
        <div class="registration-form">
            <h1 class="display-4 text-uppercase text-center mb-5">add cars</h1>
            <?php if (isset($erreur)) : ?>
                <?php if ($erreur === true) : ?>
                    <div class="alert alert-success text-center">Ajout avec succès.</div>
                <?php elseif ($erreur === false) : ?>
                    <div class="alert alert-danger text-center">Erreur lors de l'ajout.</div>
                <?php endif; ?>
            <?php endif; ?>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" placeholder="Matricule" name="Matricule" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select class="form-control" name="couleur" required>
                            <option disabled selected>Colors</option>
                            <option value="Bleu">Bleu</option>
                            <option value="Red">Red</option>
                            <option value="Green">Green</option>
                            <option value="Black">Black</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" placeholder="Prix" name="prix" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" placeholder="Model" name="Model" required>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <select class="form-control" name="marque" required>
                        <option disabled selected>Marque</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Renault">Renault</option>
                        <option value="BMW">BMW</option>
                        <option value="Volkswagen">Volkswagen</option>
                        <option value="Honda">Honda</option>
                        <option value="Audi">Audi</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <input type="file" class="form-control" name="photo" required>
                </div>
                <div class="form-group mb-3 text-center">
                    <input type="submit" class="btn btn-primary px-5" value="Ajouter" name="ajouter">
                </div>
                <div class="form-group mb-3 text-center">
                    <p><a href="dashboard.php">Tableau de bord</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
 </body>
</html>