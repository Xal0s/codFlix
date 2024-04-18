<?php
require_once 'database.php';

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

                if (filter_var($mail, FILTER_VALIDATE_EMAIL) && $actualPassword == hash('sha256', $tryingPassword))  {
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
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'L\'e-mail ou le mot de passe est incorrect'
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

