<?php
    namespace App\Controllers;
    use Zend\Diactoros\Response\HtmlResponse;

    class BaseController {
        protected $templateEngine;
        
        public function __construct() {
            $loader = new \Twig\Loader\FilesystemLoader('../views');
            $this->templateEngine = new \Twig\Environment($loader, [
                'debug' => true,
                'cache' => false
            ]);

            $this->templateEngine->addGlobal("session", $_SESSION);
        }
    
        public function renderHtml($fileName, $data = []){
            return new HtmlResponse($this->templateEngine->render($fileName, $data));
        }
    }

?>

