<?php

namespace jupiter;

abstract class Model
{
    protected static $pdo;

    private static $dbname;
	private static $host;
    private static $user;
    private static $password;
    private static $port;
    private static $socket;

    public function __construct()
    {	

		if (null === self::$pdo){
			try {

				self::$pdo = new \PDO("mysql:dbname=".self::$dbname.";host=".self::$host.";port=".self::$port, self::$user, self::$password);
				self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e){
				die("Failed to connect to Database : ".$e);
			}
		}
	}

	public static function getDbname(){

		return self::$dbname;
	}

	public static function setDbname($dbname){

		self::$dbname = $dbname;
	}

	public static function getHost(){

		return self::$host;
	}

	public static function setHost($host){

		self::$host = $host;
	}

	public static function getUser(){

		return self::$user;
	}

	public static function setUser($user){

		self::$user = $user;
	}

	public static function getPassword(){

		return self::$password;
	}

	public static function setPassword($password){

		self::$password = $password;
	}

	public static function getPort(){

		return self::$port;
	}

	public static function setPort($port){

		self::$port = $port;
	}

	public static function getSocket(){

		return self::$socket;
	}

	public static function setSocket($socket){

		self::$socket = $socket;
	}

	function findOne($placeholders, $values){

		$sql = "SELECT * FROM ".$this->table." WHERE ".$placeholders;
        $query = self::$pdo->prepare($sql);
        $query->execute($values);
        return $query->fetch(\PDO::FETCH_ASSOC);
	}
}