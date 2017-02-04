<?php
$DBHOST = 'localhost';
$DBNAME = '';
$DBUSER = '';
$DBPASS = '';
try {
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );
    $bdd = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS, $options);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}