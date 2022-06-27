# API-REST-CRUD-PHP-DINAMICA

Me encuentro en desarrollo de una API REST FULL totalmente DINÁMICA, en PHP Nativo + MySQL.

Esta API REST FULL servirá para cualquier Base de Datos, con cualquier tabla y columnas, donde será totalmente configurable desde los parámetros, y así poder indicar desde los parámetros los datos que se desean obtener, incluyendo filtros, limitaciones, ordenación, relación entre tablas, entre otros.

Además, será un CRUD completo.

En este momento me encuentro configurando el GET, para que sea dinámico y 100% configurable desde los parámetros, luego continuaré con los verbos PUT, POST y DELETE.

Iré actualizando el código a medida que vaya avanzando.


El código que encontrará aquí se encuentra 100% funcional, por lo que si desean probarlo lo podrán realizar, para ello seguir los siguientes pasos:

1- Crear la DB: api_rest_crud_php_dinamica y ejecutar el SQL que se encuentra en el archivo: Original_dinamica.sql


2- Configurar el dominio apidinamica.com en el local, para esto se deben editar los 2 archivos que mencionamos a continuación:

A) C:\wamp64\bin\apache\apache2.4.51\conf\extra\httpd-vhosts.conf (El directorio de este archivo puede ser diferente dependiendo donde tenga instalado apache)

Se deben agregar las siguientes líneas de textos:

![alt text](https://github.com/arielcareggio/API-REST-CRUD-PHP-DINAMICA/blob/master/config_1.png?raw=true)
(El directorio "C:\wamp64\www\API-REST-CRUD-PHP-DINAMICA" también puede cambiar dependiendo donde tenga su directorio local instalado)


B) C:\Windows\System32\drivers\etc\hosts

Se debe agregar la siguiente linea de texto:

![alt text](https://github.com/arielcareggio/API-REST-CRUD-PHP-DINAMICA/blob/master/config_2.png?raw=true)


3- Importar los métodos de prueba en Postman con el archivo: APIREST.postman_collection.json


![alt text](https://github.com/arielcareggio/API-REST-CRUD-PHP-DINAMICA/blob/master/Postman.png?raw=true)
