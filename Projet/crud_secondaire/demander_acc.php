<?php
require_once "../config/connect.php";

function demande_class($id, $code){
    $conn = connect_db();
    $check = $conn->prepare("
        SELECT id 
        FROM demandes 
        WHERE id_etudiant = ? AND code_classe = ?
    ");
    $check->bind_param("is", $id, $code);
    $check->execute();
    $result = $check->get_result();
    if($result->num_rows > 0){
        return "existe";
    }
    $stmt = $conn->prepare("
        INSERT INTO demandes (id_etudiant, code_classe, statut)
        VALUES (?, ?, 'en_attente')
    ");
    $stmt->bind_param("is", $id, $code);
    if($stmt->execute()){
        return "ok";
    } else {
        return "erreur";
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $resultat = demande_class($id, $code);
    if ($resultat == "ok") {
        $_SESSION['acces'] = 'Demande a ete evoyer avec succes';
        header("Location: ../etudiant/mes_classes.php");
        exit();
    }
    elseif ($resultat == "existe"){
        $_SESSION['existe'] = 'Tu es deja inscri dans cette classe';
    }
    else {
        $_SESSION['noacces'] = 'Error veuillez ressayer plus tard';
        header("Location: ../etudiant/mes_classes.php");
        exit();
    }
}
?>