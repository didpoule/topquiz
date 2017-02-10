<?php
// Fonctions de cryptage pour mots de passes. Sources www.stackoverflow.com
function encrypt($pure_string, $encryption_key)
{
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

function decrypt($encrypted_string, $encryption_key)
{
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}

function update_user_quiz()
{
    require_once 'model/user.php';
    $_SESSION['quiz_done'] = explode(',', getUserQuiz($_SESSION['user_id']));
}

function disconnect_user()
{
    unset($_SESSION['user_id']);
    unset($_SESSION['user_pseudo']);
    unset($_SESSION['is_connected']);
    header('Location: /');
}