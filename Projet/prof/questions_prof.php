<?php
session_start();
require_once "../config/connect.php";

// Vérification : est-ce un prof connecté ?
if (!isset($_SESSION['id']) /* Ajouter ici une vérif si c'est bien un prof, ex: || $_SESSION['role'] != 'prof' */) {
    header("Location: ../login.php");
    exit();
}

$id_prof = $_SESSION['id'];
$conn = connect_db();

/* =========================================
   RÉCUPÉRATION DES QUESTIONS
   (On joint la table users pour avoir le nom de l'étudiant)
========================================= */
$sql = $conn->prepare("
    SELECT q.id, q.question, q.reponse, u.username as nom_etudiant 
    FROM questions q
    INNER JOIN users u ON q.id_etudiant = u.id
    WHERE q.id_prof = ?
    ORDER BY q.id DESC
");
$sql->bind_param("i", $id_prof);
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Questions reçues</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_prof.php">Dashboard</a></li>
        <li><a href="gerer_classe.php">Mes Classes</a></li>
        <li><a href="creer_classe.php">Ajouter Classes</a></li>
        <li><a href="questions_prof.php" class="active">Questions Reçues</a></li>
        <li><a href="poster_annonce.php" >Poster Annonce</a></li>
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Questions des étudiants</h1>
    </header>

    <section>
        <?php if($result->num_rows > 0): ?>

            <?php while($row = $result->fetch_assoc()): ?>
                <div class="question-card <?= !empty($row['reponse']) ? 'repondu' : '' ?>">

                    <div class="etudiant-info">
                        <span>👤 <?= htmlspecialchars($row['nom_etudiant']) ?></span>

                        <?php if(empty($row['reponse'])): ?>
                            <span class="badge bg-warning">En attente</span>
                        <?php else: ?>
                            <span class="badge bg-success">Répondu</span>
                        <?php endif; ?>
                    </div>

                    <div class="text-question">
                        <strong>Q : </strong> <?= nl2br(htmlspecialchars($row['question'])) ?>
                    </div>

                    <?php if(empty($row['reponse'])): ?>
                        <form action="../crud_secondaire/repondre_question.php" method="POST">
                            <textarea name="reponse" rows="3" placeholder="Écrire votre réponse ici..." required></textarea>
                            <input type="hidden" name="id_question" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn">Envoyer la réponse</button>
                        </form>

                    <?php else: ?>
                        <div class="box-reponse">
                            <strong>Votre réponse :</strong><br>
                            <?= nl2br(htmlspecialchars($row['reponse'])) ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endwhile; ?>

        <?php else: ?>
            <p>Aucune question pour le moment.</p>
        <?php endif; ?>
    </section>
</div>

</body>
</html>