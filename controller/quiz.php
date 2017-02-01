<?php
require_once('model/quiz.php');
if(isset($_GET['quiz']) && !isset($_POST['envoyer']))
{
    $quizId = htmlspecialchars($_GET['quiz']);
    $donnees = getQuiz($quizId);
    if ($donnees)
    {
        $nbQuestions = 0;
        $quiz = array();
        $nbReponses = array();
        $reponse = array();
        $i = 0;
        foreach ($donnees as $cle => $quiz[$i])
        {
            $donnees[$cle]['id'] = $quiz[$i]['id'];
            $donnees[$cle]['question_id'] = $quiz[$i]['question_id'];
            $donnees[$cle]['titre'] = $quiz[$i]['titre'];
            $donnees[$cle]['question'] = $quiz[$i]['question'];
            $donnees[$cle]['reponses'] = $quiz[$i]['reponses'];
            $nbQuestions++;
            $nbReponses[$i] = $quiz[$i]['nb_reponses'];
            $i++;
        }
        for($i = 0; $i < $nbQuestions; $i++)
        {
            $reponse[$i] = explode(',', $quiz[$i]['reponses']);
        }
    }
    include('view/quiz.php');
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
        $repChoisies = getRepId($repChoisies['reponses']);
        $score = quizScore($nbQuestions, $repChoisies, $correction);
        include('view/quiz_result.php');
    }
}
