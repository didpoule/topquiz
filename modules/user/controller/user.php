<?php
require_once 'modules/user/model/user.php';
if (isset($_GET['action'])) {
    $action = htmlspecialchars($_GET['action']);
    switch ($action):
        case 'connexion':
            if (!$_SESSION['is_connected']) {
                if (isset($_POST['connexion'])) {
                    if (empty($_POST['login']) || empty($_POST['password'])) {
                        $msg = 'Veuillez remplir tous les champs';
                    } else {
                        $login = htmlspecialchars($_POST['login']);
                        $password = htmlspecialchars($_POST['password']);
                        if (checkLogin($login, $password)) {
                            $_SESSION['user_id'] = getUserId($login);
                            $_SESSION['user_pseudo'] = getUserPseudo($_SESSION['user_id']);
                            update_user_quiz();
                            $_SESSION['is_connected'] = 1;
                            header('Location: ?section=user');
                        } else {
                            $msg = 'Mauvais Login/Mot de passe';
                        }
                    }
                }
                require_once 'modules/user/view/login.php';
            } else {
                header('Location: ?section=user');
            }
            break;
        case 'disconnect':
            if ($_SESSION['is_connected']) {
                disconnect_user();
            } else {
                header('Location: index.php');
            }
            break;
        case 'history':
            if ($_SESSION['is_connected']) {
                $history = getUserQuiz($_SESSION['user_id']);
                if ($history['nombre'] > 1) {
                    $history['id_quiz'] = explode(',', $history['id_quiz']);
                    $history['titre'] = explode(',', $history['titre']);
                } else {
                    $history['id_quiz'] = array(0 => $history['id_quiz']);
                    $history['titre'] = array(0 => $history['titre']);
                }
                require_once 'modules/user/view/user.php';
            } else {
                header('Location: ?section=user&action=connexion');
            }
            break;
        case 'view':
            if ($_SESSION['is_connected']) {
                if (isset($_GET['quiz'])) {
                    $quizId = (int)$_GET['quiz'];
                    if (in_array($quizId, $_SESSION['quiz_done'])) {
                        require_once 'modules/quiz/model/quiz.php';
                        $quiz = getQuiz($quizId);
                        $quiz = setQuizArray($quiz);
                        $repChoisies = set_view_Result($quizId);
                        $correction = set_correction($quizId);
                        $score = quizScore($quiz['quiz_infos']['nombre_questions'], $repChoisies, $correction);
                        require_once 'modules/quiz/view/quiz_result.php';
                    } else {
                        $msg = 'Vous n\'avez pas encore réalisé ce quiz !';
                        header('Location: ?section=user&action=history');
                    }
                }
            } else {
                header('Location: ?section=user&action=connexion');
            }
            break;
    endswitch;
} else {
    if ($_SESSION['is_connected']) {
        require_once 'modules/user/view/user.php';
    } else {
        header('Location: ?section=user&action=connexion');

    }
}
