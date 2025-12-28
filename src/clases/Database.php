<?php
namespace Clases ;
use PDO ;
	
	final class Database
	{
		private const DBHOST = "db" ;
		private const DBUSER = "root" ;
		private const DBPASS = "root" ;
		private const DBNAME = "PaleoGestion" ;
		
		private function __clone() {}
		private function __construct() {}
		
		/**
		 * @return \PDO\Mysql|null
		 */
		public static function connect(): ?\PDO\Mysql
		{
			try {
				$dsn = "mysql:host=".self::DBHOST.";dbname=".self::DBNAME.";charset=utf8";
				return PDO::connect($dsn, self::DBUSER, self::DBPASS) ;
				
			} catch(\PDOException $pdoe) {
				die("**ERROR: " . $pdoe->getMessage()) ;
			}
		}
	}