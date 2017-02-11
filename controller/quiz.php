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
        require_once('view/quiz.php');
    }
}
if (isset($_POST['envoyer'])) {
    $quiz_id = (int)$_POST['id_quiz'];
    $quiz = getQuiz($quiz_id);
    $quiz = setQuizArray($quiz);
    $nbQuestions = $quiz['quiz_infos']['nombre_questions'];
    if ($_SESSION['is_connected']) {
            if (isset($_POST['id_quiz']) && isset($_GET['quiz'])) {
                $quiz_id = (int)$_POST['id_quiz'];
                $quiz = getQuiz($quiz_id);
                $quiz = setQuizArray($quiz);
                $nbQuestions = $quiz['quiz_infos']['nombre_questions'];
                if ($_POST['id_quiz'] === $_GET['quiz']) {
                    $error = selectedRadio('question', $nbQuestions);
                }
            }

        if ($error) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $correction = set_correction($_POST['id_quiz']);
            for ($question = 0; $question < $nbQuestions; $question++) {
                $repChoisies['question_id'][$question] = $_POST['question_id_' . $question];
                $repChoisies['reponse']['contenu'][$question] = $_POST['question_' . $question];
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
                    foreach($repChoisies['reponse']['contenu'] as $v) {
                        add_quizToUser($quiz_id, $_SESSION['user_id'], $v);
                        update_user_quiz();
                    }
                }
            require_once('view/quiz_result.php');
        }
    } else {
        $msg = 'Vous devez être connecté pour faire un quiz';
        require_once('view/quiz.php');
    }
}