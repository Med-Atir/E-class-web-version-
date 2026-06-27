<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h1>Bienvenue dans votre platforme d'apprentissage en-ligne</h1>
<div class="container">
    <h2>Inscription</h2>
    <form action="crud_principal/confimation.php" method="POST">
        <input type="text" name="nom" placeholder="Nom complet" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>

    </form>
    <a href="login.php" class="signup">Deja inscrit ? Connexion</a>
    <a href="index.html" class="signup">Revenir a la page d'acceuil</a>
</div>
</body>
</html>