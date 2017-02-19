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
            // Send answers in an array
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
            // Checks answers selected with the correction
            $score = quizScore($nbQuestions, $repChoisies, $correction);

            // Send answers id in user's answers array
            $idRep = getRepId($repChoisies['reponse']['contenu']);
            foreach ($idRep as $key => $value) {
                if ($_POST['question_type_' . $key] == 1 || $_POST['question_type_' . $key] == 3) {
                    $repChoisies['reponse']['id'][$key] = explode(',', $value['reponse_id']);
                } else {
                    $repChoisies['reponse']['id'][$key] = $value['reponse_id'];
                }
            }
            // Save result in database and update current session
                $userResult = serialize($repChoisies);
                add_quizToUser($quiz_id, $_SESSION['user_id'], $userResult);
                user_update_quiz();
            require_once('modules/quiz/view/quiz_result.php');
        }
    } else {
        unset($_POST['envoyer']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}