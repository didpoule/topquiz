<?php
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

function checkLogin($login, $password)
{
    global $bdd;
    $req = $bdd->prepare('SELECT true FROM Utilisateur WHERE login = :login AND password = :password');
    $req->bindParam(':login', $login, PDO::PARAM_STR);
    $req->bindParam(':password', $password, PDO::PARAM_STR);
    $req->execute();
    $donnees = $req->fetch();
    $req->closeCursor();
    return $donnees;
}

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

function getUserQuiz($id)
{
    global $bdd;
    $req = $bdd->prepare('SELECT u.id AS id_utilisateur, 
                                GROUP_CONCAT(DISTINCT(Quiz.id) ORDER BY Quiz.id) AS id_quiz, 
                                GROUP_CONCAT(DISTINCT(Quiz.nom) ORDER BY Quiz.id) AS titre,
                                COUNT(DISTINCT(Quiz.id)) as nombre  
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

function getQuizResult($idUser, $idQuiz)
{
    global $bdd;
    $req = $bdd->prepare('SELECT luq.reponse AS reponse,
                          q.type AS type
                          FROM lnk_Utilisateur_Quiz AS luq
                          INNER JOIN Question AS q ON q.id = luq.id_question
                          WHERE luq.id_utilisateur = :idUser AND luq.id_quiz = :idQuiz');
    $req->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $req->bindParam(':idQuiz', $idQuiz, PDO::PARAM_INT);
    $req->execute();
    $donnees = $req->fetchAll();
    $req->closeCursor();
    return $donnees;
}