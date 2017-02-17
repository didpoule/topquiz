<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <link href="view/style.css" rel="stylesheet"/>
    <title>Topquiz</title>
</head>
<body>
<div id="corps_page">
    <?php include_once 'view/menu.php';
    if (isset($msg)) {
        get_msg($msg);
    }
    ?>
    <form action="?section=quiz&quiz=<?= $quiz['quiz_infos']['id'] ?>" id="quiz" method="post">
        <div class="titre"><h1><?= $quiz['quiz_infos']['titre'] ?></h1></div>
        <?php
        for ($question = 0;
             $question < $quiz['quiz_infos']['nombre_questions'];
             $question++) { ?>
            <div class="question_quiz">
                <h2><?= $question + 1 . ': ' . $quiz['question_' . $question]['question_contenu'] ?></h2>
                <input type="hidden" name="question_id_<?= $question ?>"
                       value="<?= $quiz['question_' . $question]['question_id'] ?>"/>
                <input type="hidden" name="question_type_<?= $question ?>"
                       value="<?= $quiz['question_' . $question]['question_type'] ?>"/>
            </div>
            <div class="reponses_quiz">
            <?php
            if(isset($error)) {
                if (in_array(('question_' . $question), $error)) {
                    echo '<div class="no_answered">';
                }
            }
                for ($j = 0; $j < $quiz['question_' . $question]['nombre_reponses']; $j++) {
                    if ($quiz['question_' . $question]['question_type'] == 0) { ?>
                        <p>
                            <input type="radio" name="question_<?= $question ?>"
                                   value="<?= $quiz['question_' . $question]['reponses_contenu'][$j] ?>"
                                   id="<?= $question . '_' . $j ?>"
                                   <?php if (isset($dataPost)) {
                                       if (in_array(($quiz['question_' . $question]['reponses_contenu'][$j]),
                                           $dataPost)) {
                                           if ($quiz['question_' . $question]['reponses_contenu'][$j] == $dataPost['question_' . $question]) { ?>
                                               checked="checked"
                                           <?php }
                                   }
                                }
                                if (isset($disabledForm)) { ?>
                                    disabled="disabled"
                                <?php } ?>/>
                            <label for="<?= $question . '_' . $j ?>"><?= $quiz['question_' . $question]['reponses_contenu'][$j] ?></label>
                        </p>
                        <?php
                    } elseif ($quiz['question_' . $question]['question_type'] == 1) {
                        ?>
                        <p>
                            <input type="checkbox" name="question_<?= $question ?>[]"
                                   value="<?= $quiz['question_' . $question]['reponses_contenu'][$j] ?>"
                                   id="<?= $question . '_' . $j ?>"
                                   <?php
                                   if (isset($dataPost['question_' . $question])) {
                                       if(isset($dataPost)) {
                                           if (in_array(($quiz['question_' . $question]['reponses_contenu'][$j]), $dataPost['question_' . $question])) { ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }

                                } if (isset($disabledForm)) { ?>
                                    disabled="disabled"
                                <?php } ?>/>

                            <label for="<?= $question . '_' . $j ?>"><?= $quiz['question_' . $question]['reponses_contenu'][$j] ?></label>
                        </p>
                        <?php
                    } elseif ($quiz['question_' . $question]['question_type'] == 2) {
                        ?>
                        <p>
                            <label for="<?= $question . '_' . $j ?>">Entrez votre réponse: </label>
                            <input type="number" name="question_<?= $question ?>"
                                   id="<?= $question . '_' . $j ?>"
                                <?php if (isset($dataPost['question_' . $question])) { ?>
                                            value="<?= $dataPost['question_' . $question] ?>"
                                        <?php
                                    }
                                 if (isset($disabledForm)) { ?>
                                    disabled="disabled"
                                <?php } ?>/>
                        </p>
                        <?php
                    } elseif ($quiz['question_' . $question]['question_type'] == 3) {
                        ?>
                        <p>
                            <?php
                            if ($j == 0) {
                                shuffle($quiz['question_' . $question]['reponses_contenu']);
                                echo implode(',', $quiz['question_' . $question]['reponses_contenu']) . '<br />';
                            }
                            ?>
                        </p>
                        <p>
                            <label for="<?= $question . '_' . $j ?>"><?= $j + 1 ?></label>
                            <input type="text" name="question_<?= $question ?>[]"
                                   id="<?= $question . '_' . $j ?>"
                                   <?php  if (isset($dataPost['question_' . $question])) { ?>
                                       value="<?= $dataPost['question_' . $question][$j] ?>"
                               <?php }
                               if (isset($disabledForm)) { ?>
                                    disabled="disabled"
                                <?php } ?>/>
                        </p>
                        <?php
                    }
                }
            if(isset($error)) {
                    if(in_array(('question_' . $question), $error)) {
                    echo '</div>  ';
                }
            }
            ?>

            </div>
    <?php
        }
        ?>
        <input type="hidden" name="id_quiz" value="<?= $quiz['quiz_infos']['id'] ?>">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="submit" name="envoyer">
    </form>
</div>
</body>
</html>