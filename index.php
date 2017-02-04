<?php
session_start();
require_once('include/sql.php');
require_once('include/functions.php');
if (isset($_GET['section'])) {
    $section = htmlspecialchars($_GET['section']);
    $filename = 'controller/' . $section . '.php';
    if (file_exists($filename)) {
        include($filename);
    } else {
        include('view/404.php');
    }
} else {
    include('controller/index.php');
}