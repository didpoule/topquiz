<?php
require_once('model/quiz.php');
if (isset($_GET['quiz']) && !isset($_POST['envoyer'])) {
    $quiz_id = (int)$_GET['quiz'];
    $quiz = getQuiz($quiz_id);
    $quiz = setQuizArray($quiz);
    if (!$quiz) {
        $msg = 'Ce quiz n\'existe pas';
        include 'view/404.php';
        exit;
    } else {
        if (!$_SESSION['is_connected']) {
            $msg = 'Vous devez être connecté pour faire un quiz';
            $disabledForm = TRUE;
            require_once('view/quiz.php');
        }
        require_once('view/quiz.php');
    }
}
if (isset($_POST['envoyer'])) {
    if ($_SESSION['is_connected']) {
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
            }
        }
        if ($error) {
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
                $userResult = ur_setArray($repChoisies, $quiz_id, $nbQuestions);
                add_quizToUser($userResult);
                update_user_quiz();
            }
            require_once('view/quiz_result.php');
        }
    } else {
        unset($_POST['envoyer']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}