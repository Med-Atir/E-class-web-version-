<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_etudiant = $_SESSION['id'];
$conn = connect_db();

/* Récupération des questions de l'étudiant avec le nom du prof */
$sql = $conn->prepare("
    SELECT q.question, q.reponse, u.username as nom_prof 
    FROM questions q
    INNER JOIN users u ON q.id_prof = u.id
    WHERE q.id_etudiant = ?
    ORDER BY q.id DESC
");

$sql->bind_param("i", $id_etudiant);
$sql->execute();
$result = $sql->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Questions</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_etudiant.php">Dashboard</a></li>
        <li><a href="annonces.php">Annonces</a></li>
        <li><a href="mes_classes.php">Mes classes</a></li>
        <li><a href="devoirs.php">Devoirs</a></li>
        <li><a href="poser_question.php">Poser une question</a></li>
        <li><a href="mes_questions.php" class="active">Mes questions</a></li>
        <li><a href="ParametreE.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Suivi de mes questions</h1>
    </header>

    <section class="qa-container">
        <?php if($result->num_rows > 0): ?>

            <?php while($row = $result->fetch_assoc()): ?>
                <div class="qa-card">

                    <div class="qa-header">
                        <span>Envoye a : <strong>Prof. <?= htmlspecialchars($row['nom_prof']) ?></strong></span>

                        <?php if(!empty($row['reponse'])): ?>
                            <span class="status-ok">Repondu</span>
                        <?php else: ?>
                            <span class="status-waiting">En attente</span>
                        <?php endif; ?>
                    </div>

                    <div class="qa-body">
                        <div class="question-text">
                            <?= nl2br(htmlspecialchars($row['question'])) ?>
                        </div>

                        <?php if(!empty($row['reponse'])): ?>
                            <div class="reponse-box">
                                <strong>Reponse du professeur :</strong><br>
                                <?= nl2br(htmlspecialchars($row['reponse'])) ?>
                            </div>
                        <?php else: ?>
                            <p style="color:#777; font-style:italic; font-size:0.9em;">
                                Le professeur n'a pas encore répondu a cette question.
                            </p>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endwhile; ?>

        <?php else: ?>
            <div style="text-align:center; padding:50px;">
                <h3>Vous n'avez pose aucune question.</h3>
                <a href="poser_question.php" class="btn">Poser ma premiere question</a>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>