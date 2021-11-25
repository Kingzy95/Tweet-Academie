<?php
	include 'core/init.php';
    if(!empty($getFromU)) {
        if(!($getFromU->loggedIn() !== true)){
            header('Location: home.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sing Up | Twitter</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="stylesheet" href="./assets/css/signUp.css">
    </head>
    <body>

        <img src="assets/images/logo.png" alt="" style="width: 61px; padding-top: 50px; margin-bottom: 20px;">
        <div class="container" id="container">
            <?php include 'includes/inscription.php'; ?>
            <?php include 'includes/login.php'; ?>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>Pour rester connecté, s'il vous plait veuillez utiliser vos informations personnelles!</p>
                        <button class="ghost" id="signIn">Connexion</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Salut mon pote!</h1>
                        <p>Entrez vos informations personnelles et commencez à vous amuser avec nous 🕺</p>
                        <button class="ghost" id="signUp">Inscription</button>
                    </div>
                </div>
            </div>
        </div>

        <footer></footer>

        <script src="assets/js/signUp.js"></script>
    </body>
</html>