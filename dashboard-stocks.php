<?php
    session_start();
    include_once('util_functions.php');
    try {
        if (isset($_POST['submitted'])) {// the page is called from the login form, we proceed to check the crendentials 
            processLogin($_POST);
        }
        if (isset($_SESSION["auth"]) && $_SESSION["auth"]=="admin" ) {// the admin is properly connected
            show_data();
        }
        else {
            login(); //we redirect to login form
        }
    } catch (\Throwable $th) {
        echo 'Une erreur est subvenue lors du chargement de la page. Veuillez contacter le webmaster' . $th ; //"an error occured" in french
    }
    

?>