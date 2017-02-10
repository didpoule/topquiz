<?php
include_once 'view/menu.php';
foreach($_SESSION['quiz_done'] as $v) {
    echo 'Quiz numéro : ' . $v. '<br />';
}