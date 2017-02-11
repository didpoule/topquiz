<?php
require_once 'model/user.php';
if(!$_SESSION['is_connected']) {
    header('Location: ?section=login');
} else {
    if(isset($_GET['action']))
    {
        $action = htmlspecialchars($_GET['action']);
        switch($action):
            case 'disconnect':
                disconnect_user();
                break;
            case 'history':
                $history = getUserQuiz($_SESSION['user_id']);
                if($history['nombre'] > 1) {
                    $history['id_quiz'] = explode(',', $history['id_quiz']);
                    $history['titre'] = explode(',', $history['titre']);
                } else {
                    $history['id_quiz'] = array(0 => $history['id_quiz']);
                    $history['titre'] = array(0 => $history['titre']);
                }
                break;
    }
    require_once 'view/user.php';
}
