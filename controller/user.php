<?php
require_once 'model/user.php';
if (!$_SESSION['is_connected']) {
    header('Location: ?section=login');
} else {
    if (isset($_GET['action'])) {
        $action = htmlspecialchars($_GET['action']);
        switch ($action):
            case 'disconnect':
                disconnect_user();
                break;
            case 'history':
                $history = getUserQuiz($_SESSION['user_id']);
                if ($history['nombre'] > 1) {
                    $history['id_quiz'] = explode(',', $history['id_quiz']);
                    $history['titre'] = explode(',', $history['titre']);
                } else {
                    $history['id_quiz'] = array(0 => $history['id_quiz']);
                    $history['titre'] = array(0 => $history['titre']);
                }
                require_once 'view/user.php';
                break;
            case 'view':
                if (isset($_GET['quiz'])) {
                    $quizId = (int)$_GET['quiz'];
                    if (in_array($quizId, $_SESSION['quiz_done'])) {
                        require_once 'model/quiz.php';
                        $quiz = getQuiz($quizId);
                        $quiz = setQuizArray($quiz);
                        $repChoisies = set_view_Result($quizId);
                        $correction = set_correction($quizId);
                        $score = quizScore($quiz['quiz_infos']['nombre_questions'], $repChoisies, $correction);
                        require_once 'view/quiz_result.php';
                    } else {
                        $msg = 'Vous n\'avez pas encore réalisé ce quiz !';
                        header('Location: ?section=user&action=history');
                    }
                }
                break;
        endswitch;
    } else {
        require_once 'view/user.php';
    }
}