<nav id="main_menu">
    <ul>
        <li><a href="/">Retour à l'index</a></li>
        <?php if(!$_SESSION['is_connected']) {
            echo '<li><a href="?section=user&action=connexion">Se connecter</a></li>';
        } else {
            echo '<li><a href="?section=user&action=disconnect">Se déconnecter</a></li>';
        }?>
        <li><a href="?section=user">Espace membre</a></li>
    </ul>
</nav>