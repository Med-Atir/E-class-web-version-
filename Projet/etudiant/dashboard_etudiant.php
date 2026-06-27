<?php
session_start();
if(!isset($_SESSION['username'])){
header("Location: ../login.php");
}
$nom = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Etudiant</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>
<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_etudiant.php" class="active">Dashboard</a></li>
        <li><a href="annonces.php">Annonces</a></li>
        <li><a href="mes_classes.php">Mes classes</a></li>
        <li><a href="devoirs.php">Devoirs</a></li>
        <li><a href="poser_question.php">Poser une question</a></li>
        <li><a href="mes_questions.php">Mes questions</a></li>
        <li><a href="ParametreE.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Salut <?php echo "$nom"?></h1>
        <form action="../crud_principal/logout.php" method="POST">
            <button class="logout-btn" type="submit" name="deconnection">Deconnexion</button>
        </form>
    </header>

    <section class="cards">

        <div class="card">
            <h3>Annonces</h3>
            <p>Dernieres annonces du professeur.</p>
            <a href="annonces.php" class="btn">Lire</a>
        </div>

        <div class="card">
            <h3>Mes Classes</h3>
            <p>Voir toutes les classes et rejoindre.</p>
            <a href="mes_classes.php" class="btn">Acceder</a>
        </div>

        <div class="card">
            <h3>Devoirs</h3>
            <p>Consulter les devoirs en attente.</p>
            <a href="devoirs.php" class="btn">Voir Devoirs</a>
        </div>

        <div class="card">
            <h3>Poser une question</h3>
            <p>Envoyer une question au professeur.</p>
            <a href="poser_question.php" class="btn">Poser</a>
        </div>
        <div class="card">
            <h3>Suivre mes questions</h3>
            <p>Voir les reponses du professeurs.</p>
            <a href="mes_question.php" class="btn">Suivre</a>
        </div>
        <div class="card">
            <h3>Parametres</h3>
            <p>Gerer mon compte.</p>
            <a href="ParametreE.php" class="btn">Parametres</a>
        </div>
    </section>
</div>
</body>
</html>