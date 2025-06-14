<?php

namespace PHPFramework;

class Session
{

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    public function getFlash($key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }
        return $value ?? null;
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function forget($key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

}