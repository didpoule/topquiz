<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Topquiz</title>
</head>

<body>
<div id="corps_page">
    <form action="quiz.php" id="quiz">
        <div class="titre"><h1><?= $quiz[0]['titre']?></h1></div>
        <?php
        for($question = 0; $question < $nbQuestions; $question++)
        { ?>
        <div class="question_quiz">
            <h2><?= $question+1 . ': '. $quiz[$question]['question']?></h2>
        </div>
        <div class="reponses_quiz">

            <?php
            for($j = 0; $j  < $nbReponses[$question]; $j++)
            { ?>
                <p>
                    <input type="radio" name="question_<?= $question ?>" value="<?= $question.'_'.$j?>">
                    <?= $reponse[$question][$j] ?>
                </p>
                <?php
            }
        }
            ?>
        </div>
    </form>
</div>
</body>
</html>