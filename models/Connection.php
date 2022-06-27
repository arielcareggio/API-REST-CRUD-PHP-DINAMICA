<?php

class Connection {
    /* *******************************************************
    INFORMACIÓN DE LA BD
    ******************************************************* */
    static public function infoDataBase(){
        $infoDB = array(
            'database' => "api_rest_crud_php_dinamica",
            'user' => "root",
            'pass' => ""
        );

        return $infoDB;
    }

    /* *******************************************************
    CONEXIÓN A LA BD
    ******************************************************* */
    static public function connect(){
        try{
            $link = new PDO(
                "mysql:host=localhost;dbname=".Connection::infoDataBase()["database"],
                Connection::infoDataBase()["user"],
                Connection::infoDataBase()["pass"]
            );

            $link->exec("set names utf8");

        }catch(PDOException $e){
            die("Error: ".$e->getMessage());
        }

        return $link;
    }
}


    /**
     * Connection
     * Realizamos la conexión a la BD
     */
    /* class Connection extends Mysqli {
        function __construct() {
            parent::__construct('localhost', 'root', '', 'api_rest_crud_php');
            $this->set_charset('utf8');
            $this->connect_error == NULL ? 'Conexión exítosa a la DB' : die('Error al conectarse a la BD');
        }
    } */