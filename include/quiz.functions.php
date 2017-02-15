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
 * @param $idQuiz // The quiz to correct
 * @return array
 * This function returns a formatted array contents right answers of quiz
 */
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
