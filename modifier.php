<?php
require('connection_database.php');
$originalMatricule = $_GET['matricule'];
$sql = "SELECT * FROM Voiture WHERE matricule = '$originalMatricule'";
$resultat = $connexion->query($sql);
$infoVoiture = $resultat->fetch_assoc();
$erreur = null;
if (isset($_POST['modifier'])) {
    $matricule = $_POST['Matricule'];
    $couleur= $_POST['couleur'];
    $prix= $_POST['prix'];
    $marque= $_POST['marque'];
    $model= $_POST['Model'];

    if (!empty($_FILES['photo']['tmp_name'])) {
        $photoTmp = $_FILES['photo']['tmp_name'];
        $image    = 'img/' . basename($_FILES['photo']['name']);
        move_uploaded_file($photoTmp, $image);
    } else {
        $image = $connexion->real_escape_string($infoVoiture['photo']);
    }
    $updateSql = "UPDATE Voiture SET 
        matricule = '$matricule',
        couleur   = '$couleur',
        photo     = '$image',
        prix      = '$prix',
        modele    = '$model',
        marque    = '$marque' 
        WHERE matricule = '$originalMatricule'";

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
            background-color: #fff;
            padding: 40px;
            max-width: 800px;
            margin: 40px auto;
        }
        .registration-form h1 {
            color: #75564d;
            margin-bottom: 30px;
            text-align: center;
        }
        .registration-form .form-control {
            height: 50px;
            margin-bottom: 15px;
            background-color: #F4F5F8;
            border: none;
        }
        .registration-form .btn-primary {
            background-color: #75564d;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 18px;
            margin-top: 20px;
        }
        .registration-form .btn-primary:hover {
            background-color: #5e493c;
        }
        .alert {
            max-width: 800px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="registration-form">
                <h1 class="display-4 text-uppercase">Modifier Voiture</h1>
                <?php if ($erreur === true) : ?>
                    <div class="alert alert-success text-center">Modification réussie.</div>
                <?php elseif ($erreur === false) : ?>
                    <div class="alert alert-danger text-center">Erreur lors de la modification.</div>
                <?php endif; ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="Matricule" name="Matricule" value="<?= $infoVoiture['matricule'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="form-control" name="couleur" required>
                                <option value="<?=$infoVoiture['couleur'] ?>"><?= $infoVoiture['couleur'] ?></option>
                                <option value="Bleu">Bleu</option>
                                <option value="Red">Red</option>
                                <option value="Green">Green</option>
                                <option value="Black">Black</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="Prix" name="prix" value="<?= $infoVoiture['prix'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" placeholder="Model" name="Model" value="<?= $infoVoiture['modele'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <select class="form-control" name="marque" required>
                            <option value="<?= $infoVoiture['marque'] ?>"><?= $infoVoiture['marque'] ?></option>
                            <option value="Toyota">Toyota</option>
                            <option value="Renault">Renault</option>
                            <option value="BMW">BMW</option>
                            <option value="Volkswagen">Volkswagen</option>
                            <option value="Honda">Honda</option>
                            <option value="Audi">Audi</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <input type="file" class="form-control" name="photo">
                    </div>
                    <div class="form-group mb-3 text-center">
                        <input type="submit" class="btn btn-primary px-5" value="Modifier" name="modifier">
                    </div>
                    <div class="form-group mb-3 text-center">
                        <p><a href="acceuil.php">Tableau de bord</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
