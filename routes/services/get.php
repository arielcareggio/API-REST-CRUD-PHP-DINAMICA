<?php
    require_once "controllers/getController.php";

    #Obtenermos la tabla que viene en el primer parametro de la URL, eliminando todos los demás parametros,
    #de esta forma como el primer parametro es la tabla y vino despues de un /, eliminamos los siguientes parametros
    #que vienen despues del ?, y solo obtenermos la tabla
    $table = explode('?',$routesArray[1])[0];

    #Si en la URL existe el parametro select entonces significa que nos estan solicitando columnas especificas de la tabla
    #esto es lo que hace que la API sea dinamica, junto con el primer parametro de la tabla
    $select = $_GET['select'] ?? '*';

    /* *******************************************************
    ORDER BY
    ******************************************************* */
    #Si desde la URL se especifica el orden para ordenar los registros:
    $orderBy = $_GET['orderBy'] ?? null; #Especifica la columna por la que desea ordenar
    $orderMode = $_GET['orderMode'] ?? null; #Especifica si desea de forma ASC o DESC

    /* *******************************************************
    LIMIT DE REGISTROS
    ******************************************************* */
    #Si desde la URL se especifica el limite de registros:
    $startAt = $_GET['startAt'] ?? null; #Especifica desde que registro obtener
    $endAt = $_GET['endAt'] ?? null; #Especifica hasta que registro obtener


    $response = new getController();

    /* 
        Preguntamos si la consulta sera con filtro (where) o no, si es con filtro entonces vendran en la URL los siguientes parametros:
            linkTo = nombre de la columna (quiero que me linkee (que busque) en este nombre de la columna)
            equalTo = igual a = Buscame los registros que tengan este texto
    */
    if(isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['rel']) && !isset($_GET['type'])){
        /* *******************************************************
        PETICIONES GET CON FILTRO
        ******************************************************* */

        #Le solicitamos al controlador que se encargue de solicitar la data de la tabla dada con los filtros informados
        $response->getDataFilter($table, $select, $_GET['linkTo'], $_GET['equalTo'], $orderBy, $orderMode, $startAt, $endAt);

    }else if(isset($_GET['rel']) && isset($_GET['type']) && $table == 'relations' && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])){
        /* *******************************************************
        PETICIONES GET SIN FILTRO CON TABLAS RELACIONADAS
        ******************************************************* */

        $response->getRelData($_GET['rel'], $_GET['type'], $select, $orderBy, $orderMode, $startAt, $endAt);

    }else if(isset($_GET['rel']) && isset($_GET['type']) && $table == 'relations' && isset($_GET['linkTo']) && isset($_GET['equalTo'])){
        /* *******************************************************
        PETICIONES GET CON FILTRO CON TABLAS RELACIONADAS
        ******************************************************* */

        $response->getRelDataFilter($_GET['rel'], $_GET['type'], $select, $_GET['linkTo'], $_GET['equalTo'], $orderBy, $orderMode, $startAt, $endAt);

    }else if(isset($_GET['linkTo']) && isset($_GET['search']) && !isset($_GET['rel']) && !isset($_GET['type'])){
        /* *******************************************************
        PETICIONES GET PARA EL BUSCADOR SIN RELACIONES
        ******************************************************* */
        $response->getDataSearch($table, $select, $_GET['linkTo'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt);

    }else if(isset($_GET['rel']) && isset($_GET['type']) && $table == 'relations' && isset($_GET['linkTo']) && isset($_GET['search'])){
        /* *******************************************************
        PETICIONES GET PARA EL BUSCADOR CON RELACIONES
        ******************************************************* */
        $response->getRelDataSearch($_GET['rel'], $_GET['type'], $select, $_GET['linkTo'], $_GET['search'], $orderBy, $orderMode, $startAt, $endAt);

    }else{
        /* *******************************************************
        PETICIONES GET SIN FILTRO
        ******************************************************* */

        #Le solicitamos al controlador que se encargue de solicitar la data de la tabla dada
        $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
    }

    
    
    