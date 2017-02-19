<?php
/**
 * @param $id // Id of quiz to get
 * @return array
 * This function gets an array contents all data of a quiz by its id
 */
function getQuiz($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT Quiz.id AS id, Quiz.nom AS titre, q.contenu AS question, GROUP_CONCAT(DISTINCT(r.contenu) ORDER BY lnq.ordre_reponse ASC) AS reponses,   
    GROUP_CONCAT(DISTINCT(r.id)ORDER BY lnq.ordre_reponse ASC) AS reponses_id,
		COUNT(DISTINCT r.id) AS nb_reponses, 
        q.id AS question_id,
        q.type AS question_type,
        (SELECT COUNT(id) FROM Question WHERE id_quiz = :quiz)
       	FROM lnk_Question_Reponse AS lnk
        INNER JOIN Question AS q 
        	ON q.id = lnk.id_question 
        INNER JOIN Quiz
        	ON q.id_quiz = Quiz.id
        INNER JOIN Reponse AS r 
        	ON r.id_question = q.id
        INNER JOIN lnk_Question_Reponse AS lnq
        	ON r.id = lnq.id_reponse
        WHERE Quiz.id = :quiz
        GROUP BY Quiz.id, titre, question, question_id
        ORDER BY question_id');
    $req->bindParam(':quiz', $id, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}

/**
 * @param $reponses // Answers to get ids
 * @return array
 * This functions returns ids of $reponses sent in
 */
function getRepId($reponses)
{
    $where = setOrWhere('r.contenu', $reponses);
    $query = 'SELECT r.id_question,  GROUP_CONCAT(r.id ORDER BY r.id) AS reponse_id FROM Reponse AS r ';
    $query .= $where;
    $query .= ' GROUP BY r.id_question';
    global $bdd;
    $req = $bdd->prepare($query);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}

/**
 * @param $idQuiz // id of quiz to get answers
 * @return array
 * This function returns an array contents rights answers of a quiz
 */
function getBonnesReponses($idQuiz)
{
    $query = 'SELECT q.id AS question_id, q.type AS type, 
              GROUP_CONCAT(r.id ORDER BY lqr.ordre_reponse ASC) AS reponse_id, 
              GROUP_CONCAT(r.contenu ORDER BY lqr.ordre_reponse ASC) AS contenu
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

function add_quizToUser($quizId, $userId, $reponses)
{
    global $bdd;
    $req = $bdd->prepare('INSERT INTO lnk_Utilisateur_Quiz(id_utilisateur, id_quiz, reponses, date_ajout)
                          VALUES(:utilisateur_id, :quiz_id, :reponses, NOW())');
    $req->bindParam(':utilisateur_id', $userId, PDO::PARAM_INT);
    $req->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
    $req->bindParam(':reponses', $reponses, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
}
