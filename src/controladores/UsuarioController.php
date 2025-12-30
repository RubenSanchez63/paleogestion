<?php
	
	namespace Controladores;

    use Modelos\Usuario; 
    use Clases\Sesion;
	
	class UsuarioController extends BaseController{
		
        public static function sesionActiva() : bool {
            return Sesion::active() && Usuario::getByUser(Sesion::get('user'));
        }

        public function login() : string {
            if (Usuario::getByUserAndPassword($_POST['user'], $_POST['password'])) {
                Sesion::init(Usuario::getByUser($_POST['user']));
                return "true";
            }
            return "false";
        }

        public function logout() : void {
            Sesion::close();
            // Borramos la cookie de sesion del navegador
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
	}