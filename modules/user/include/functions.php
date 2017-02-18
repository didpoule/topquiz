<?php
// Fonctions de cryptage pour mots de passes. Sources www.stackoverflow.com
function encrypt($pure_string, $encryption_key)
{
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB,
        $iv);
    return $encrypted_string;
}

function decrypt($encrypted_string, $encryption_key)
{
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}


function user_disconnect()
{
    if ($_SESSION['is_connected']) {
        session_destroy();
    }
    header('Location: /');
}

function user_init()
{
    $_SESSION['user_id'] = 0;
    $_SESSION['user_pseudo'] = 0;
    $_SESSION['quiz_done'] = array();
    $_SESSION['error'] = 0;
    $_SESSION['data_post'] = 0;
    $_SESSION['is_connected'] = 0;
}

function set_view_Result($quizId)
{
    $result = getQuizResult($_SESSION['user_id'], $quizId);
    $result = unserialize($result['reponses']);
    return $result;
}

function user_update_quiz()
{
    require_once 'modules/user/model/user.php';
    $quizDone = getUserQuiz($_SESSION['user_id']);
    if (!is_array($quizDone['id_quiz'])) {
        $_SESSION['quiz_done'] = explode(',', $quizDone['id_quiz']);
    } else {
        $_SESSION['quiz_done'] = $quizDone['id_quiz'];
    }
}

function user_connect()
{
    if (!$_SESSION['is_connected']) {
        if (isset($_POST['connexion'])) {
            if (empty($_POST['login']) || empty($_POST['password'])) {
                $msg = 'Veuillez remplir tous les champs';

            } else {
                if (verifier_token(600, $_SERVER['HTTP_REFERER'], 'login')) {
                    $login = htmlspecialchars($_POST['login']);
                    $password = htmlspecialchars($_POST['password']);
                    if (checkLogin($login, $password)) {
                        $_SESSION['user_id'] = getUserId($login);
                        $_SESSION['user_pseudo'] = getUserPseudo($_SESSION['user_id']);
                        user_update_quiz();
                        $_SESSION['is_connected'] = 1;
                        header('Location: ?section=user');
                    } else {
                        $msg = 'Mauvais Login/Mot de passe';
                    }
                } else {
                    unset($_POST['connexion']);
                    $msg = 'Une erreur s\'est produite, veuillez reessayer.';
                    $token = generer_token('login');

                }
            }
        } else {
            $token = generer_token('login');
        }
        require_once 'modules/user/view/login.php';
    } else {
        header('Location: ?section=user');
    }
}

function user_history()
{
    if ($_SESSION['is_connected']) {
        $history = getUserQuiz($_SESSION['user_id']);
        if ($history['nombre'] > 1) {
            $history['id_quiz'] = explode(',', $history['id_quiz']);
            $history['titre'] = explode(',', $history['titre']);
        } else {
            $history['id_quiz'] = array(0 => $history['id_quiz']);
            $history['titre'] = array(0 => $history['titre']);
        }
        $action = 'history';
        require_once 'modules/user/view/user.php';
    } else {
        header('Location: ?section=user&action=connexion');
    }
}

function user_viewQuiz()
{
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
}