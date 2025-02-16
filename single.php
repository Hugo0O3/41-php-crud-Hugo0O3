<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "connexion.php";

// open the $_SESSION


// check if $_GET is empty
if(empty($_GET["id"])) {
  echo "The id doesn't exist";
  exit;
}

if(isset($_GET['id'])) {

  // Interact with the database
  try {
    require_once "connexion.php";
    //1. Prepare the query
    $statement = $db->prepare("//Your query here");

    //2. BindParam

    //3. Execute

    //4. Store data in a $variable

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




<?php
    include "includes/footer.php";
?>
