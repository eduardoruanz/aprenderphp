<?php 

namespace sistema\Nucleo;

use Exception;
use PDO;
use PDOException;

/**
 * Classe de conexão com banco de dados
 * 
 * @author Eduardo Ruan
 */

class Conexao {
    private static $instancia;

    public static function getInstancia(): PDO {
        if(empty(self::$instancia)) {
            try {
                self::$instancia = new PDO('mysql:host='.DB_HOST.';port='.PORT.';dbname='.DB_NAME,USER, SENHA,[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]);
            } catch(PDOException $ex) {
                die('Erro de conexao:: '. $ex);
            }

            
        }
        return self::$instancia;
    }

    protected function __construct()
    {
        
    }

    private function __clone(): void
    {
        
    }
}