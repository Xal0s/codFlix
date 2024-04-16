<?php

date_default_timezone_set('Europe/Paris');

require_once( 'controller/homeController.php' );
require_once( 'controller/loginController.php' );
require_once( 'controller/signupController.php' );
require_once( 'controller/mediaController.php' );

/**************************
* ----- HANDLE ACTION -----
***************************/

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

    $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

    if( $user_id ):
        mediaPage();
    else:
        homePage();
    endif;

endif;
