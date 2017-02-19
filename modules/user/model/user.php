<?php
/**
 * @param $login
 * @param $password
 * @param $pseudo
 * Create a user
 */
function createUser($login, $password, $pseudo)
{
    global $bdd;
    $req = $bdd->prepare('INSERT INTO Utilisateur(login, password, pseudo)
                                     VALUES(:login, :password, :pseudo)');
    $req->bindParam(':login', $login, PDO::PARAM_STR);
    $req->bindParam(':password', $password, PDO::PARAM_STR);
    $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
}

/**
 * @param $login
 * @param $password
 * @return mixed
 * Returns true if login and password are exact
 */
function checkLogin($login, $password)
{
    global $bdd;
    $req = $bdd->prepare('SELECT TRUE FROM Utilisateur WHERE login = :login AND password = :password');
    $req->bindParam(':login', $login, PDO::PARAM_STR);
    $req->bindParam(':password', $password, PDO::PARAM_STR);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees;
}

/**
 * @param $login
 * @return mixed
 * Returns user's id
 */
function getUserId($login)
{
    global $bdd;
    $req = $bdd->prepare('SELECT id FROM Utilisateur WHERE login = :login');
    $req->bindParam(':login', $login, PDO::PARAM_STR);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['id'];
}

/**
 * @param $id
 * @return mixed
 * Returns user's nickname
 */
function getUserPseudo($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT pseudo FROM Utilisateur WHERE id = :id');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees['pseudo'];
}

/**
 * @param $id
 * @return mixed
 * This function returns list of quiz name done by a user
 */
function getUserHistory($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT u.id AS id_utilisateur, 
                                GROUP_CONCAT(DISTINCT(Quiz.id) ORDER BY Quiz.id) AS id_quiz, 
                                GROUP_CONCAT(DISTINCT(Quiz.nom) ORDER BY Quiz.id) AS titre,
                                COUNT(DISTINCT(Quiz.id)) AS nombre  
                                FROM Utilisateur AS u
                                  LEFT JOIN lnk_Utilisateur_Quiz AS luq 
                                    ON u.id = luq.id_utilisateur
                                  LEFT JOIN Quiz 
                                    ON Quiz.id = luq.id_quiz
                                  WHERE u.id = :id
                          GROUP BY id_utilisateur');
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees;
}

/**
 * @param $quizId
 * @param $userId
 * @param $resultId
 * @return mixed
 * This function returns an array of user quiz result
 */
function getQuizResult($quizId, $userId, $resultId)
{
    global $bdd;
    $req = $bdd->prepare('SELECT luq.reponses AS reponses
                          FROM lnk_Utilisateur_Quiz AS luq
                          WHERE luq.id_quiz = :idQuiz AND luq.id_utilisateur = :idUser AND luq.id = :idResult');
    $req->bindParam(':idQuiz', $quizId, PDO::PARAM_INT);
    $req->bindParam(':idUser', $userId, PDO::PARAM_INT);
    $req->bindParam(':idResult', $resultId, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees;
}

/**
 * @param $userId
 * @param $quizId
 * @return array
 * This function returns user results for a quiz id
 */
function getUserQuizHistory($userId, $quizId)
{
    global $bdd;
    $req = $bdd->prepare('SELECT q.nom AS titre, luq.id, luq.date_ajout AS date,
                                  luq.id_quiz
                          FROM lnk_Utilisateur_Quiz AS luq
                          INNER JOIN Quiz AS q
                            ON q.id = luq.id_quiz
                          WHERE luq.id_utilisateur = :idUser AND luq.id_quiz = :idQuiz
                          ORDER BY date DESC');
    $req->bindParam(':idUser', $userId, PDO::PARAM_INT);
    $req->bindParam(':idQuiz', $quizId, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}