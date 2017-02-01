<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Topquiz</title>
</head>

<body>
<div id="corps_page">
    <form action="?section=quiz&quiz=<?= $quiz[0]['id'] ?>" id="quiz" method="post">
        <div class="titre"><h1><?= $quiz[0]['titre']?></h1></div>
        <?php
        for($question = 0; $question < $nbQuestions; $question++)
        { ?>
        <div class="question_quiz">
            <h2><?= $question+1 . ': '. $quiz[$question]['question']?></h2>
            <input type="hidden" name="question_id_<?= $question?>" value="<?= $quiz[$question]['question_id']?>">
        </div>
        <div class="reponses_quiz">

            <?php
            for($j = 0; $j  < $nbReponses[$question]; $j++)
            { ?>
                <p>
                    <input type="radio" name="question_<?= $question ?>" value="<?= $reponse[$question]['contenu'][$j] ?>"
                           id="<?= $question.'_'.$j?>">
                    <label for="<?= $question.'_'.$j?>"><?= $reponse[$question]['contenu'][$j] ?></label>
                </p>
                <?php
            }
        }
            ?>
        </div>
        <input type="hidden" name="id_quiz" value="<?= $quiz[0]['id'] ?>">
        <input type="hidden" name="nb_questions" value="<?= $nbQuestions?>">
        <input type="submit" name="envoyer">
    </form>
</div>
</body>
</html>