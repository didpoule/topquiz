<?php
// Get all available quiz
function getListeQuiz()
{
    global $bdd;
    $req = $bdd->prepare('SELECT id, Quiz.nom as titre FROM Quiz;');
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}