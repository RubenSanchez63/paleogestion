<?php
	
	namespace Clases ;
	
	use Modelos\Usuario ;
	
	final class Sesion
	{
		const MAX_TIEMPO = 18000 ;
		
		/**
		 * @return void
		 */
		public static function update(): void
		{
			self::set("tiempo", time()) ;
		}
		
		/**
		 * @return void
		 */
		public static function init(Usuario $usuario): void
		{
			self::set("user", $usuario->user) ;
			self::update() ;
		}
		
		/**
		 * @return bool
		 */
		public static function active(): bool
		{
			return (session_status() === PHP_SESSION_ACTIVE) &&
				   (self::get("user")) &&
				   ((time() - self::get("tiempo")) <= self::MAX_TIEMPO)	;
		}
		
		/**
		 * @param string $clave
		 * @param mixed $valor
		 * @return void
		 */
		public static function set(string $clave, mixed $valor): void
		{
			$_SESSION[$clave] = $valor ;
		}
		
		/**
		 * @param string $clave
		 * @return mixed
		 */
		public static function get(string $clave): mixed
		{
			#return $_SESSION[$clave]??null ;
			return $_SESSION[$clave] ;
		}
		
		/**
		 * @return void
		 */
		public static function close(): void
		{
			# cerramos la sesión
			$_SESSION = [] ;
			session_destroy() ;
		}
	}
