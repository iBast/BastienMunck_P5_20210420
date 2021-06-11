<?php

namespace Core\Http;

/**
 * Session : use to mainpule superglobal SESSION
 */
class Session
{
    /**
     * Get a session key
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Add a session information
     *
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete a session key
     * @param string $key
     */
    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
