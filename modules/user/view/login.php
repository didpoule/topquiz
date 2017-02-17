<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Page de connexion</title>
</head>
<body>
<?php include_once 'view/menu.php'; ?>
    <h1>Connexion à l'espace membre</h1>
    <div id="corps_page">
        <p>Entrez votre login et votre mot de passe pour vous connecter.</p>
        <form method='post'>
            <p>
                Login : <input type='text' name='login'><br/>
                Mot de passe : <input type='password' name='password'><br/><br/>
                <input type='submit' name='connexion' value='connexion'>
                <input type="hidden" name='token' value="<?= $token ?>">
            </p>
            <?php if(isset($msg)) {
                get_msg($msg);
            }?>
    </div>
</body>
</html>

