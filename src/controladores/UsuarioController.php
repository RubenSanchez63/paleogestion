<?php
	
	namespace Controladores;

    use Modelos\Usuario; 
    use Clases\Sesion;
	
	class UsuarioController extends BaseController{
		
        public static function sesionActiva() : bool {
            return Sesion::active() && Usuario::getByUser(Sesion::get('user'));
        }

        public function login() : void {
            if (Usuario::getByUserAndPassword($_POST['user'], $_POST['password'])) {
                Sesion::init(Usuario::getByUser($_POST['user']));
            }
        }

        public function logout() : void {
            Sesion::close();
        }
	}