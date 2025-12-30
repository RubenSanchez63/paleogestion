<?php
namespace Clases ;
use PDO ;
	
	final class Database
	{
		private const string DBHOST = "db" ;
		private const string DBUSER = "root" ;
		private const string DBPASS = "root" ;
		private const string DBNAME = "PaleoGestion" ;
		
		private static ?PDO $instance = null;

		private function __clone() {}
		private function __construct() {}
		
		/**
		 * Devuelve la conexión PDO a la base de datos
		 * @return PDO
		 */
		public static function connect(): PDO
		{
			if (self::$instance === null) {
				try {
					$dsn = "mysql:host=" . self::DBHOST . ";dbname=" . self::DBNAME . ";charset=utf8mb4";
					self::$instance = PDO::connect($dsn, self::DBUSER, self::DBPASS);
				} catch(\PDOException $pdoe) {
					die("**ERROR DE CONEXIÓN: " . $pdoe->getMessage()) ;
				}
			}
			return self::$instance;
		}
	}