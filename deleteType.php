<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "connexion.php";

if (empty($_GET["id"])) {
    echo "L'ID n'existe pas.";
    exit;
}

$id = $_GET['id'];
global $db;

if (isset($_POST["delete"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    $query = $db->prepare("SELECT image FROM pokemonTypes WHERE id = :id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    $type = $query->fetch(PDO::FETCH_ASSOC);

    if (!$type) {
        echo "Type non trouvé.";
        exit;
    }

    if (!empty($type["image"])) {
        $imagePath = "uploads/" . $type["image"];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $query = $db->prepare("DELETE FROM pokemonTypes WHERE id = :id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);

    if ($query->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erreur lors de la suppression.";
    }
}

$query = $db->prepare("SELECT id, name, image FROM pokemonTypes WHERE id = :id");
$query->bindParam(":id", $id, PDO::PARAM_INT);
$query->execute();
$type = $query->fetch(PDO::FETCH_ASSOC);

if (!$type) {
    echo "Type non trouvé.";
    exit;
}

include "includes/header.php";

?>

    <p>Type : <?= htmlspecialchars($type['name']) ?></p>
<?php if (!empty($type['image'])): ?>
    <img src="uploads/<?= htmlspecialchars($type['image']) ?>" alt="<?= htmlspecialchars($type['name']) ?>" width="250">
<?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($type['id']) ?>">
        <button type="submit" name="delete">Supprimer ce type</button>
    </form>

    <a href="index.php">Retour à la liste</a>

<?php
include "includes/footer.php";
?>