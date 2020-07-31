<?php

class App
{
    protected $controller = 'FrontController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if (isset($url[0])) {
            $nameController = $this->nameController($url[0]);
            if (file_exists(CONTROLLERS_PATH.$nameController.'.php')) {
                $this->controller = $nameController;
                unset($url[0]);
            } else {
                //Error: Controller no encontrado
                exit;
            }
        }
        require CONTROLLERS_PATH.$this->controller.'.php';
        $this->controller = new $this->controller;
        if (isset($url[1])) {
            $nameMethod = $this->nameMethod($url[1]);
            if (method_exists($this->controller, $nameMethod)) {
                $this->method = $nameMethod;
                unset($url[1]);
            } else {
                //Error: Metodod  de controller no encontrado
                exit;
            }
        }
        $this->params = $this->getParams($url);
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        }
    }

    public function nameController($name)
    {
        return ucfirst(strtolower($name)) . "Controller";
    }

    public function nameMethod($name)
    {
        return strtolower($name);
    }

    public function getParams($url)
    {
        return $url ? array_values($url) : [];
    }
}
