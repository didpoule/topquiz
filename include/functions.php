<?php
/* Check if radio buttons sent in paramaters are ALL set
If one button is not set function returns array with button names, else returns false
*/
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
        if($resultat[$i]['reponse'] === $correction[$i]['reponse'])
        {
            $bonneReponses ++;
        }
    }
    $score['nb_juste'] = $bonneReponses;
    $score['score'] = ($bonneReponses / $nbQuestions) *100;

    return $score;
}