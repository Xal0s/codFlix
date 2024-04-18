<?php

date_default_timezone_set('Europe/Paris');

require_once( 'controller/homeController.php' );
require_once( 'controller/loginController.php' );
require_once( 'controller/signupController.php' );
require_once( 'controller/mediaController.php' );

/***************************
 * ----- HANDLE MEDIA -----*
 ***************************/
//if media is set in url we send users on detailed media page
if (isset( $_GET['movie'] ) ){
    moviePage();
} elseif (isset( $_GET['serie'])){
    seriePage();
}

if (isset($_GET['validate'])) {
    $user = User::findByToken($_GET['validate']);
    if ($user) {
        User::activateUser();;
        loginPage();
        exit();
    } else {
        // Gérer le cas où le token n'est pas valide
        // Redirection vers une page d'erreur ou affichage d'un message
        exit();
    }
} else {
    // Gérer le cas où aucun token n'est fourni dans l'URL
    // Redirection vers une page d'erreur ou affichage d'un message
}


/**************************
* ----- HANDLE ACTION -----
***************************/
//if action is set in url we send users on pages he asked
if ( isset( $_GET['action'] ) ):

    switch( $_GET['action']):

        case 'login':
            // if not connected, redirecting user to loginPage
            if ( !empty( $_POST ) ) login( $_POST );
            else loginPage();

        break;

        case 'signup':
            // if sign up form has been completed we add new user to database
            if (!empty( $_POST )){
                signup();
                loginPage();
            }
            else {
                signupPage();
            }

        break;

        case 'logout':
            logout();
            break;

    endswitch;

else:

    $user_id = $_SESSION['user_id'] ?? false;

    if( $user_id && isset($_GET['films'])){
        allMoviesPage();

    } else if (isset( $_GET['series'])) {
        //if user clicks on series in dashboard we send him in a view of series
        allSeriesPage();
    } else if (isset( $_GET['profil'])) {

        profilPage();

    } else {

        homePage();
    }

endif;


