<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "connexion.php";

if (isset($_POST["submit"])) {

    if (!empty($_POST["name"])) {

        $name = strip_tags($_POST["name"]);
        $image = null;

        if (!empty($_FILES["fileToUpload"]["name"])) {

            $target_dir = "uploads/";
            $file_name = basename($_FILES["fileToUpload"]["name"]);
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $uploadOk = 1;

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            if (file_exists($target_file)) {
                echo "Désolé, ce fichier existe déjà.";
                $uploadOk = 0;
            }

            if ($_FILES["fileToUpload"]["size"] > 20 * 1024 * 1024) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars($file_name) . " has been uploaded.";
                    $image = $file_name;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        try {
            global $db;
            $query = $db->prepare("INSERT INTO pokemonTypes (name, image) VALUES (:name, :image)");
            $query->bindParam(":name", $name, PDO::PARAM_STR);
            $query->bindParam(":image", $image, PDO::PARAM_STR);

            if (!$query->execute()) {
                die("Erreur lors de l'insertion dans la base de données.");
            }

        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
            exit;
        }
        header("location: index.php");
        exit;
    } else {
        echo "Veuillez entrer un nom.";
    }
}

include "includes/header.php";

?>

    <h1>Ajouter un nouveau type</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Nom du type :</label>
        <input type="text" id="name" name="name" required>

        <label for="fileToUpload">Image :</label>
        <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*">

        <button type="submit" name="submit">Ajouter</button>
    </form>

<?php include "includes/footer.php"; ?>