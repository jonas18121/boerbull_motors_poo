<?php

declare(strict_types=1);

class MessageFlashSession {

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setFlash($color, $message)
    {
        $_SESSION['flash'] = [
            'color'     => $color,
            'message'   => $message
        ];

        // if (empty($_SESSION['flash'])) {
        //     return null;
        // }
    }

    public function getFlash()
    {
        // if (!empty($_SESSION['flash'])) {
        //     return $_SESSION['flash']['message'];
        // }

        return $_SESSION['flash']['message'];
    }
}