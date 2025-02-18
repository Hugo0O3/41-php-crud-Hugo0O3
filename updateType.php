<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "connexion.php";

$id = isset($_GET["id"]) ? ($_GET["id"]) : null;
$name = "";
$image = null;
global $db;

if ($id) {
    $query = $db->prepare("SELECT name, image FROM pokemonTypes WHERE id = :id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    $type = $query->fetch(PDO::FETCH_ASSOC);

    if ($type) {
        $name = $type["name"];
        $image = $type["image"];
    } else {
        echo "Type not found.";
        exit;
    }
}

if (isset($_POST["submit"])) {
    if (!empty($_POST["name"])) {
        $newName = strip_tags($_POST["name"]);
        $newImage = $image;

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

                    if ($image && file_exists($target_dir . $image)) {
                        unlink($target_dir . $image);
                    }

                    $newImage = $file_name;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        try {
            global $db;
            $query = $db->prepare("UPDATE pokemonTypes SET name = :name, image = :image WHERE id = :id");
            $query->bindParam(":name", $newName, PDO::PARAM_STR);
            $query->bindParam(":image", $newImage, PDO::PARAM_STR);
            $query->bindParam(":id", $id, PDO::PARAM_INT);

            if (!$query->execute()) {
                die("Error while updating.");
            }

        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage();
            exit;
        }

        header("Location: index.php");
        exit;
    } else {
        echo "Veuillez entrer un nom.";
    }
}

include "includes/header.php";
?>

    <h1>Update Type</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Type Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>

        <label for="fileToUpload">Image:</label>
        <?php if ($image): ?>
            <p>Current image:</p>
            <img src="uploads/<?= htmlspecialchars($image) ?>" alt="Type image" width="100">
        <?php endif; ?>
        <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*">

        <button type="submit" name="submit">Update</button>
    </form>

<?php include "includes/footer.php"; ?>