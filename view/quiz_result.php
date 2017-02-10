<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Resultat</title>
    <link href="view/style.css" rel="stylesheet"/>
</head>
<body>
<div id="corps_page">
    <?php include_once 'view/menu.php'; ?>
    <div class="titre"><h1><?= $quiz['quiz_infos']['titre'] ?></h1></div>
    <?php
    for ($question = 0; $question < $quiz['quiz_infos']['nombre_questions']; $question++) {
        ?>
        <div class="question_quiz">
            <h2><?= $question + 1 . ': ' . $quiz['question_' . $question]['question_contenu'] ?></h2>
        </div>
        <div class="reponses_quiz">
        <?php
        for ($j = 0; $j < $quiz['question_' . $question]['nombre_reponses']; $j++) {
            $answerStatus = answer_status($quiz['question_' . $question]['reponses_contenu'][$j],
                $repChoisies['reponse']['contenu'][$question],
                $correction[$question]['contenu'], $quiz['question_' . $question]['question_type'], $j);
            if( $answerStatus == 'right'){
                echo '<div class="right">Bonne réponse : ' . $quiz['question_' . $question]['reponses_contenu'][$j] . '</div>';
            } elseif($answerStatus == 'wrong') {
                echo '<div class="wrong">Mauvaise réponse : ' . $quiz['question_' . $question]['reponses_contenu'][$j] . '</div>';
            } elseif ($answerStatus == 'corrected') {
                if($quiz['question_' . $question]['question_type'] == 2) {
                    echo '<div class="wrong">Vous avez choisi : ' . $repChoisies['reponse']['contenu'][$question] . '</div>';
                    echo '<div class="right">La bonne réponse était: ' . $quiz['question_' . $question]['reponses_contenu'][$j] . '</div>';
                } elseif( $quiz['question_' . $question]['question_type'] == 3) {
                    echo '<div class="wrong">Vous avez choisi : ' . $repChoisies['reponse']['contenu'][$question][$j] . '</div>';
                    echo '<div class="right">La bonne réponse était:  ' . $quiz['question_' . $question]['reponses_contenu'][$j] . '</div>';
                }
            } else {
                echo '<div class="neutre">' . $quiz['question_' . $question]['reponses_contenu'][$j] . '</div>';
            }
        }
    }
    ?>
</div>
<h1>Score: <?= $score['score'] ?> %</h1>
</div>
</body>
</html>