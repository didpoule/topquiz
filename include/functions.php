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
            $quiz['question_' . $i]['nombre_reponses'] = $donnees[$i]['nb_reponses'];
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
            return $error;
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
            if ($correction[$i]['type'] == 1) {
                $sort = true;
            } else {
                $sort = false;
            }
            if (array_compare($userChoices['reponse']['contenu'][$i], $correction[$i]['contenu'], $sort)) {
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
            foreach ($values[$i] as $k => $v) {
                $v = str_replace('\'', '\\\'', $v);
                $result .= '\'' . $v . '\'';
                if ($k < count($values[$i]) - 1) {
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
 * @param $tableName // Name of the table to insert in
 * @param array $values // array contents values by fieldNames
 * @return string // SQL Query
 * This function creates a SQL insert query from an array where values ares contented in keys named by Table fieldNames
 */
function insert_values($tableName, array $values)
{
    $fieldNames = array_keys($values);
    $nFields = count($fieldNames);
    $nValues = count($values[$fieldNames[0]]);
    $separator = ', ';
    $base = "INSERT INTO $tableName(";
    $query = $base;

    for ($i = 0; $i < $nFields; $i++) {

        $query .= $fieldNames[$i];
        if ($i < $nFields - 1) {
            $query .= $separator;
        } else {
            $query .= ') ';
        }
    }
    $query .= 'VALUES(';
    for ($i = 0; $i < $nFields; $i++) {
        $query .= str_addQuotes($values[$fieldNames[$i]][0]);
        if ($i < $nFields - 1) {
            $query .= $separator;
        } else {
            $query .= ') ';
        }
    }
    if ($nValues > 1) {
        $query .= $separator . ' (';
        for ($i = 1; $i < $nValues; $i++) {
            for ($j = 0; $j < $nFields; $j++) {
                $query .= str_addQuotes($values[$fieldNames[$j]][$i]);
                if ($j < $nFields - 1) {
                    $query .= $separator;
                } else {
                    $query .= ') ';
                }
            }
            if ($i < $nValues - 1) {
                $query .= $separator . ' (';
            } else {
                $query .= ';';
            }
        }
    }
    return $query;
}

/**
 * @param $quiz // array contents answer to display
 * @param $repChoisies // array contents answer selected by user
 * @param $correction // array contents right answer
 * @param $question // var content number of question
 * This function checks if answer to display is right or wrong
 */
function answer_status($quiz, $repChoisies, $correction, $typeQuestion, $nReponse)
{
    if (is_array($repChoisies)) {
        if ($typeQuestion == 1) {
            // Si la réponse à afficher est une bonne réponse
            if ((in_array($quiz, $repChoisies) && in_array($quiz, $correction)) ||
                (!in_array($quiz, $repChoisies) && in_array($quiz, $correction))
            ) {
                return 'right';
            } elseif (in_array($quiz, $repChoisies) && !in_array($quiz, $correction)) {
                return 'wrong';
            } else {
                return 'neutre';
            }
        } elseif ($typeQuestion == 3) {
            if ($repChoisies[$nReponse] == $correction[$nReponse]) {
                return 'right';
            } else {
                return 'corrected';
            }
        }
    } elseif ($typeQuestion != 2) {
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
    } elseif ($typeQuestion == 2) {
        if ($repChoisies == $correction) {
            return 'right';
        } else {
            return 'corrected';
        }
    }
}

/**
 * @param array $array1 // 1st array to compare
 * @param array $array2 // 2nd array to compare
 * @return bool // true if array values are equals
 * This function return if 2 arrays values are equals or not
 */
function array_compare(array $array1, array $array2, $sort = false)
{
    if ($sort) {
        sort($array1);
        sort($array2);
    }
    return $array1 == $array2;
}

function get_msg($msg)
{
    echo $msg . '<br />';
}

function closePopup()
{
    echo '
                <form method="post">
                    <input type="submit" name="ok" value="Fermer" />
                </form>';
}

function set_correction($idQuiz)
{
    $correction = getBonnesReponses($idQuiz);
    if ($correction) {
        foreach ($correction as $k => $v) {
            if ($correction[$k]['type'] == 1 || $correction[$k]['type'] == 3) {
                $correction[$k]['contenu'] = explode(',', $v['contenu']);
            }
        }
    }
    return $correction;
}

/**
 * @param $text // Entrance string
 * @return string
 * This function returns a string surrounded by escaped quotes
 */
function str_addQuotes($text)
{
    $text = '\'' . $text . '\'';
    return $text;
}

/**
 * @param array $donnees // contents user answers to format
 * @param $quizId // id of quiz
 * @param $nbQuestions // number of questions
 * @return array // formatted array
 * This function reformats user answers array to be able to be inserted in DB
 */
function ur_setArray(array $donnees, $quizId, $nbQuestions)
{
    $userResult = array();
    $userId = $_SESSION['user_id'];
    for ($i = 0; $i < $nbQuestions; $i++) {
        $userResult['id_utilisateur'][$i] = $userId;
        $userResult['id_quiz'][$i] = $quizId;
        $userResult['id_question'][$i] = $donnees['question_id'][$i];
        if (!is_array($donnees['reponse']['contenu'][$i])) {
            $userResult['reponse'][$i] = $donnees['reponse']['contenu'][$i];
        } else {
            $userResult['reponse'][$i] = implode(',', $donnees['reponse']['contenu'][$i]);
        }
    }
    return $userResult;
}