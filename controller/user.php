<?php
require_once 'model/user.php';
if(!$_SESSION['is_connected']) {
    header('Location: ?section=login');
} else {
    if(isset($_GET['action']))
    {
        if ($_GET['action'] === 'disconnect') {
            disconnect_user();
        }
    }
    require_once 'view/user.php';
}