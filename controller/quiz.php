<?php
require_once('model/quiz.php');
if(isset($_GET['quiz']) && !isset($_POST['envoyer']))
{
    getDonneesQuiz('quiz.php');
}

if(isset($_POST['envoyer']))
{
    if(isset($_POST['id_quiz']) && isset($_GET['quiz']) && isset($_POST['nb_questions']))
    {
        $nbQuestions = $_POST['nb_questions'];
        if($_POST['id_quiz'] === $_GET['quiz'])
        {
            $error = selectedRadio('question', $nbQuestions);
        }
    }
    if($error)
    {
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    else
    {
        for($question = 0; $question < $nbQuestions; $question++)
        {
            $repChoisies['question_id'][$question] = $_POST['question_id_'.$question];
            $repChoisies['reponses'][$question] = ($_POST['question_'.$question]);
        }

        $correction = getBonnesReponses($_POST['id_quiz']);
        $contenuRepChoisies = $repChoisies['reponses'];
        $repChoisies = getRepId($repChoisies['reponses']);
        for($i = 0; $i < count($contenuRepChoisies); $i++)
        {
            $repChoisies[$i]['contenu'] = $contenuRepChoisies[$i];
        }
        $score = quizScore($nbQuestions, $repChoisies, $correction);
        getDonneesQuiz('quiz_result.php', $repChoisies, $correction, $score);
    }
}
