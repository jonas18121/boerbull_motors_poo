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