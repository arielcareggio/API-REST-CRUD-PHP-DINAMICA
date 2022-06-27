<?php

    #capturamos lo que viene en una URL con $_SERVER['REQUEST_URI']
    #y lo convertimos a un array separando por /
    $routesArray = explode('/',$_SERVER['REQUEST_URI']);
    #Con array_filter eliminamos los campos vacios que genera explode('/',$_SERVER['REQUEST_URI'])
    $routesArray = array_filter($routesArray);


    /* *******************************************************
    CUANDO NO SE HACE NINGUNA PETICIÓN A LA API
    ******************************************************* */
    #validamos que el array no esté vacio, si lo esta devolvemos un 404
    if(count($routesArray) == 0){
        returnJson(404,'Not found');
    }

    /* *******************************************************
    CUANDO SI SE HACEN PETICIONES A LA API
    ******************************************************* */
    #Consultamos si el array tiene un indice y preguntamos si viene un metodo HTTP
    if(count($routesArray) == 1 && isset($_SERVER['REQUEST_METHOD'])){

        /* *******************************************************
        PETICIONES GET
        ******************************************************* */
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            #Lo trabajamos desde el archivo get.php
            include 'services/get.php';
        }
        
        /* *******************************************************
        PETICIONES POST
        ******************************************************* */
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            returnJson(200,'Solicitud POST');
        }

        /* *******************************************************
        PETICIONES PUT
        ******************************************************* */
        if($_SERVER['REQUEST_METHOD'] == 'PUT'){
            returnJson(200,'Solicitud PUT');
        }

        /* *******************************************************
        PETICIONES DELETE
        ******************************************************* */
        if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
            returnJson(200,'Solicitud DELETE');
        }
    }



    /**
     * Retornamos un json con el código y el mensaje
     */
    function returnJson($codigo, $mensaje){
        $json = array(
            'status' => $codigo,
            'result' => $mensaje
        );
    
        #Con http_response_code le indicamos al navegador el código del estado
        echo json_encode($json, http_response_code($json['status']));
        return;
    }
