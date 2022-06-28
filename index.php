<?php
    /* *******************************************************
    MOSTRAR ERRORES
    ******************************************************* */
    ini_set('display_errors',1); #Permite visualizar errores desde el navegador o desde postman
    ini_set('log_errors',1); # Permite crear el archivo a nivel local
    ini_set('error_log', "C:\wamp64\www\API-REST-CRUD-PHP-DINAMICA\php_error_log"); #La ruta de donde aparecerá el archivo errores y el nombre del archivo

    /* *******************************************************
    REQUERIMIENTOS
    ******************************************************* */
    require_once "models/Connection.php";
    require_once "controllers/RouterController.php";

    #Convierto el archivo Router.php en el archivo principal de mi API REST
    $index = new RouterController();
    $index->index();


