<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// open the $_SESSION

// 1. Check all the inputs exist
// 2. We check also if the $_POST are not empty because we load the page, the form is empty
if(isset($_POST["..."])
    && !empty($_POST["..."]) ) {

    //Sanitize the inputs
    $variable = strip_tags($_POST["..."]);

    //SQL part
    try {
      require_once "connexion.php";

      //1. We prepare the request, because we will use user input
      // By doing that we protect against SQL injection
      $query = $db->prepare("INSERT INTO ...");
      
      //2. To ensure safe and secure database interactions by preventing SQL injection, use bindParam()
      // bindParam() only accepts a variable that is interpreted at the time of execute()
      // NB: I prefer bindParam() to bindValue(), because you can define parameter types. 
      $query->bindParam(":parameter_name", $variable, PDO::PARAM_TYPE);
      
      //3. We execute the query. execute() return a boolean
      // NB: with the code below, we implicitly execute the query
      if(!$q->execute()) {
        die("The form was not sent to the db");
      }
      
    } catch (PDOException $e) {
      // We catch the error from PDO
      echo $e->getMessage();
      exit;
    }
      
    //4. Once is done, redirect to the index.php
    header("location: index.php");
    exit;

}


// HTML part
include "includes/header.php";

?>


<h1>Create</h1>

    <form method="post" action="">


    </form>



<?php
    include "includes/footer.php";
?>
