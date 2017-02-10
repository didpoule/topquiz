<?php
/**
 * @param $donnees // quiz array get from query
 * @return mixed // returns formatted array
 * This function formats quiz array got from SQL query
 */
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
            $quiz['question_' . $i]['question_contenu'] = $donnees[$i]['question'];
            $quiz['question_' . $i]['question_id'] = $donnees[$i]['question_id'];
            $quiz['question_' .$i]['nombre_reponses'] = $donnees[$i]['nb_reponses'];
            $quiz['question_' . $i]['question_type'] = $donnees[$i]['question_type'];
            for ($j = 0; $j < $nbReponses[$i]; $j++) {
                $quiz['question_' . $i]['reponses_contenu'][$j] = $reponse[$i]['contenu'][$j];
                $quiz['question_' . $i]['reponses_id'][$j] = $reponse[$i]['id'][$j];
            }
        }
        return $quiz;
    }
}

/*
*/
/**
 * @param $nomGroupe // Field's prefixe name
 * @param $nbGroupes // Number of fields
 * @return array|bool // returns array with button names, else returns false
 *  Check if every field is set
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

/**
 * @param $nbQuestions // Number of questions to check
 * @param $userChoices // Answers selected by user
 * @param $correction // Rights answers get from database
 * @return array // Returns score in percentage and number of right answers
 * This function checks user answers with right answers and returns an array
 */
function quizScore($nbQuestions, $userChoices, $correction)
{
    $score = array();
    $bonneReponses = 0;
    for ($i = 0; $i < $nbQuestions; $i++) {
        if (is_array($userChoices['reponse']['contenu'][$i])) {
            if(array_compare($userChoices['reponse']['contenu'][$i], $correction[$i]['contenu'])) {
                //if (!array_diff($resultat['reponse']['contenu'][$i], $correction[$i]['contenu'])) {
                $bonneReponses++;
            }
        } else {
            if ($userChoices['reponse']['contenu'][$i] === $correction[$i]['contenu']) {
                $bonneReponses++;
            }
        }
    }
    $score['nb_juste'] = $bonneReponses;
    $score['score'] = ($bonneReponses / $nbQuestions) * 100;
    return $score;
}

/**
 * @param $fieldName // Name of column in database
 * @param $values // Values to compare in database
 * @return string // returns WHERE for SQL query
 * This function returns a string contents multiple parameters to check in database
 */
function setOrWhere($fieldName, $values)
{
    $count = count($values);
    $prefixe = $fieldName . ' = ';
    $suffixe = ' || ';
    $base = 'WHERE ';
    $result = $base . $prefixe;
    $j = $count - 1;
    for ($i = 0; $i < $count; $i++) {
        if (is_array($values[$i])) {
            foreach($values[$i] as  $k => $v) {
                $v = str_replace('\'', '\\\'', $v);
                $result .= '\'' . $v . '\'';
                if($k < count($values[$i]) - 1) {
                    $result .= $suffixe . $prefixe;
                } else {
                    break;
                }
            }
        } else {
            $values[$i] = str_replace('\'', '\\\'', $values[$i]);
            $result .= '\'' . $values[$i] . '\'';
            if ($i < $j) {
                $result .= $suffixe . $prefixe;
            } else {
                break;
            }
        }
    }
    return $result;
}

/**
 * @param $quiz // array contents answer to display
 * @param $repChoisies // array contents answer selected by user
 * @param $correction // array contents right answer
 * @param $question // var content number of question
 * This function checks if answer to display is right or wrong
 */
function answer_status($quiz, $repChoisies, $correction)
{
    if(is_array($repChoisies))
    {
        // Si la réponse à afficher est une bonne réponse
        if((in_array($quiz, $repChoisies) && in_array($quiz, $correction)) ||
            (!in_array($quiz, $repChoisies) && in_array($quiz, $correction))) {
            return 'right';
        } elseif(in_array($quiz, $repChoisies) && !in_array($quiz, $correction)) {
            return 'wrong';
        } else {
            return 'neutre';
        }
    } else {
        if (($quiz === $repChoisies) &&
            $repChoisies == $correction ||
            (($correction == $quiz) &&
                $repChoisies != $correction)
        ) {
            return 'right';
        } elseif (($quiz == $repChoisies) &&
            $repChoisies != $correction
        ) {
            return 'wrong';
        } else {
            return 'neutre';
        }
    }
}

/**
 * @param array $array1 // 1st array to compare
 * @param array $array2 // 2nd array to compare
 * @return bool // true if array values are equals
 * This function return if 2 arrays values are equals or not
 */
function array_compare(array $array1, array $array2)
{
    sort($array1);
    sort($array2);

    return $array1 == $array2;
}

function get_msg($msg)
{
    echo $msg . '<br />';
}
}