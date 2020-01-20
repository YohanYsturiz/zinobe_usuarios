<?php
    namespace App\Controllers;
    use App\Models\Usuario;

    class UsuarioController extends BaseController {

        public function create(){
            return $this->renderHTML('registroUsuario.twig');
        }

        public function store($request){

            if($request->getMethod() == "POST"){
                $data = $request->getParsedBody();

                $usuario = new Usuario();
                $usuario->nombre = $data['nombre'];
                $usuario->email = $data['email'];
                $usuario->documento = $data['documento'];
                $usuario->password = $data['password'];
                $usuario->save();
            }

            echo $this->renderHTML('registroUsuario.twig');
        }

    }
?>