<?php
namespace core;

class Request
{

    public static $form;
    public static $errors;
    public static $errors_cont = 0;

    public static function validar()
    {

        foreach (self::$form as $key => $value) {
            $datosInput = explode("|", $key);
            $name = $datosInput[0];
            $alias = $datosInput[1];
            $reglasInput = explode("|", $value);
            foreach ($reglasInput as $regla) {
                $ref = false;
                $parametrosInput = explode(":", $regla);
                $regla = $parametrosInput[0];
                $parametro = null;
                if (count($parametrosInput) > 1) {
                    $parametro = $parametrosInput[1];
                }
                switch ($regla) {
                    case 'requerido':
                        if (!self::requerido($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'cadena':
                        if (!self::cadena($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'email':
                        if (!self::email($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'entero':
                        if (!self::entero($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'fecha':
                        if (!self::fecha($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'edad':
                        if (!self::edad($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'menorque':
                        if (!self::menorque($name, $alias, $parametro)) {
                            $ref = true;
                        }
                        break;
                    case 'mayorque':
                        if (!self::mayorque($name, $alias, $parametro)) {
                            $ref = true;
                        }
                        break;
                    case 'mayorigualque':
                        if (!self::mayorigualque($name, $alias, $parametro)) {
                            $ref = true;
                        }
                        break;
                    case 'largomin':
                        if (!self::largomin($name, $alias, $parametro)) {
                            $ref = true;
                        }
                        break;
                    case 'imagenrequerido':
                        if (!self::imagenrequerido($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    case 'imagen':
                        if (!self::imagen($name, $alias)) {
                            $ref = true;
                        }
                        break;
                    default:
                        break;
                }
                if ($ref) {
                    break;
                }
            }

        }
        if (self::$errors_cont > 0) {
            self::$errors['success'] = false;
            return false;
        } else {
            return true;
        }

    }

    public static function requerido($name, $alias)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value == null or $value == "") {
            $mensaje = 'El campo ' . $alias . ' es obligatorio';
            self::$errors_cont++;
            $resp = false;
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function cadena($name, $alias)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if (!preg_match("/^(?!-+)[a-zA-Z-ñáéíóú ]*$/", $value)) {
                $mensaje = 'El campo ' . $alias . ' debe ser una cadena de texto';
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function email($name, $alias)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $mensaje = 'El campo ' . $alias . ' debe ser un correo correcto';
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function entero($name, $alias)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if (!preg_match("/^([0-9])*$/", $value)) {
                $mensaje = 'El campo ' . $alias . ' debe ser un numero entero';
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function fecha($name, $alias)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if (!preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/", $value)) {
                $mensaje = 'El campo ' . $alias . ' debe tener el formato dd/mm/yyyy';
                self::$errors_cont++;
                $resp = false;
            } else {
                $valores = explode('/', $value);
                if (!(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2]))) {
                    $mensaje = 'El campo ' . $alias . ' debe ser una fecha valida';
                    self::$errors_cont++;
                    $resp = false;
                }
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function edad($name, $alias)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            $valores = explode('-', $value);
            $anio = intval($valores[0]);
            $mes = intval($valores[1]);
            $dia = intval($valores[2]);

            $fecha_hoy = date("Y-m-d");
            $valores_a = explode('-', $fecha_hoy);
            $anio_a = intval($valores_a[0]);
            $mes_a = intval($valores_a[1]);
            $dia_a = intval($valores_a[2]);

            $edad = false;
            if ($anio < $anio_a) {
                #calcular edad
                $edad = true;
            } else if ($anio == $anio_a) {
                # seguir verificando
                if ($mes < $mes_a) {
                    #calcular edad
                    $edad = true;
                } else if ($mes == $mes_a) {
                    # seguir verificando
                    if ($dia <= $dia_a) {
                        #calcular edad
                        $edad = true;
                    }
                }
            }
            if (!$edad) {
                $mensaje = 'La fecha ingresada debe ser menor a la fecha actual';
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function menorque($name, $alias, $parametro)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if ($value >= $parametro) {
                $mensaje = 'El campo ' . $alias . ' debe ser menor a ' . $parametro;
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function mayorque($name, $alias, $parametro)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if ($value <= $parametro) {
                $mensaje = 'El campo ' . $alias . ' debe ser mayor a ' . $parametro;
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;
    }

    public static function mayorigualque($name, $alias, $parametro)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if ($value < $parametro) {
                $mensaje = 'El campo ' . $alias . ' debe ser mayor o igual a ' . $parametro;
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function largomin($name, $alias, $parametro)
    {
        $value = trim($_REQUEST[$name]);
        $resp = true;
        $mensaje = '';
        if ($value != '') {
            if (strlen($value) <= $parametro) {
                $mensaje = 'El campo ' . $alias . ' debe tener una longitud mayor a ' . $parametro . ' caracteres';
                self::$errors_cont++;
                $resp = false;
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;

    }

    public static function imagenrequerido($name, $alias)
    {
        $file = $_FILES[$name];
        $resp = false;
        $mensaje = '';
        if (isset($file)) {
            if ($file["error"] <= 0) {
                $resp = true;
            }
        }
        if (!$resp) {
            $mensaje = 'El campo ' . $alias . ' es obligatorio';
            self::$errors_cont++;
        }
        self::$errors[$name] = $mensaje;
        return $resp;
    }

    public static function imagen($name, $alias)
    {
        $file = $_FILES[$name];
        $resp = true;
        $mensaje = '';
        if (isset($file)) {
            if ($file["error"] <= 0) {
                $resp = false;
                $extencion = pathinfo($file["name"])['extension'];
                $array = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG");
                foreach ($array as $value) {
                    if ($value == $extencion) {
                        $resp = true;
                        break;
                    }
                }
                if (!$resp) {
                    $mensaje = 'El campo ' . $alias . ' debe tener un formato de imagen correcto';
                    self::$errors_cont++;
                }
            }
        }
        self::$errors[$name] = $mensaje;
        return $resp;
    }

}
