<?php
function setQuizArray($donnees)
{
    if ($donnees) {
        $nbQuestions = 0;
        $nbReponses = array();
        $reponse = array();
        foreach ($donnees as $cle => $donnees[$nbQuestions]) {
            $nbReponses[$nbQuestions] = $donnees[$cle]['nb_reponses'];
            $nbQuestions++;
        }
        for ($i = 0; $i < $nbQuestions; $i++) {
            $reponse[$i]['contenu'] = explode(',', $donnees[$i]['reponses']);
            $reponse[$i]['id'] = explode(',', $donnees[$i]['reponses_id']);
        }
        $quiz['quiz_infos']['titre'] = $donnees[0]['titre'];
        $quiz['quiz_infos']['id'] = $donnees[0]['id'];
        $quiz['quiz_infos']['nombre_questions'] = $nbQuestions;
        for ($i = 0; $i < $nbQuestions; $i++) {
            $quiz['question_' . ($i)]['question_contenu'] = $donnees[$i]['question'];
            $quiz['question_' . ($i)]['question_id'] = $donnees[$i]['question_id'];
            $quiz['question_' . ($i)]['nombre_reponses'] = $donnees[$i]['nb_reponses'];
            for ($j = 0; $j < $nbReponses[$i]; $j++) {
                $quiz['question_' . ($i)]['reponses_contenu'][$j] = $reponse[$i]['contenu'][$j];
                $quiz['question_' . ($i)]['reponses_id'][$j] = $reponse[$i]['id'][$j];
            }
        }
        return $quiz;
    }
}

/* Check if radio buttons sent in paramaters are ALL set
If one button is not set function returns array with button names, else returns false
*/
function selectedRadio($nomGroupe, $nbGroupes)
{
    $error = array();
    $j = 0;
    for ($i = 0; $i < $nbGroupes; $i++) {
        $fieldName = $nomGroupe . '_' . $i;
        if (!isset($_POST[$fieldName])) {
            $error[$j] = $fieldName;
            $j++;
        }
    }
    if ($error) {
        return $error;
    } else {
        return false;
    }
}

function quizScore($nbQuestions, $resultat, $correction)
{
    $score = array();
    $bonneReponses = 0;
    for ($i = 0; $i < $nbQuestions; $i++) {
        if ($resultat['reponse']['id'][$i] === $correction[$i]['reponse_id']) {
            $bonneReponses++;
        }
    }
    $score['nb_juste'] = $bonneReponses;
    $score['score'] = ($bonneReponses / $nbQuestions) * 100;
    return $score;
}

// Retourne une chaine WHERE avec plusieurs conditions OU
function setOrWhere($fieldName, $values)
{
    $count = count($values);
    $prefixe = $fieldName . ' = ';
    $suffixe = ' || ';
    $base = 'WHERE ';
    $result = $base . $prefixe;
    $j = $count - 1;
    for ($i = 0; $i < $count; $i++) {
        $values[$i] = str_replace('\'', '\\\'', $values[$i]);
        $result .= '\'' . $values[$i] . '\'';
        if ($i < $j) {
            $result .= $suffixe . $prefixe;
        } else {
            break;
        }
    }
    return $result;
}