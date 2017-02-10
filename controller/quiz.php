<?php
require_once('model/quiz.php');
if (isset($_GET['quiz']) && !isset($_POST['envoyer'])) {
    $quiz_id = (int)$_GET['quiz'];
    $quiz = getQuiz($quiz_id);
    $quiz = setQuizArray($quiz);
    require_once('view/quiz.php');
}
if (isset($_POST['envoyer'])) {
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
        $correction = getBonnesReponses($_POST['id_quiz']);
        foreach($correction as $k => $v) {
            if($_POST['question_type_' . $k] == 1)
            {
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
            if($_POST['question_type_' . $key] == 1) {
                $repChoisies['reponse']['id'][$key] = explode(',', $value['reponse_id']);
            } else {
                $repChoisies['reponse']['id'][$key] = $value['reponse_id'];
            }

        }
        require_once('view/quiz_result.php');
    }
}
