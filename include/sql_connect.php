<?php
$DBHOST = 'localhost';
$DBNAME = 'topquiz';
$DBUSER = 'root';
try {
    $bdd = new PDO("mysql:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $setUTF = 'SET CHARACTER SET UTF8;';
    $query = $bdd->prepare($setUTF);
    $query->execute();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}