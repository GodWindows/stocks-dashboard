<?php
    /*this funtion check the validity of the credentials the user typed
    $invalidCredentialsErrorMessage, $adminPseudo and $adminPassword are environment variables defined in the env_variables.php file*/
    function processLogin($data)  {
        include('env_variables.php');
        if (isset($data['name']) && isset($data['password'])) {
            if ($data['name']==$adminPseudo && $data['password']==$adminPassword) {
                $_SESSION["auth"]="admin"; //to tell the system that the user is connected
            }
            else {
                $_SESSION["error"] = $invalidCredentialsErrorMessage; // $invalidCredentialsErrorMessage is a string telling the user that his credentials are invalid. 
            }
        }
    }

    /*this funtion displays the login form for the admin*/
    function login() {
        include('login.php');
    }

    function show_data() {
        include('data.php');
    }




?>