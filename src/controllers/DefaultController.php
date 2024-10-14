<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function error404()
    {
        $this->render('error404');
    }
}