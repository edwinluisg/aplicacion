<?php
namespace core;

class Response
{

    public static function render($view, $vars = [])
    {

        foreach ($vars as $key => $value) {
            $$key = $value;
        }
        require VIEWS_PATH . $view . ".php";

    }

    public static function redirect($url, $vars = [])
    {

        $variables = '';
        if (isset($vars)) {
            foreach ($vars as $value) {
                $variables .= '/' . $value;
            }
        }
        header('Location:' . BASE_URL . $url . $variables);

    }

    public static function json($json)
    {

        echo json_encode($json);

    }

}
