<?php
    require_once "connection.php";

    class getModel{

        /* *******************************************************
        PETICIONES GET SIN FILTRO
        ******************************************************* */
        /**
         * Función que va a la DB en busqueda de los datos de la determinada tabla
         */
        static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt){
            #Preparamos la consulta
            $sql = "SELECT $select FROM $table";

            /* *******************************************************
            ORDER BY
            ******************************************************* */
            if($orderBy != null && $orderMode != null){
                #Preparamos la consulta con ORDER BY
                $sql .= " ORDER BY $orderBy $orderMode";
            }

            /* *******************************************************
            LIMIT
            ******************************************************* */
            if($startAt != null && $endAt != null){
                #Preparamos la consulta con ORDER BY
                $sql .= " LIMIT $startAt, $endAt";
            }

            #Hacemos la conexión y preparamos la sentencia
            $stmt = Connection::connect()->prepare($sql);
            #Ejecutamos la consulta
            $stmt->execute();
            #Retornamos la respuesta, por parametro le enviamos PDO::FETCH_CLASS para que NO nos devuelva los indices de las columnas, de esta manera solo nos
            #trae los nombres de las columnas y su contenido
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }


        /* *******************************************************
        PETICIONES GET CON FILTRO
        ******************************************************* */
        /**
         * Función que va a la DB en busqueda de los datos de la determinada tabla
         */
        static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

            #Como por la URL se pueden recibir varias columnas, tenemos que trabajarla:
            #Las columnas a filtrar estaran separados por ','
            $linkToArray = explode(",",$linkTo);
            #Como por la URL se pueden recibir varios valores a filtrar, tenemos que trabajarla:
            #Los valores a filtrar estaran separados por '_'
            $equalToArray = explode("_",$equalTo);

            #A continuación preguntamos si el linkToArray es mayor a 1, si lo es entonces significa que vienen más de una columna, por lo que
            #tenemos que agregar AND, para esto lo hacemos con un foreach
            $linkToText = "";
            if(count($linkToArray) > 1){
                foreach($linkToArray as $key => $value){
                    #Tomamos a partir de la segunda posición
                    if($key > 0){
                        $linkToText .= "AND ".$value." = :".$value." ";
                    }
                }
            }

            #Preparamos la consulta, enlasando en el WHERE el nombre de la primer columna con '$linkToArray[0]' y los AND con '$linkToText' en caso de corresponder
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";
            # **ENLACES DE PARAMETROS POR SEGURIDAD**, por esto no podemos poner $equalTo en la consulta, si no que hay que enlasarlo despues de la conexión, esto se
            #hace poniendo en la consulta armada "sql" el mismo nombre de la columna con unos :previos => :$linkToArray[0], esto informa que se enlasaran parametros
            #luego de la conexión

            /* *******************************************************
            ORDER BY
            ******************************************************* */
            if($orderBy != null && $orderMode != null){
                #Preparamos la consulta con ORDER BY
                $sql .= " ORDER BY $orderBy $orderMode";
            }

            /* *******************************************************
            LIMIT
            ******************************************************* */
            if($startAt != null && $endAt != null){
                #Preparamos la consulta con ORDER BY
                $sql .= " LIMIT $startAt, $endAt";
            }

            #Hacemos la conexión y preparamos la sentencia
            $stmt = Connection::connect()->prepare($sql);

            # **ENLACES DE PARAMETROS POR SEGURIDAD**, agregamos el parametro del WHERE y los AND en caso de corresponder.
            #Para el WHERE siempre va a pasar, por lo que no tenemos que validar si 
            foreach($linkToArray as $key => $value){
                #Con bindParam enlazamos parametros, donde como primer parametro va el nombre de la columna, segundo parametro el valor a buscar 
                $stmt->bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR);
            }


            

            #Ejecutamos la consulta
            $stmt->execute();
            #Retornamos la respuesta, por parametro le enviamos PDO::FETCH_CLASS para que NO nos devuelva los indices de las columnas, de esta manera solo nos
            #trae los nombres de las columnas y su contenido
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }


        /* *******************************************************
        PETICIONES GET CON TABLAS RELACIONADAS SIN FILTRO
        ******************************************************* */
        /**
         * Función que va a la DB en busqueda de los datos de las tablas RELACIONADAS
         */
        static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt){

            #Las columnas a filtrar estaran separados por ',', ejemplo:
            #apidinamica.com/relations?rel=clientes,clientes_tipos&type=cliente,tipo
            $relArray = explode(",", $rel);
            $typeArray = explode(",", $type);

            #Preparamos la consulta, recordemos que la tabla principal esta en la primer posición del arreglo $relArray
            #un ejemplo de lo que deberia quedar: 
            #$sql = "SELECT $select FROM clientes    INNER JOIN  clientes_tipos ON clientes.id_cliente           = clientes_tipos.id_cliente_tipo";
            #$sql = "SELECT $select FROM $relArray[0] INNER JOIN  $relArray[1]   ON $relArray[0].id_$typeArray[0] = $relArray[1].id_$typeArray[0]_$typeArray[1]";
            
            #Si tenemos relaciones entre varias tablas tenemos que armar todos los INNER JOIN, esto lo hacemos con un for
            $innerJoinText = "";
            if(count($relArray) > 1){
                foreach($relArray as $key => $value){
                    #Tomamos a partir de la segunda posición, ya que en la primer posición viene la tabla principal
                    if($key > 0){
                        $innerJoinText .= " INNER JOIN  $value ON $relArray[0].id_$typeArray[0] = $value.id_$typeArray[0]_$typeArray[$key] ";
                    }
                }

                $sql = "SELECT $select FROM $relArray[0] $innerJoinText";


                /* *******************************************************
                ORDER BY
                ******************************************************* */
                if($orderBy != null && $orderMode != null){
                    #Preparamos la consulta con ORDER BY
                    $sql .= " ORDER BY $orderBy $orderMode";
                }

                /* *******************************************************
                LIMIT
                ******************************************************* */
                if($startAt != null && $endAt != null){
                    #Preparamos la consulta con ORDER BY
                    $sql .= " LIMIT $startAt, $endAt";
                }

                #Hacemos la conexión y preparamos la sentencia
                $stmt = Connection::connect()->prepare($sql);
                #Ejecutamos la consulta
                $stmt->execute();
                #Retornamos la respuesta, por parametro le enviamos PDO::FETCH_CLASS para que NO nos devuelva los indices de las columnas, de esta manera solo nos
                #trae los nombres de las columnas y su contenido
                return $stmt->fetchAll(PDO::FETCH_CLASS);
            }else{
                return null;
            }
        }

        /* *******************************************************
        PETICIONES GET CON TABLAS RELACIONADAS CON FILTRO
        ******************************************************* */
        /**
         * Función que va a la DB en busqueda de los datos de las tablas RELACIONADAS CON FILTRO
         */
        static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

            /* *******************************************************
            ORGANIZAMOS LOS FILTRO
            ******************************************************* */

            #Como por la URL se pueden recibir varias columnas, tenemos que trabajarla:
            #Las columnas a filtrar estaran separados por ','
            $linkToArray = explode(",",$linkTo);
            #Como por la URL se pueden recibir varios valores a filtrar, tenemos que trabajarla:
            #Los valores a filtrar estaran separados por '_'
            $equalToArray = explode("_",$equalTo);

            #A continuación preguntamos si el linkToArray es mayor a 1, si lo es entonces significa que vienen más de una columna, por lo que
            #tenemos que agregar AND, para esto lo hacemos con un foreach
            $linkToText = "";
            if(count($linkToArray) > 1){
                foreach($linkToArray as $key => $value){
                    #Tomamos a partir de la segunda posición
                    if($key > 0){
                        $linkToText .= "AND ".$value." = :".$value." ";
                    }
                }
            }


            /* *******************************************************
            ORGANIZAMOS LAS RELACIONES
            ******************************************************* */
            #Las columnas a filtrar estaran separados por ',', ejemplo:
            #apidinamica.com/relations?rel=clientes,clientes_tipos&type=cliente,tipo
            $relArray = explode(",", $rel);
            $typeArray = explode(",", $type);
            
            #Preparamos la consulta, recordemos que la tabla principal esta en la primer posición del arreglo $relArray
            #un ejemplo de lo que deberia quedar: 
            #$sql = "SELECT $select FROM clientes    INNER JOIN  clientes_tipos ON clientes.id_cliente           = clientes_tipos.id_cliente_tipo";
            #$sql = "SELECT $select FROM $relArray[0] INNER JOIN  $relArray[1]   ON $relArray[0].id_$typeArray[0] = $relArray[1].id_$typeArray[0]_$typeArray[1]";
            
            #Si tenemos relaciones entre varias tablas tenemos que armar todos los INNER JOIN, esto lo hacemos con un for
            $innerJoinText = "";
            if(count($relArray) > 1){
                foreach($relArray as $key => $value){
                    #Tomamos a partir de la segunda posición, ya que en la primer posición viene la tabla principal
                    if($key > 0){
                        $innerJoinText .= " INNER JOIN  $value ON $relArray[0].id_$typeArray[0] = $value.id_$typeArray[0]_$typeArray[$key] ";
                    }
                }

                $sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";


                /* *******************************************************
                ORDER BY
                ******************************************************* */
                if($orderBy != null && $orderMode != null){
                    #Preparamos la consulta con ORDER BY
                    $sql .= " ORDER BY $orderBy $orderMode";
                }

                /* *******************************************************
                LIMIT
                ******************************************************* */
                if($startAt != null && $endAt != null){
                    #Preparamos la consulta con ORDER BY
                    $sql .= " LIMIT $startAt, $endAt";
                }

                #Hacemos la conexión y preparamos la sentencia
                $stmt = Connection::connect()->prepare($sql);

                # **ENLACES DE PARAMETROS POR SEGURIDAD**, agregamos el parametro del WHERE y los AND en caso de corresponder.
                #Para el WHERE siempre va a pasar, por lo que no tenemos que validar si 
                foreach($linkToArray as $key => $value){
                    #Con bindParam enlazamos parametros, donde como primer parametro va el nombre de la columna, segundo parametro el valor a buscar 
                    $stmt->bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR);
                }

                #Ejecutamos la consulta
                $stmt->execute();
                #Retornamos la respuesta, por parametro le enviamos PDO::FETCH_CLASS para que NO nos devuelva los indices de las columnas, de esta manera solo nos
                #trae los nombres de las columnas y su contenido
                return $stmt->fetchAll(PDO::FETCH_CLASS);
            }else{
                return null;
            }
        }

        /* *******************************************************
        PETICIONES GET PARA EL BUSCADOR SIN RELACIONES
        ******************************************************* */
        static public function getDataSearch($table, $select, $linkTo, $search, $orderBy, $orderMode, $startAt, $endAt){

            $linkToArray = explode(",",$linkTo);
            $searchArray = explode("_",$search);

            #A continuación preguntamos si el linkToArray es mayor a 1, si lo es entonces significa que vienen más de una columna, por lo que
            #tenemos que agregar AND, para esto lo hacemos con un foreach
            $linkToText = "";
            if(count($linkToArray) > 1){
                foreach($linkToArray as $key => $value){
                    #Tomamos a partir de la segunda posición
                    if($key > 0){
                        $linkToText .= "AND ".$value." = :".$value." ";
                    }
                }
            }


            #Preparamos la consulta
            $sql = "SELECT $select FROM $table WHERE  $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText";
            

            /* *******************************************************
            ORDER BY
            ******************************************************* */
            if($orderBy != null && $orderMode != null){
                #Preparamos la consulta con ORDER BY
                $sql .= " ORDER BY $orderBy $orderMode";
            }

            /* *******************************************************
            LIMIT
            ******************************************************* */
            if($startAt != null && $endAt != null){
                #Preparamos la consulta con ORDER BY
                $sql .= " LIMIT $startAt, $endAt";
            }

            #Hacemos la conexión y preparamos la sentencia
            $stmt = Connection::connect()->prepare($sql);

            # **ENLACES DE PARAMETROS POR SEGURIDAD**, agregamos el parametro del WHERE y los AND en caso de corresponder.
            #Para el WHERE siempre va a pasar, por lo que no tenemos que validar si 
            foreach($linkToArray as $key => $value){
                #Con bindParam enlazamos parametros, donde como primer parametro va el nombre de la columna, segundo parametro el valor a buscar 
                if($key > 0){
                    $stmt->bindParam(":".$value, $searchArray[$key], PDO::PARAM_STR);
                }
            }

            #Ejecutamos la consulta
            $stmt->execute();
            #Retornamos la respuesta, por parametro le enviamos PDO::FETCH_CLASS para que NO nos devuelva los indices de las columnas, de esta manera solo nos
            #trae los nombres de las columnas y su contenido
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }

    }