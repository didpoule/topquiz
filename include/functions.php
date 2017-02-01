<?php
/* Check if radio buttons sent in paramaters are ALL set
If one button is not set function returns array with button names, else returns false
*/
function getDonneesQuiz($fileToInclude, $repChoisies = NULL, $correction = NULL, $score = NULL)
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
            $reponse[$i]['contenu'] = explode(',', $quiz[$i]['reponses']);
        }
    }
    include('view/'.$fileToInclude);
}
function selectedRadio($nomGroupe, $nbGroupes)
{
    $error = array();
    $j = 0;
    for ($i = 0; $i < $nbGroupes; $i++)
    {
        $fieldName = $nomGroupe . '_' . $i;
        if (!isset($_POST[$fieldName]))
        {
            $error[$j] = $fieldName;
            $j++;
        }
    }
    if($error)
    {
        return $error;
    }
    else
    {
        return false;
    }
}

function quizScore($nbQuestions, $resultat, $correction)
{
    $score = array();
    $bonneReponses = 0;
    for($i = 0; $i< $nbQuestions; $i++)
    {
        if($resultat[$i]['reponse_id'] === $correction[$i]['reponse_id'])
        {
            $bonneReponses ++;
        }
    }
    $score['nb_juste'] = $bonneReponses;
    $score['score'] = ($bonneReponses / $nbQuestions) *100;
    return $score;
}
// Retourne une chaine WHERE avec plusieurs conditions OU
function setOrWhere($fieldName, $values)
{
    $count = count($values);
    $prefixe = $fieldName.' = ';
    $suffixe = ' || ';
    $base = 'WHERE ';
    $result = $base.$prefixe;
    $j = $count - 1;
    for($i = 0; $i < $count; $i++)
    {
        $values[$i] = str_replace('\'', '\\\'', $values[$i]);
        $result .= '\''.$values[$i].'\'';
        if($i < $j)
        {

            $result .= $suffixe.$prefixe;
        }
        else
        {
            break;
        }
    }
    return $result;
}