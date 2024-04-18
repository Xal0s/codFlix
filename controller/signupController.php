<?php

require_once( 'model/user.php' );

/****************************
* ----- LOAD SIGNUP PAGE -----
****************************/

function signupPage() {

    $user     = new stdClass();
    $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

    if( !$user->id ):
        require('view/auth/signupView.php');
    else:
        require('view/movieListView.php');
    endif;

}

/***************************
* ----- SIGNUP FUNCTION -----
***************************/


function signup() {
    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]{8,}$/", $_POST['password'])) {
                $user = new User();
                $user->setEmail($_POST['email']);
                $user->setPassword($_POST['password']);
                $user->createUser();
            } else {
                throw new Exception("Le mot de passe doit contenir un caractère spécial, un chiffre, une majuscule et une minuscule minimum.");
            }
        } else {
            throw new Exception( "L'inscription n'a pas pu aboutir" );
        }
    } catch ( Exception $e ) {
        $error_msg = $e->getMessage();
    }
    require('view/auth/signupView.php');

}