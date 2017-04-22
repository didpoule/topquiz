<?php
/**
 * @param $nomGroupe // Field's prefixe name
 * @param $nbGroupes // Number of fields
 * @return array|bool // returns array with button names, else returns false
 *  Check if every field is set
 */
function setBasePath()
{
    $dirName = '';
    if (!defined('BASEURL')) {
        if (basename(dirname(__DIR__)) != 'topquiz') {
            $dirName = basename(dirname(__DIR__));
        }
        define('BASEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . $dirName);
    } else {
        return 'La constante BASEURL, est déjà définie: ' . getBasePath();
    }
}

function getBasePath()
{
    if (defined('BASEURL')) {
        return BASEURL;
    } else {
        return 'La constante BASEURL n\'est pas définie.';
    }
}

function selectedRadio($nomGroupe, $nbGroupes)
{
    $error = array();
    $j = 0;
    for ($i = 0; $i < $nbGroupes; $i++) {
        $fieldName = $nomGroupe . '_' . $i;
        if (!isset($_POST[$fieldName]) || empty($_POST[$fieldName])) {
            $error[$j] = $fieldName;
            $j++;
        } else {
            if (is_array($_POST[$fieldName])) {
                foreach ($_POST[$fieldName] as $v) {
                    if (empty($v) && !in_array($fieldName, $error)) {
                        $error[$j] = $fieldName;
                        $j++;
                    }
                }
            }
        }
    }
    return $error;
}

/**
 * @param $fieldName // Name of column in database
 * @param $values // Values to compare in database
 * @return string // returns WHERE for SQL query
 * This function returns a string contents multiple parameters to check in database
 */
function setOrWhere($fieldName, $values)
{
    $count = count($values);
    $prefixe = $fieldName . ' = ';
    $suffixe = ' || ';
    $base = 'WHERE ';
    $result = $base . $prefixe;
    $j = $count - 1;
    for ($i = 0; $i < $count; $i++) {
        if (is_array($values[$i])) {
            foreach ($values[$i] as $k => $v) {
                $v = str_replace('\'', '\\\'', $v);
                $result .= '\'' . $v . '\'';
                if ($k < count($values[$i]) - 1) {
                    $result .= $suffixe . $prefixe;
                } else {
                    break;
                }
            }
        } else {
            $values[$i] = str_replace('\'', '\\\'', $values[$i]);
            $result .= '\'' . $values[$i] . '\'';
            if ($i < $j) {
                $result .= $suffixe . $prefixe;
            } else {
                break;
            }
        }
    }
    return $result;
}

/**
 * @param $tableName // Name of the table to insert in
 * @param array $values // array contents values by fieldNames
 * @return string // SQL Query
 * This function creates a SQL insert query from an array where values ares contented in keys named by Table fieldNames
 */
function insert_values($tableName, array $values)
{
    $fieldNames = array_keys($values);
    $nFields = count($fieldNames);
    $nValues = count($values[$fieldNames[0]]);
    $separator = ', ';
    $base = "INSERT INTO $tableName(";
    $query = $base;

    for ($i = 0; $i < $nFields; $i++) {

        $query .= $fieldNames[$i];
        if ($i < $nFields - 1) {
            $query .= $separator;
        } else {
            $query .= ') ';
        }
    }
    $query .= 'VALUES(';
    for ($i = 0; $i < $nFields; $i++) {
        $query .= str_addQuotes($values[$fieldNames[$i]][0]);
        if ($i < $nFields - 1) {
            $query .= $separator;
        } else {
            $query .= ') ';
        }
    }
    if ($nValues > 1) {
        $query .= $separator . ' (';
        for ($i = 1; $i < $nValues; $i++) {
            for ($j = 0; $j < $nFields; $j++) {
                $query .= str_addQuotes($values[$fieldNames[$j]][$i]);
                if ($j < $nFields - 1) {
                    $query .= $separator;
                } else {
                    $query .= ') ';
                }
            }
            if ($i < $nValues - 1) {
                $query .= $separator . ' (';
            } else {
                $query .= ';';
            }
        }
    }
    return $query;
}


/**
 * @param array $array1 // 1st array to compare
 * @param array $array2 // 2nd array to compare
 * @return bool // true if array values are equals
 * This function return if 2 arrays values are equals or not
 */
function array_compare(array $array1, array $array2, $sort = false)
{
    if ($sort) {
        sort($array1);
        sort($array2);
    }
    return $array1 == $array2;
}

/**
 * @param $msg
 * Displays message
 */
function get_msg($msg)
{
    echo $msg . '<br />';
}

/**
 * displays a button to close a message by refreshing page
 */
function closePopup()
{
    echo '
                <form method="post">
                    <input type="submit" name="ok" value="Fermer" />
                </form>';
}


/**
 * @param $text // Entrance string
 * @return string
 * This function returns a string surrounded by escaped quotes
 */
function str_addQuotes($text)
{
    $text = '\'' . $text . '\'';
    return $text;
}

// Géneration de token
function generer_token($nom = '')
{
    $token = uniqid(rand(), true);
    $_SESSION[$nom . '_token'] = $token;
    $_SESSION[$nom . '_token_time'] = time();
    return $token;
}

// Contrôle de token
function verifier_token($temps, $referer, $nom = '')
{
    if (isset($_SESSION[$nom . '_token']) && isset($_SESSION[$nom . '_token_time']) && isset($_POST['token'])) {
        if ($_SESSION[$nom . '_token'] == $_POST['token'] &&
            $_SESSION[$nom . '_token_time'] >= (time() - $temps) &&
            $_SERVER['HTTP_REFERER'] == $referer
        ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * @param $date
 * @return DateTime|string
 * Convert a datetime in french format
 */
function dateFr($date)
{
    $dateFr = new DateTime($date);
    $dateFr = $dateFr->format('d/m/Y à H:i:s');
    return $dateFr;
}
