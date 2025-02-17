<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require_once "connexion.php";

// open the $_SESSION


// Interact with the database
try {
    global $db;
    // 1. We can use a direct query, because we admit we will not use data from "outside" (GET or POST)
    $statement = $db->query("select * from pokemonTypes");
    //select * from pokemons

} catch (PDOException $e) {
    // We catch the error from PDO
    echo $e->getMessage();
    exit;
}

// 2. We store the datas from the DB in an Associative Array
$variable = $statement->fetchAll(PDO::FETCH_ASSOC);


include "includes/header.php";
?>

    <!-- The HTML begins here -->
    <main>
        <h1>CRUD</h1>
        <ol>
            <?php
            //display the datas
            foreach ($variable as $value) : ?>

                <li>
                    <a href="single.php?id=<?= $value['id'] ?>">
                        <h3><?= $value['name'] ?></h3>
                    </a>
                </li>

            <?php
            endforeach;
            ?>
        </ol>
        <a href="create.php">Créér un nouveau type</a>

    </main>

<?php
include "includes/footer.php";
?>