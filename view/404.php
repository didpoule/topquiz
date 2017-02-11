<?php
header('HTTP/1.0 404 Not Found');
if(isset($msg)) {
    get_msg($msg);
}
    echo '<a href="#" onclick="history.go(-1);">Retourner à la page précédente</a>';
