<?php
require_once 'database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST){
        try {
            $db = init_db();
            $stmt = $db->prepare('SELECT * FROM user WHERE email = ?');
            $stmt->execute([$_POST['email']]);
            $result = $stmt->fetch();
            $userPassword = $result['password'];

        }catch (PDOException $e){
            echo $e->getMessage();
        }
        var_dump($result['id']);
        $actualPassword = $_POST['actualPassword'] ?? '';
        if (password_verify($actualPassword, $userPassword)) {
            try {
                $db = init_db();
                $stmt = $db->prepare('UPDATE user SET email = ?, password = ? WHERE id = ?');
                $stmt->execute([$_POST['email'], $_POST['password'], $result['id']]);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Votre profil a été mis à jour'
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Veuillez reessayer plus tard'
                ]);
            }
        }
    }
}