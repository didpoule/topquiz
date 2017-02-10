<?php
require_once 'model/user.php';
if (!isset($_SESSION['is_connected'])) {
    if(isset($_POST['connexion'])) {
        if(empty($_POST['login']) || empty($_POST['password'])) {
            $msg = ('Veuillez remplir tous les champs');
        } else {
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            if(checkLogin($login, $password)) {
                $_SESSION['user_id'] = getUserId($login);
                $_SESSION['user_pseudo'] = getUserPseudo($_SESSION['user_id']);
                $_SESSION['quiz_done'] = explode(',', getUserQuiz($_SESSION['user_id']));
                $_SESSION['is_connected'] = 1;
                header('Location: ?section=user');
            }
        }
    }
    require_once 'view/login.php';
} else {
    header('Location: ?section=user');
}
