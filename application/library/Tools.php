<?php

declare(strict_types=1);

/**
 * redirectionne vers un url
 *
 * @param string $url
 * @return void
 */
function redirect(string $url) : void
{
    header('Location: ' . $url);
    exit();
}


/**
 * var_dump avec < pre >< / pre > pour le debogage de code
 * 
 * @param mixed $param1 - Tous les types de param sont accepter
 * @param mixed $param2 - (facultative) Tous les types de param sont accepter
 * @param bool $param3  - sur false par défault , permet d'activer ou pas, la function die()
 * 
 * @return void - retourne la valeur de var_dump
 */
function pre_var_dump($param1, $param2 = null, bool $param3 = false) : void
{
    if ($param3 === false) {
        
        if ($param2 === null) {
            echo '<pre>';
            var_dump($param1);
            echo '</pre>';
        }
        else{
            echo '<pre>';
            var_dump($param1, $param2);
            echo '</pre>';
        }
    }else{
        if ($param2 === null) {
            echo '<pre>';
            var_dump($param1);die;
            echo '</pre>';
        }
        else{
            echo '<pre>';
            var_dump($param1, $param2);die;
            echo '</pre>';
        }
    }
}
