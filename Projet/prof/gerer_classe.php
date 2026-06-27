<?php
session_start();
// Vérification de sécurité : si pas connecté, redirection
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Adaptez le chemin si besoin
    exit();
}
$id = $_SESSION['id'];
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerer vos Classes</title>
    <link rel="stylesheet" href="../assets/global.css">
</head>
<body>
<div class="sidebar">
    <h2>E-Class</h2>
    <ul>
        <li><a href="dashboard_prof.php">Dashboard</a></li>
        <li><a href="gerer_classe.php" class="active">Mes Classes</a></li>
        <li><a href="creer_classe.php">Ajouter Classes</a></li>
        <li><a href="questions_prof.php">Questions Reçues</a></li>
        <li><a href="poster_annonce.php" >Poster Annonce</a></li>
        <li><a href="upload_cours.php">Ajouter un cours</a></li>
        <li><a href="ajouter_devoir.php">Donner Devoir</a></li>
        <li><a href="parametreP.php">Parametres</a></li>
    </ul>
</div>

<div class="main">
    <header>
        <h1>Gerer vos classes</h1>
    </header>

    <?php
    if(isset($_SESSION['message_action'])){
        $type = (isset($_SESSION['type_message']) && $_SESSION['type_message'] == 'green') ? 'notif-green' : 'notif-red';
        echo "<div class='notification $type'>";
        echo $_SESSION['message_action'];
        echo "</div>";
        unset($_SESSION['message_action']);
        unset($_SESSION['type_message']);
    }
    ?>

    <section>
        <div class="card">
            <h3>Mes Classes Actuelles</h3>

            <?php
            if(isset($_SESSION['mesclass'])){
                echo "<ul style='background:#f9f9f9; padding:15px; border-radius:5px; list-style:none;'>";

                foreach($_SESSION['mesclass'] as $classe){
                    // Pour éviter les erreurs, on vérifie si l'ID existe, sinon on met 0
                    $classe_id = isset($classe['id']) ? $classe['id'] : (isset($classe['id_classe']) ? $classe['id_classe'] : 0);

                    echo "<li style='margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:10px;'>";
                    echo "<strong style='font-size:1.1em;'>" . $classe['nom_classe'] . "</strong> ";
                    echo "<span style='color:#0056b3; background:#e7f1ff; padding:2px 6px; border-radius:4px; font-size:0.9em;'>Code : ".$classe['code_classe']."</span>";
                    echo "<br>";
                    echo "<span style='color:#666;'>Description : ".$classe['description']."</span>";
                    echo "<br>";
                    echo "<span style='color:#666;'>Nombre d'étudiants : <strong>".$classe['nbr_etudiant']."</strong></span>";

                    // --- Bouton Supprimer ---
                    // Correction ici : On utilise des simples quotes pour le HTML et la concaténation PHP
                    echo "<form action='../crud_secondaire/delete_class.php' method='POST' onsubmit=\"return confirm('Êtes-vous sûr de vouloir supprimer cette classe ? Tout le contenu (devoirs, annonces...) sera effacé définitivement.');\">";
                    echo "<input type='hidden' name='id_classe' value='" . $classe_id . "'>";
                    echo "<button type='submit' class='action-btn btn-delete'>Supprimer la classe</button>";
                    echo "</form>";

                    echo "</li>";
                }

                echo "</ul>";
                unset($_SESSION['mesclass']);
            }

            if(isset($_SESSION['noclass'])){
                echo "<p style='color:red; font-style:italic;'>".$_SESSION['noclass'] ."</p>";
                unset($_SESSION['noclass']);
            }
            ?>

            <form method="POST" action="../crud_secondaire/add_class.php" style="margin-top:15px;">
                <input type="hidden" name="action" value="afficher">
                <input type="hidden" name="id_prof" value="<?php echo "$id"?>">
                <button type="submit" class="btn">Actualiser mes classes</button>
            </form>
        </div>
    </section>

    <div class="card">
        <h3>Demandes d'adhésion</h3>

        <?php
        if(isset($_SESSION['demandes'])) {
            $demandes = $_SESSION['demandes'];

            if(empty($demandes)) {
                echo "<p>Aucune demande en attente.</p>";
            } else {
                echo "<ul style='background:#f9f9f9; padding:15px; border-radius:5px; list-style:none;'>";
                foreach ($demandes as $data) {
                    echo "<li style='margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:15px;'>";

                    echo "<div style='margin-bottom:10px;'>";
                    echo "<span style='color:#555;'>Étudiant : </span> <strong style='color:#0056b3;'>". $data['nom_etudiant'] . "</strong> (ID: " . $data['id_etudiant'] . ")<br>";
                    echo "<span style='color:#555;'>Module : </span> <strong>". $data['nom_module'] . "</strong><br>";
                    echo "<span style='color:#555;'>État : </span> <span style='color:orange;'>". $data['statut'] . "</span>";
                    echo "</div>";

                    echo "<div style='display:flex; gap: 10px;'>";

                    // Formulaire Accepter
                    echo "<form action='../crud_secondaire/join_class.php' method='POST'>";
                    echo "<input type='hidden' name='id' value='".$data['id_etudiant']."'>";
                    echo "<input type='hidden' name='code' value='".$data['code_module']."'>";
                    echo "<button type='submit' class='action-btn btn-accept'>Accepter</button>";
                    echo "</form>";

                    // Formulaire Refuser
                    echo "<form action='../crud_secondaire/refuser_class.php' method='POST'>";
                    echo "<input type='hidden' name='id' value='".$data['id_etudiant']."'>";
                    echo "<input type='hidden' name='code' value='".$data['code_module']."'>";
                    echo "<button type='submit' class='action-btn btn-refuse'>Refuser</button>";
                    echo "</form>";

                    echo "</div>";
                    echo "</li>";
                }
                echo "</ul>";
            }
            unset($_SESSION['demandes']);
        } else {
            echo "<p style='color:gray;'>Cliquez ci-dessous pour voir les demandes.</p>";
        }
        ?>

        <form method="POST" action="../crud_secondaire/afficher_demande.php" style="margin-top:15px;">
            <input type="hidden" name="id_prof" value="<?php echo "$id"?>">
            <button type="submit" class="btn">Voir mes demandes</button>
        </form>
    </div>
</div>
</body>
</html>