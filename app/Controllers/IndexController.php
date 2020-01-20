<?php
    namespace App\Controllers;
    use App\Models\Usuario;


    class IndexController extends BaseController { 
        public function indexAction(){
            $usuarios = Usuario::all();

            return $this->renderHTML('index.twig', [
                'usuarios' => $usuarios
            ]);
        }
    }
?>