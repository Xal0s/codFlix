<?php
require_once( 'database.php' );
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
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'key' => $key
            ));

            // Close databse connection
            $db = null;
            $this->sendConfirmationInscription($this->getEmail(),$key);

        } catch (Exception $e) {
            echo $e->getMessage();

        }


    }


    public function sendConfirmationInscription($to, $key) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'coflix@gmail.com';                     //SMTP username
            $mail->Password   = 'secret';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('coflix@gmail.com', 'Mailer');
            $mail->addAddress($to);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Conformation de votre inscription';
            $mail->Body    = 'Pour confirmer votre inscription veuillez cliquer sur ce lien' . $key;

            $mail->send();
            echo 'Un mail à été envoyé';
        } catch (Exception $e) {
            echo "Le mail n'est pas parti. Erreur: {$mail->ErrorInfo}";
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

}
