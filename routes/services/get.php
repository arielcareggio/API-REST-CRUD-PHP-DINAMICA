<?php
    require_once "controllers/getController.php";

    #Obtenemos la tabla que viene en el primer parámetro de la URL, eliminando todos los demás parámetros,
    #de esta forma como el primer parámetro es la tabla y vino después de un /, eliminamos los siguientes parámetros
    #que vienen después del ?, y solo obtenerlos la tabla 
    $table = explode('?',$routesArray[1])[0];

    #Si en la URL existe el parámetro select entonces significa que nos están solicitando columnas especificas de la tabla
    #esto es lo que hace que la API sea dinámica, junto con el primer parámetro de la tabla
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


    /* *******************************************************
    RANGOS CON FILTROS
    ******************************************************* */
    #Si desde la URL se especifica el rango con filtro de registros:
    $filterTo = $_GET['filterTo'] ?? null; #Columna para el filtro
    $inTo = $_GET['inTo'] ?? null; #id's a filtrar con la columna especificada en filterTo

    $response = new getController();

    /* 
        Preguntamos si la consulta sera con filtro (where) o no, si es con filtro entonces vendrán en la URL los siguientes parámetros:
            linkTo = nombre de la columna (quiero que me linkee (que busque) en este nombre de la columna)
            equalTo = igual a = Búscame los registros que tengan este texto
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

    }else if(!isset($_GET['rel']) && !isset($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])){
        /* *******************************************************
        PETICIONES GET PARA SELECCIÓN DE RANGOS con BETWEEN
        ******************************************************* */
        $response->getDataRange($table, $select, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);

    }else if(isset($_GET['rel']) && isset($_GET['type']) && $table == 'relations' && isset($_GET['linkTo']) && isset($_GET['between1']) && isset($_GET['between2'])){
        /* *******************************************************
        PETICIONES GET PARA SELECCIÓN DE RANGOS con BETWEEN y CON RELACIONES
        ******************************************************* */
        $response->getRelDataRange($_GET['rel'], $_GET['type'], $select, $_GET['linkTo'], $_GET['between1'], $_GET['between2'], $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);

    }else{
        /* *******************************************************
        PETICIONES GET SIN FILTRO
        ******************************************************* */

        #Le solicitamos al controlador que se encargue de solicitar la data de la tabla dada
        $response->getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);
    }

    
    
    