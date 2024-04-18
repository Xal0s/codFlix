<?php
require_once 'database.php';
//function called when user wants to delete his account
try{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $db = init_db();
        $stmt = $db->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: index.php?action=login');
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Votre mot de passe doit contenir un caractère spécial, un chiffre, une minuscule et une majuscule minimum'
        ]);
    }


} catch (exception $e){
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}