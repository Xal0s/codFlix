<?php
require_once 'database.php';
//file that is called when we change users data
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['email'])) {
            $db = init_db();
            $stmt = $db->prepare('SELECT * FROM user WHERE id = ?');
            $stmt->execute([$_POST['id']]);
            $user = $stmt->fetch();

            if ($user) {
                $mail = $_POST['email'];
                @$password = $_POST['password'];
                $actualPassword = $user['password'];
                $tryingPassword = $_POST['actualPassword'];
                $userId = $user['id'];

                // if mail is correct
                if (filter_var($mail, FILTER_VALIDATE_EMAIL))  {
                    // if user is changing his password
                    if (!empty($password)) {
                        //to check if the password is secure
                        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_+=])[A-Za-z\d!@#$%^&*()-_+=]{8,}$/", $_POST['password'])) {
                            $passwordHash = hash('sha256', $password);
                            $stmt = $db->prepare('UPDATE user SET email = ?, password = ? WHERE id = ?');
                            $stmt->execute([$mail, $passwordHash, $userId]);

                            echo json_encode([
                                'status' => 'success',
                                'message' => 'Votre profil a été mis à jour'
                            ]);
                        } else {
                            echo json_encode([
                                'status' => 'error',
                                'message' => 'Votre mot de passe doit contenir un caractère spécial, un chiffre, une minuscule et une majuscule minimum'
                            ]);
                        }
                    }else{
                        echo json_encode([
                            'status' => 'success',
                            'message' => 'Votre adresse mail à bien été changé'
                        ]);
                    }
                    //if users is changing only his mail adress
                    if (empty($password)){
                        $stmt = $db->prepare('UPDATE user SET email = ? WHERE id = ?');
                        $stmt->execute([$mail, $userId]);
                    }

                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'L\'e-mail est incorrect'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Utilisateur non trouvé'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'L\'adresse e-mail est vide'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Méthode de requête non autorisée'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>

