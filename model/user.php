<?php
require_once( 'database.php' );
//PHP mailer lib is imported to send mail even in local 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class User
{

    protected $id;
    protected $email;
    protected $password;

    public function __construct($user = null)
    {

        if ($user != null):
            $this->setId(isset($user->id) ? $user->id : null);
            $this->setEmail($user->email);
            $this->setPassword($user->password, isset($user->password_confirm) ? $user->password_confirm : false);
        endif;
    }

    /***************************
     * -------- SETTERS ---------
     ***************************/

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
            throw new Exception('Email incorrect');
        endif;

        $this->email = $email;

    }

    public function setPassword($password, $password_confirm = false)
    {

        if ($password_confirm && $password != $password_confirm):
            throw new Exception('Vos mots de passes sont différents');
        endif;

        $this->password = hash("sha256", $password);
    }

    /***************************
     * -------- GETTERS ---------
     ***************************/

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /***********************************
     * -------- CREATE NEW USER ---------
     ************************************/

    public function createUser()
    {
        try {
            // Open database connection
            $db = init_db();


            // Check if email already exist
            $req = $db->prepare("SELECT * FROM user WHERE email = ?");
            $req->execute(array($this->getEmail()));

            if ($req->rowCount() > 0) {
                throw new Exception("Cette adresse mail est déja rattaché à un compte");
            }
            $key = uniqid();
            $req->closeCursor();
            // Insert new user
            $req = $db->prepare("INSERT INTO user ( email, password, account_activation_token ) VALUES ( ?, ?, ? )");
            $req->execute(array(
                $this->getEmail(),
                $this->getPassword(),
                $key
            ));

            // Close databse connection
            $db = null;
            $this->sendConfirmationInscription($this->getEmail(),$key);

        } catch (Exception $e) {
            $error_msg = $e->getMessage();

        }
        require ('view/auth/signupView.php');
    }


    public function sendConfirmationInscription($to, $key) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'codflix.confirmation@gmail.com';                     //SMTP username
            $mail->Password   = 'boti fxcz jhpj nvaj';                             //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('codflix.confirmation@gmail.com', "Cod'Flix");
            $mail->addAddress($to);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Confirmation de votre inscription sur Cod'Flix";
            $mail->Body    = '<p>Pour confirmer votre inscription, veuillez cliquer <a href="http://localhost/codFlix/index.php?validate='. $key.'">ici</a>';

            $mail->send();
            echo '<div class="alert alert-success" role="alert">Mail envoyé !</div>';
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">Le mail n\'a pas pu s\'envoyer !</div>';
        }
    }

    /**************************************
    * -------- GET USER DATA BY ID --------
    ***************************************/

    public static function getUserById( $id ) {

        // Open database connection
        $db   = init_db();

        $req  = $db->prepare( "SELECT * FROM user WHERE id = ?" );
        $req->execute( array( $id ));

        // Close databse connection
        $db   = null;

        return $req->fetch();
    }

    /***************************************
    * ------- GET USER DATA BY EMAIL -------
    ****************************************/
    public function getUserByEmail() {

        // Open database connection
        $db   = init_db();

        $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
        $req->execute( array( $this->getEmail() ));

        // Close databse connection
        $db   = null;

        return $req->fetch();
    }
    //update in database account_activation_token to grant users access to the website
    public static function activateUser() {
        try {
            // Valider le token d'activation
            $token = isset($_GET['validate']) ? $_GET['validate'] : null;
            if (!$token) {
                throw new Exception("Token d'activation manquant dans l'URL");
            }

            // Mettre à jour le champ is_activated dans la base de données
            $db = init_db();
            $req = $db->prepare("UPDATE user SET is_activated = ? WHERE account_activation_token = ?");
            $success = $req->execute([true, $token]);

            // Vérifier si la mise à jour a réussi
            if (!$success) {
                throw new Exception("Échec de l'activation de l'utilisateur");
            }

            // Rediriger l'utilisateur vers une page de confirmation ou de connexion
            loginPage();
            exit();
        } catch (Exception $e) {
            // Gérer l'erreur de manière appropriée (affichage d'un message d'erreur, journalisation, etc.)
            echo "Erreur : " . $e->getMessage();
        }
    }
    //find user by its token for activate his account
    public static function findByToken($token) {
        // Écrire la requête SQL pour rechercher l'utilisateur par token
        $db = init_db();
        $req = $db->prepare("SELECT * FROM user WHERE user.account_activation_token = ?");
        $req->execute([$token]);
        $user = $req->fetch(PDO::FETCH_ASSOC);
        $db = null;

        // Retourner l'utilisateur trouvé ou null s'il n'est pas trouvé
        return $user;
    }

}
