<?php
require_once('model/index.php');
$listeQuiz = getListeQuiz();
if ($listeQuiz) {
    foreach ($listeQuiz as $key => $quiz) {
        $listeQuiz[$key]['id'] = $quiz['id'];
        $listeQuiz[$key]['titre'] = $quiz['titre'];
    }
}
include('view/index.php');