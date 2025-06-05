<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROYAL CARS - Connexion</title>

    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'arial', sans-serif;

        }
        h1{
            text-align: center;
            margin-top: 30px;
        }
        body {
            background: #ffffff;
            min-height: 100vh;
        }
        .login-container {
            display: flex;
            justify-content: center;
            padding: 50px 20px;
            background: #ffffff;
        }
        .login-form {
            position: relative;
            width: 400px;
            height: 420px;
            background: #e6e6e6;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 30px;
        }
        .login-form::before,
        .login-form::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 300px;
            height: 420px;
            transform-origin: bottom right;
            animation: animate 7s linear infinite;
        }
        .login-form::before {
            background: linear-gradient(0deg, transparent, #75564d, #75564d);
        }
        .login-form::after {
            background: linear-gradient(0deg, transparent, #2B2E4A, #2B2E4A);
            animation-delay: 3s;
        }
        @keyframes animate {
            100% {
                transform: rotate(360deg);
            }
        }
        .form {
            position: absolute;
            inset: 3px;
            border-radius: 8px;
            background: #ffffff;
            z-index: 10;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 98.5%;
        }

        .form h2 {
            text-align: center;
            letter-spacing: 0.05em;
            color: #2B2E4A;
            margin-bottom: 20px;
        }

        .inputBox {
            position: relative;
            margin-bottom: 20px;
        }

        .inputBox input {
            width: 100%;
            padding: 10px;
            background: #F4F5F8;
            border: none;
            border-bottom: 2px solid #2B2E4A;
            color: #fff;
            outline: none;
            transition: 0.3s;
        }

        .inputBox input::placeholder {
            color: #aaa;
        }

        .inputBox input:focus {
            border-bottom-color: #2B2E4A;
        }

        input[type="submit"] {
            background: #2B2E4A;
            border: none;
            padding: 10px;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #2B2E4A;
            color: #fff;
        }
    </style>
</head>
<body>

<!-- Topbar Start -->
<div class="container-fluid py-3 px-lg-5 d-none d-lg-block" style="background-color: #2B2E4A;">
    <div class="row justify-content-end">
        <div class="col-auto">
            <div class="d-inline-flex align-items-center">
                <a class="text-white px-3" href="connexion.php">Sign in</a>
                <span class="text-white">|</span>
                <a class="text-white px-3" href="inscription.php">Inscription</a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid position-relative nav-bar p-0">
    <div class="position-relative px-lg-5" style="z-index: 9;">
        <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0 pl-3 pl-lg-5" style="background-color: #F4F5F8;">
            <a href="" class="navbar-brand">
                <img src="LOGO.png" alt="Logo" width="170px">
            </a>
            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="service.php" class="nav-item nav-link">Services</a>
                    <a href="car.php" class="nav-item nav-link">Cars</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
<h1>administrator</h1>
<!-- Login Form Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="row">
                <div class="col-lg-7 mb-2">
                    <div class="contact-form bg-light mb-4" style="padding: 30px;">
                        <form>
                            <div class="form-group">
                                
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control p-4" placeholder="login" required="required">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control p-4" placeholder="password" required="required">
                            </div>

                            <div>
                                <button class="btn py-3 px-5 text-light" type="submit" style="background-color: #75564d;">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 mb-2">
                    <div class="d-flex flex-column justify-content-center px-5 mb-4" style="height: 435px; background-color: #75564d;">
                        <img src="img/" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
