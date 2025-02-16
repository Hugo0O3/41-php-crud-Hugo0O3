<?php 


//Remember, when you encode new data to the DB : first sanitize, second filter
//NB: For the password, you have to encrypt it!!


include "includes/header.php";

?>

<h1>User subscription</h1>

    <form method="post" action="">
        <div>
            <label for="login">Login :</label>
            <input type="text" name="login">
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email">
        </div>
        <div>
            <label for="pass">Password :</label>
            <input type="password" name="pass">
        </div>
        <button type="submit">Subscribe</button>
    </form>



<?php
    include "includes/footer.php";
?>