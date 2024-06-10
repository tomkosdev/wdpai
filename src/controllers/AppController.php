<?php

class AppController {

    private $request;


    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function render (string $template = null, array $variables = []){
        $templePath = 'public/views/'.$template.'.php';

        $output = 'File not found';

        if(file_exists($templePath)){
            extract($variables);


            ob_start();
            include $templePath;
            $output = ob_get_clean();
        }

        print $output;
        return null;
    }


}