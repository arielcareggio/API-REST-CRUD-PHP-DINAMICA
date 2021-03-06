<?php
    require_once "models/getModel.php";

    class getController{

        /* *******************************************************
        PETICIONES GET SIN FILTRO 
        ******************************************************* */
        /**
         * Función que llama al modelo solicitando la info de la DB
         */
        static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);

            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }


        /* *******************************************************
        PETICIONES GET CON FILTRO
        ******************************************************* */
        /**
         * Función que llama al modelo solicitando la info de la DB con los filtros informados
         */
        static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }


        /* *******************************************************
        PETICIONES GET SIN FILTRO CON TABLAS RELACIONADAS
        ******************************************************* */
        public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }

        /* *******************************************************
        PETICIONES GET CON FILTRO CON TABLAS RELACIONADAS
        ******************************************************* */
        public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }


        /* *******************************************************
        PETICIONES GET PARA EL BUSCADOR SIN RELACIONES
        ******************************************************* */
        public function getDataSearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getDataSearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }


        /* *******************************************************
        PETICIONES GET PARA EL BUSCADOR CON TABLAS RELACIONADAS
        ******************************************************* */
        public function getRelDataSearch($rel, $type, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getRelDataSearch($rel, $type, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }


        /* *******************************************************
        PETICIONES GET PARA SELECCIÓN DE RANGOS con BETWEEN
        ******************************************************* */
        public function getDataRange($table, $select, $linkTo, $between1, $between2, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getDataRange($table, $select, $linkTo, $between1, $between2, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }

        /* *******************************************************
        PETICIONES GET PARA SELECCIÓN DE RANGOS con BETWEEN y CON RELACIONES
        ******************************************************* */
        public function getRelDataRange($rel, $type, $select, $linkTo, $between1, $between2, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo){
            #Llamamos al modelo solicitando la info de la DB
            $response = GetModel::getRelDataRange($rel, $type, $select, $linkTo, $between1, $between2, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
            
            #Tenemos que procesar lo devuelto por el modelo para poder devolverlo en formato requerido, esto lo hacemos con la función fncResponde()
            $return = new getController();
            $return->fncResponde($response);

            //return $response; //Se lo devolvemos a get.php
        }



        /* *******************************************************
        RESPUESTAS DEL CONTROLADOR
        ******************************************************* */
        /**
         * Función de respuesta
         * Para mostrar en formato json la info que nos devolvió el modelo 
         */
        public function fncResponde($response){
            #Si no viene vacío
            if(!empty($response)){
                $json = array(
                    'status' => 200,
                    'total' => count($response),
                    'results' => $response
                );
            }else{
                #Si viene vacío
                $json = array(
                    'status' => 404,
                    'results' => 'Not found'
                );
            }

            #Con http_response_code le indicamos al navegador el código del estado
            echo json_encode($json, http_response_code($json['status']));
        }
    }