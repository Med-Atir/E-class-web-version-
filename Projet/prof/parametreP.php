<?php
session_start();
require_once "../config/connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$id_prof = $_SESSION['id'];
$conn = connect_db();

// Récupérer la liste des etudiants par classe pour ce prof
// On fait une requête groupee
$sql_gestion = $conn->prepare("
    SELECT c.id as id_classe, c.nom_classe, u.id as id_etudiant, u.username as nom_etudiant, u.email
    FROM classes c
    INNER JOIN classe_etudiants ce ON c.id = ce.classe_id
    INNER JOIN users u ON ce.etudiant_id = u.id
    WHERE c.id_prof = ?
    ORDER BY c.nom_classe, u.username
");
$sql_gestion->bind_param("i", $id_prof);
$sql_gestion->execute();
$result_gestion = $sql_gestion->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres Professeur</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>

<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_prof.php">Dashboard</a></li>
        <li><a href="gerer_classe.php">Mes Classes</a></li>
        <li><a href="creer_classe.php">Ajouter Classes</a></li>
        <li><a href="questions_prof.php">Questions Reçues</a></li>
        <li><a href="poster_annonce.php" >Poster Annonce</a></li>
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php" class="active">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Paramètres Professeur</h1>
    </header>

    <section class="param-section">
        <h2>Modifier mon profil</h2>
        <form action="../crud_principal/remove.php" method="POST">
            <input type="hidden" name="action" value="update_name">
            <input type="hidden" name="redirect" value="../pages/ParametreP.php">

            <label>Nom d'utilisateur :</label>
            <input type="text" name="nouveau_nom" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
            <button type="submit" class="btn">Enregistrer</button>
        </form>
    </section>

    <section class="param-section">
        <h2>Gerer les étudiants (Retirer d'une classe)</h2>

        <?php if($result_gestion->num_rows > 0):
            $current_class = "";
            while($row = $result_gestion->fetch_assoc()):
                // Si on change de classe, on affiche un nouveau titre
                if($current_class != $row['nom_classe']):
                    $current_class = $row['nom_classe'];
                    echo "<div class='class-header'>Classe : " . htmlspecialchars($current_class) . "</div>";
                endif;
                ?>
                <div class="student-row">
                    <div>
                        <strong><?= htmlspecialchars($row['nom_etudiant']) ?></strong>
                        <span style="color:#777; font-size:0.9em;">(<?= htmlspecialchars($row['email']) ?>)</span>
                    </div>

                    <form action="../crud_principal/remove.php" method="POST" onsubmit="return confirm('Retirer cet etudiant de la classe ?');">
                        <input type="hidden" name="action" value="virer_etudiant">
                        <input type="hidden" name="id_etudiant" value="<?= $row['id_etudiant'] ?>">
                        <input type="hidden" name="id_classe" value="<?= $row['id_classe'] ?>">
                        <button type="submit" class="btn-danger">Retirer</button>
                    </form>
                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucun etudiant inscrit dans vos classes pour le moment.</p>
        <?php endif; ?>
    </section>

    <section class="param-section danger-zone">
        <h2 style="color:red;">Supprimer mon compte</h2>
        <p>Attention : Cela supprimera également toutes vos classes, annonces et devoirs.</p>

        <form action="../crud_principal/remove.php" method="POST" onsubmit="return confirm('Ceci est irreversible. Toutes vos donnees (classes, devoirs, etc.) seront supprimees. Continuer ?');">
            <input type="hidden" name="action" value="delete_account">
            <button type="submit" class="btn-danger" style="padding: 10px 20px;">Supprimer mon compte</button>
        </form>
    </section>

</div>
</body>
</html>