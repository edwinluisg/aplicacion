<?php
use core\Response;

class FrontController
{

    public function index()
    {

        Response::render('index');

    }

}
