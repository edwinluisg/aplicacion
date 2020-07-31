<?php
namespace core;

class Session
{

    public static function destroy()
    {

        session_destroy();

    }

    public static function unset($variable) {

        try {
            unset($_SESSION[$variable]);
            return true;
        } catch (Exception $ex) {}

    }

    public static function has($variable)
    {

        if (isset($_SESSION[$variable])) {
            return true;
        } else {
            return false;
        }

    }

    public static function get($variable)
    {

        try {
            $variable = $_SESSION[$variable];
            return $variable;
        } catch (Exception $ex) {}

    }

    public static function set($variable, $valor)
    {

        $_SESSION[$variable] = $valor;

    }

    public static function setAuth($user, $rol, $modulos)
    {

        $auth = array(
            "user" => serialize($user),
            "rol" => serialize($rol),
            "modulos" => serialize($modulos),
        );
        $_SESSION['auth'] = $auth;

    }

    public static function hasAuth($modulos_c = [])
    {

        if (!isset($_SESSION['auth'])) {
            header('Location:' . BASE_URL);
            exit;
        } else {
            if ($modulos_c) {
                $resp = false;
                $modulos_u = unserialize($_SESSION['auth']['modulos']);
                foreach ($modulos_c as $m_c) {
                    foreach ($modulos_u as $m_u) {
                        if ($m_u->enlace == $m_c) {
                            $resp = true;
                            break;
                        }
                    }
                    if (!$resp) {
                        break;
                    }
                }
                if (!$resp) {
                    header('Location:' . BASE_URL . 'home');
                }
            }
        }

    }

    public static function getAuthUser()
    {

        return unserialize($_SESSION['auth']['user']);

    }

    public static function getAuthRol()
    {

        return unserialize($_SESSION['auth']['rol']);

    }

    public static function getAuthModulos()
    {

        return unserialize($_SESSION['auth']['modulos']);

    }

    public static function hasAuthModulo($modulo)
    {

        $modulos_u = unserialize($_SESSION['auth']['modulos']);
        $resp = false;
        foreach ($modulos_u as $m_u) {
            if ($m_u->enlace == $modulo) {
                $resp = true;
                break;
            }
        }
        return $resp;

    }

    public static function deleteAuth()
    {

        unset($_SESSION['auth']);
        session_destroy();

    }

}
