<?php
function getQuiz($id)
{
    global $bdd;

    $req = $bdd->prepare( 'SELECT Quiz.nom AS titre, q.contenu AS question, GROUP_CONCAT(r.contenu ORDER BY r.id) AS reponses, 
                                    COUNT(DISTINCT q.id) AS nb_questions, COUNT(DISTINCT r.id) AS nb_reponses
                                    FROM Quiz 
                                    INNER JOIN Question AS q ON q.id_quiz = Quiz.id
                                    INNER JOIN Reponse AS r ON r.id_question = q.id
                                    WHERE Quiz.id = :quiz
                                    GROUP BY titre, question WITH ROLLUP
                                    ');
    $req->bindParam(':quiz', $id, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}