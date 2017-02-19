<?php
require_once('model/quiz.php');
if (isset($_GET['quiz']) && !isset($_POST['envoyer'])) {
    $quiz_id = (int)$_GET['quiz'];
    $quiz = getQuiz($quiz_id);
    $quiz = setQuizArray($quiz);
    if(!$quiz) {
        $msg = 'Ce quiz n\'existe pas';
        header('HTTP/1.0 404 Not Found');
        include 'view/404.php';
        exit;
    } else {
        if (in_array($quiz_id, $_SESSION['quiz_done'])) {
            $msg = 'Vous avez déjà rempli ce quiz, vous ne pouvez pas le faire à nouveau !';
        }
        $token = generer_token('quiz');
        require_once('view/quiz.php');
    }
}
if (isset($_POST['envoyer'])) {
    $quiz_id = (int)$_POST['id_quiz'];
    $quiz = getQuiz($quiz_id);
    $quiz = setQuizArray($quiz);
    $nbQuestions = $quiz['quiz_infos']['nombre_questions'];
    if ($_SESSION['is_connected'] && verifier_token(600, $_SERVER['HTTP_REFERER'], 'quiz')) {
        if (!in_array($quiz_id, $_SESSION['quiz_done'])) {
            if (isset($_POST['id_quiz']) && isset($_GET['quiz'])) {
                $quiz_id = (int)$_POST['id_quiz'];
                $quiz = getQuiz($quiz_id);
                $quiz = setQuizArray($quiz);
                $nbQuestions = $quiz['quiz_infos']['nombre_questions'];
                if ($_POST['id_quiz'] === $_GET['quiz']) {
                    $error = selectedRadio('question', $nbQuestions);
                }
            }
        } else {
            header('Location: /?section=quiz&quiz=' . $quiz_id);
        }
        if ($error) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $correction = getBonnesReponses($_POST['id_quiz']);
            foreach ($correction as $k => $v) {
                if ($_POST['question_type_' . $k] == 1) {
                    $correction[$k]['contenu'] = explode(',', $v['contenu']);
                }
            }
            for ($question = 0; $question < $nbQuestions; $question++) {
                $repChoisies['question_id'][$question] = $_POST['question_id_' . $question];
                $repChoisies['reponse']['contenu'][$question] = $_POST['question_' . $question];
            }
            $score = quizScore($nbQuestions, $repChoisies, $correction);
            $idRep = getRepId($repChoisies['reponse']['contenu']);
            foreach ($idRep as $key => $value) {
                if ($_POST['question_type_' . $key] == 1) {
                    $repChoisies['reponse']['id'][$key] = explode(',', $value['reponse_id']);
                } else {
                    $repChoisies['reponse']['id'][$key] = $value['reponse_id'];
                }
            }
            add_quizToUser($quiz_id, $_SESSION['user_id']);
            update_user_quiz();
            require_once('view/quiz_result.php');
        }
    } else {
        $msg = 'Vous devez être connecté pour faire un quiz';
        require_once('view/quiz.php');
    }
}
