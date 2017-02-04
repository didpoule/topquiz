<?php
function getQuiz($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT Quiz.nom AS titre, q.contenu AS question, GROUP_CONCAT(r.contenu ORDER BY r.id) AS reponses,  GROUP_CONCAT(r.id ORDER BY r.id) AS reponses_id,
		COUNT(DISTINCT r.id) AS nb_reponses, 
        Quiz.id AS id , q.id as question_id
        FROM Quiz 
        INNER JOIN Question AS q ON q.id_quiz = Quiz.id 
        INNER JOIN Reponse AS r ON r.id_question = q.id 
        WHERE Quiz.id = :quiz
        GROUP BY Quiz.id, titre, question, question_id
        ORDER BY question_id');
    $req->bindParam(':quiz', $id, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}

function getRepId($reponses)
{
    $where = setOrWhere('r.contenu', $reponses);
    $query = 'SELECT r.id AS reponse_id FROM Reponse as r ';
    $query .= $where;
    global $bdd;
    $req = $bdd->prepare($query);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}

function getBonnesReponses($idQuiz)
{
    $query = 'SELECT q.id AS question_id, r.id AS reponse_id, r.contenu AS contenu FROM Reponse AS r
              INNER JOIN Question AS q
                ON q.id_bonne_reponse = r.id
              INNER JOIN Quiz
                ON q.id_quiz = Quiz.id
              WHERE Quiz.id = :quiz_id';
    global $bdd;
    $req = $bdd->prepare($query);
    $req->bindParam(':quiz_id', $idQuiz, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}