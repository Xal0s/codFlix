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
            $user = new User();
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->createUser();

        } else {
            throw new Exception( "L'inscription n'a pas pu aboutir" );
        }
    } catch ( Exception $e ) {
        echo $e->getMessage();
    }

}