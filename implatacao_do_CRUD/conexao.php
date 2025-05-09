<?php
    class Conexao{
       private static $instancia;
       public static function pegarConexao(){
            if(!isset(self::$instancia)) {
                self::$instancia = new PDO(
                    "mysql:host=localhost; dbname=cadastropessoa;
                    charset=utf8", "root", "root");
            }
            return self::$instancia;   
       } 
    }
?>