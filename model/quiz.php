<?php
function getQuiz($id)
{
    global $bdd;
    $req= $bdd->prepare('SELECT Quiz.nom AS titre, q.contenu AS question, GROUP_CONCAT(r.contenu ORDER BY r.id) AS reponses, 
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
function getRepId($reponse)
{
    global $bdd;
    $req = $bdd->prepare('SELECT r.id AS reponse_id FROM Reponse AS r
                                   WHERE r.contenu = :reponse');
    $req->bindParam(':reponse', $reponse);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['reponse_id'];
}

function getBonneReponse($idQuestion)
{
    global $bdd;
    $req = $bdd->prepare('SELECT r.id AS reponse_id FROM Question AS q 
                                    INNER JOIN Reponse AS r 
                                    ON q.id_bonne_reponse = r.id
                                    WHERE q.id = :question_id');
    $req->bindParam(':question_id', $idQuestion, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['reponse_id'];
}