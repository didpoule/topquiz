<?php
require_once 'modules/user/model/user.php';
if (isset($_GET['action'])) {
    $action = htmlspecialchars($_GET['action']);
    switch ($action):
        case 'connexion':
            user_connect();
            break;
        case 'disconnect':
            user_disconnect();
            break;
        case 'history':
            user_history();
            break;
        case 'view':
            user_viewQuiz();
            break;
    endswitch;
} else {
    if ($_SESSION['is_connected']) {
        require_once 'modules/user/view/user.php';
    } else {
        header('Location: ?section=user&action=connexion');

    }
}
