<?php
session_start();
if(!isset($_SESSION['is_connected'])) {
    $_SESSION['is_connected'] = 0;
}
require_once('include/sql.php');
require_once('include/functions.php');
require_once('include/user_functions.php');
if (isset($_GET['section'])) {
    $section = htmlspecialchars($_GET['section']);
    $filename = 'controller/' . $section . '.php';
    if (file_exists($filename)) {
        include($filename);
    } else {
        $msg = '<h1>Page non trouvée</h1>';
        header('HTTP/1.0 404 Not Found');
        include('view/404.php');
    }
} elseif(!$_REQUEST != 'section') {
    $msg = '<h1>Page non trouvée</h1>';
    header('HTTP/1.0 404 Not Found');
    include('view/404.php');
} else {
    include('controller/index.php');
}