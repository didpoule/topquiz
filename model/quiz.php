<?php
function getQuiz($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT Quiz.id AS id, Quiz.nom AS titre, q.contenu AS question, GROUP_CONCAT(DISTINCT(r.contenu) ORDER BY r.id) AS reponses,  
		GROUP_CONCAT(DISTINCT(r.id) ORDER BY r.id) AS reponses_id,
		COUNT(DISTINCT r.id) AS nb_reponses, 
        q.id as question_id,
        q.type AS question_type
       	FROM lnk_Question_Reponse AS lnk
        INNER JOIN Question AS q 
        	ON q.id = lnk.id_question 
        INNER JOIN Quiz
        	ON q.id_quiz = Quiz.id
        INNER JOIN Reponse AS r 
        	ON r.id_question = q.id 
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
    $query = 'SELECT q.id AS question_id, q.type AS type, GROUP_CONCAT(r.id) AS reponse_id, GROUP_CONCAT(r.contenu) AS contenu
              FROM lnk_Question_Reponse AS lqr
              INNER JOIN Question AS q 
                ON lqr.id_question = q.id
              INNER JOIN Reponse AS r 
                ON lqr.id_reponse = r.id      
              WHERE q.id_quiz = :quiz_id AND lqr.reponse_juste = 1
              GROUP BY question_id, type';
    global $bdd;
    $req = $bdd->prepare($query);
    $req->bindParam(':quiz_id', $idQuiz, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}