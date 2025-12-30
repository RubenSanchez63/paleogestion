<?php

    namespace Modelos ;
	
	use Clases\Database;
	use Clases\Sesion ;
	
	class Usuario
    {
        private int $idUsu ;
		
	    public private(set) string $user;
        private string $passwordHash;
		
		/**
		 * @param string $password
		 * @return bool
		 */
		private function verify(string $password): bool
		{
			return password_verify($password, $this->passwordHash) ;
		}
	
		
		/**
		 * @param string $user
		 * @param string $password
		 * @return Usuario|null
		 */
		public static function getByUserAndPassword(string $user, string $password): Usuario|false
		{
			$pdo = Database::connect() ;
			$stmt = $pdo->prepare("SELECT * FROM Usuario WHERE user = :user ;") ;
			$stmt->execute([ ":user" => $user, ]) ;
			
			# recuperamos usuario
			$usuario = $stmt->fetchObject(Usuario::class) ;
			
			if (is_object($usuario)):
				if ($usuario->verify($password)):
					return $usuario ;
				endif ;
			endif ;
			
			return false ;
		}
		
		/**
		 * @param int $id
		 * @return Usuario|false
		 */
		public static function getByUser(string $user): Usuario|false
		{
			$pdo = Database::connect() ;
			$stmt = $pdo->prepare("SELECT * FROM Usuario WHERE user = :user") ;
			$stmt->execute([ ":user" => $user ]) ;
			
			# devolvemos el usuario
			return $stmt->fetchObject(Usuario::class) ;
		}



    }
