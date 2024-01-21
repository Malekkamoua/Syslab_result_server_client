<?php
    // Start the session
    session_start();
  
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    } else {  
        $message = "";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connexion serveur de résultats | Syslab</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./bootstrap.min.css">  
    <style>
        body {
            background-color: #f8f9fa;
        }

        header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
            position: relative;
        }

        header i {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.5em;
            color: white;
            cursor: pointer;
        }

        nav {
            background-color: #343a40;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #007bff;
        }

        .showcase {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .login-container {
            margin-top: 5%;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border-bottom: none;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px;
        }

        .card-body {
            padding: 40px;
        }

        .btn-login {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #67abf5;
        }
    </style>
</head>

<body>
    <header>
        <h2 id="header-text">Hôpital militaire principal d'instruction de Tunis</h2>
        <i class="fas fa-sign-out-alt" onclick="logout()"></i>
    </header>

    <nav style="display: flex; align-items: center; justify-content: center; background-color: #343a40; padding: 10px; text-align: center">
        <a href="#" onclick="changeLanguage('ar')">AR</a>
        <a href="#" onclick="changeLanguage('fr')">FR</a>
        <a href="#" onclick="changeLanguage('en')">EN</a>
    </nav>

    <div class="showcase">
        <p id="showcase-text">Services des laboratoires de biologies médicales - Serveur de résultats</p>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 login-container">
                <div class="card">
                    <div class="card-header">
                        <h3 id="titreText">Consultez vos résultats</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            echo '<h6 style="color:red;">'. $message .'</h6>';
                        ?>
                        <form action="server.php" method="post">
                            <div class="form-group">
                                <label for="login" id="recuText"><b>N° reçu</b></label>
                                <input type="text" class="form-control" id="recu" name="recu" required>
                            </div>
                            <div class="form-group">
                                <label for="password" id="passwordText"><b>Mot de passe</b></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="login" id="loginText"><b>N° Telephone</b></label>
                                <input type="text" class="form-control" id="login" name="login" required>
                            </div>

                            <button type="submit" class="btn btn-login btn-block" id="cnxText">connexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./jquery-3.7.1.slim.min.js"></script>
    <script src="./bootstrap.min.js"></script>
    <script src="./login_trans.js"></script>
</body>

</html>
