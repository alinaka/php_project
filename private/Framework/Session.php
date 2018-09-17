<?php

namespace Framework;

class Session
{

    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function start()
    {
        session_start();
    }
}
