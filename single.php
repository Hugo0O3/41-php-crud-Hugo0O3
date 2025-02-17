<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "connexion.php";

// open the $_SESSION


// check if $_GET is empty
if (empty($_GET["id"])) {
    echo "The id doesn't exist";
    exit;
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    // Interact with the database
    try {
        require_once "connexion.php";
        //1. Prepare the query
        global $db;
        $statement = $db->prepare("select name, image from pokemonTypes where id = :id");

        //2. BindParam
        $statement->bindParam(':id', $id);
        //3. Execute
        $statement->execute();
        //4. Store data in a $variable

        $variable = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // We catch the error from PDO
        echo $e->getMessage();
        exit;
    }
}

// HTML part
include "includes/header.php";

?>


    <h1>Single post</h1>
<?php foreach ($variable as $value) : ?>

    <ul>
        <li>
            <br>
            <h3><?= $value['name'] ?></h3>
            <img src="uploads/<?= $value['image'] ?>" alt="<?= $value['image'] ?>" width="250">
            <br>
        </li>
    </ul>

<?php endforeach; ?>

<?php
include "includes/footer.php";
?>