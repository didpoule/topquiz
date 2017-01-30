<?php
require_once('model/quiz.php');
if(isset($_GET['quiz']))
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
            $donnees[$cle]['titre'] = $quiz[$i]['titre'];
            $donnees[$cle]['question'] = $quiz[$i]['question'];
            $donnees[$cle]['reponses'] = $quiz[$i]['reponses'];
            $nbQuestions = $quiz[$i]['nb_questions'];
            $nbReponses[$i] = $quiz[$i]['nb_reponses'];
            $i++;
        }
        for($i = 0; $i <= $nbQuestions; $i++)
        {
            $reponse[$i] = explode(',', $quiz[$i]['reponses']);
        }
    }
}
include('view/quiz.php');