<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
<h1>Bienvenue dans votre platforme d'apprentissage en-ligne</h1>
<div class="container">
    <h2>Connexion</h2>
    <form action="crud_principal/login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <?php
        session_start();
        if(isset($_SESSION['error'])){
            echo"<p style = color:red>".$_SESSION['error'] ."</p>";
            unset($_SESSION['error']);
        }
        ?>
        <button type="submit">Se connecter</button>
    </form>
    <a href="signup.php" class="signup">Creer un compte</a>
    <a href="index.html" class="signup">Revenir a la page d'acceuil</a>
</div>
</body>
</html>