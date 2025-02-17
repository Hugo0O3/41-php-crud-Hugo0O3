<?php


if (!empty($_POST['email']) &&
    !empty($_POST['password'])) {

    // 1. Check all the inputs exist
    // 2. We check also if the $_POST are not empty because we load the page, the form is empty
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            //Sanitize the inputs
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);


            //SQL part
            try {
                require_once "connexion.php";
                //1. Prepare the query


                //2. BindParam

                //3. Execute

                //4. Store the datas in a variable

                //5. check the password input with the password in db


            } catch (PDOException $e) {

            }

            // store data of user in $_SESSION


        }
    }
}

include "includes/header.php";

?>

    <h1>User Login</h1>

    <form method="post" action="">
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email">
        </div>
        <div>
            <label for="pass">Password</label>
            <input type="password" name="pass">
        </div>
        <button type="submit">Login</button>
    </form>


<?php
include "includes/footer.php";
?>