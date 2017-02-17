<?php
require_once('modules/quiz/model/quiz.php');
if (isset($_GET['quiz']) && !isset($_POST['envoyer'])) {
    $quiz_id = (int)$_GET['quiz'];
    $quiz = getQuiz($quiz_id);
    if (!$quiz) {
        $msg = 'Ce quiz n\'existe pas';
        include 'view/404.php';
        exit;
    } else {
        if (!$_SESSION['is_connected']) {
            $msg = 'Vous devez être connecté pour faire un quiz';
            $disabledForm = TRUE;
        } else if(!empty($_SESSION['error'])) {
            $msg = 'Vous n\'avez pas répondu à toute les questions !';
            $error = unserialize($_SESSION['error']);
            $_SESSION['error'] = array();
            $dataPost = unserialize($_SESSION['data_post']);
        }
        $quiz = setQuizArray($quiz);
        $token = generer_token('quiz');
        require_once('modules/quiz/view/quiz.php');
    }
}
if (isset($_POST['envoyer'])) {
    if ($_SESSION['is_connected'] && verifier_token(600, $_SERVER['HTTP_REFERER'], 'quiz')) {
        $quiz_id = (int)$_POST['id_quiz'];
        $quiz = getQuiz($quiz_id);
        $quiz = setQuizArray($quiz);
        $nbQuestions = $quiz['quiz_infos']['nombre_questions'];
        if (isset($_POST['id_quiz']) && isset($_GET['quiz'])) {
            $quiz_id = (int)$_POST['id_quiz'];
            $quiz = getQuiz($quiz_id);
            $quiz = setQuizArray($quiz);
            $nbQuestions = $quiz['quiz_infos']['nombre_questions'];
            if ($quiz_id == $_GET['quiz']) {
                $error = selectedRadio('question', $nbQuestions);
                if(!empty($error)) {
                    $_SESSION['error'] = serialize($error);
                }
            }
        }
        if (!empty($_SESSION['error'])) {
            $_SESSION['data_post'] = serialize($_POST);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $correction = set_correction($quiz_id);
            for ($question = 0; $question < $nbQuestions; $question++) {
                $repChoisies['question_id'][$question] = $_POST['question_id_' . $question];
                if(!is_array($_POST['question_' . $question]))
                {
                    $repChoisies['reponse']['contenu'][$question] = htmlspecialchars($_POST['question_' . $question]);
                } else {
                    foreach($_POST['question_' . $question] as $k => $v) {
                        $repChoisies['reponse']['contenu'][$question][$k] = htmlspecialchars($v);
                    }
                }
            }
            $score = quizScore($nbQuestions, $repChoisies, $correction);
            $idRep = getRepId($repChoisies['reponse']['contenu']);
            foreach ($idRep as $key => $value) {
                if ($_POST['question_type_' . $key] == 1 || $_POST['question_type_' . $key] == 3) {
                    $repChoisies['reponse']['id'][$key] = explode(',', $value['reponse_id']);
                } else {
                    $repChoisies['reponse']['id'][$key] = $value['reponse_id'];
                }
            }
            if (!in_array($quiz_id, $_SESSION['quiz_done'])) {
                $userResult = user_setArray($repChoisies, $quiz_id, $nbQuestions);
                add_quizToUser($userResult);
                user_update_quiz();
            }
            require_once('modules/quiz/view/quiz_result.php');
        }
    } else {
        unset($_POST['envoyer']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}