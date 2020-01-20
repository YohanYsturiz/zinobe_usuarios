<?php
    namespace App\Controllers;
    use App\Models\Usuario;
    use Respect\Validation\Validator as validador;
    use Zend\Diactoros\Response\RedirectResponse;

    class UsuarioController extends BaseController {

        public function create(){
            return $this->renderHTML('registroUsuario.twig');
        }

        public function store($request){
            // Datos recibidos del Post
            $data = $request->getParsedBody();
            $responseMessage = "";
            
            $usuarioValidator = validador::key('nombre', validador::stringType()->notEmpty())
            ->key('email', validador::stringType()->notEmpty())
            ->key('documento', validador::notEmpty())
            ->key('password', validador::notEmpty());

            // Validamos el arreglo recibido
            try{

                $usuarioValidator->assert($data);
                $usuario = new Usuario();
                $usuario->nombre = $data['nombre'];
                $usuario->email = $data['email'];
                $usuario->documento = $data['documento'];
                $usuario->password = password_hash($data['password'], PASSWORD_DEFAULT);
                $usuario->save();

                $responseMessage = "Guardado";

            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }

            return $this->renderHTML('registroUsuario.twig', [
                'responseMessage' => $responseMessage
            ]);
        }

        public function iniciarSesion(){
            return $this->renderHTML('iniciarSesion.twig');
        }

        public function authSesion($request){
            $data = $request->getParsedBody();
            $responseMessage = "";
            $usuario = Usuario::where('email', $data['email'])->first();

            if($usuario) {
                if (\password_verify($data['password'], $usuario->password)) {
                    $_SESSION['userId'] = $usuario->id;
                    return new RedirectResponse('/zinobe_usuarios/lista');
                } else {
                    $responseMessage = "Correo o contraseña incorrecta";
                }
            } else {
                $responseMessage = "Correo o contraseña incorrecta";
            }

            return $this->renderHTML('iniciarSesion.twig', [
                'responseMessage' => $responseMessage,
                'session' => $_SESSION
            ]);
        }

        public function logout() {
            unset($_SESSION['userId']);
            return new RedirectResponse('/zinobe_usuarios/iniciar-sesion');
        }


        public function buscador($request) {
            $data = $request->getParsedBody();
            
            $usuarios = Usuario::where('email', 'LIKE', '%'.$data['filtro'].'%')
            ->orWhere('nombre', 'LIKE', '%'.$data['filtro'].'%')->get();

            return $this->renderHTML('index.twig', [
                'usuarios' => $usuarios
            ]);
        }

    }
?>