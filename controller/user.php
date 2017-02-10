<?php
require_once 'model/user.php';
if(!$_SESSION['is_connected']) {
    header('Location: ?section=login');
} else {
    require_once 'view/user.php';
}