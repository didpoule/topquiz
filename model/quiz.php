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
        GROUP BY Quiz.id, titre, question, question_id');
    $req->bindParam(':quiz', $id, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}
function checkReponse($idQuestion, $reponse)
{
    global $bdd;
    $req = $bdd->prepare('SELECT r.contenu FROM Reponse AS r
                                    INNER JOIN Question as q
                                    ON id_bonne_reponse = r.id
                                    WHERE q.id = :question_id AND r.contenu = :reponse');
    $req->bindParam(':question_id', $idQuestion, PDO::PARAM_INT);
    $req->bindParam(':reponse', $reponse);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees;
}