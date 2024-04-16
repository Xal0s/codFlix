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
          if ( !empty( $_POST ) ) signup();
          signupPage();

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
    } else {

        homePage();
    }

endif;


