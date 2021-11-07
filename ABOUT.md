## Arranque inicial

1- Instalar los vendors: `composer install`

2- Iniciar el servidor local: `php -S 127.0.0.1:8000 -t public`

## Consideraciones

La estructura inicial del proyecto no se adaptaba a mis necesidades de desarrollarlo siguiendo 
la Arquitectura Hexagonal y DDD, por lo que he tenido que reorganizar algunas cosas. Entre ellas, el ShoutController
estaba en la capa de aplicación, cuando deberia estar en la capa de infrastructura.

He creado una entidad User para asociar los tweets y poder buscarlos por dicho username. 
Para ambas entidades he usado un Value Object que genera el ID usando la libreria de Ramsey de Uuids.

Tambien he tenido que hacer una conversion a UTF-8 de algunos caracteres en los tweets que no 
se codificaban correctamente al contener caracteres especiales. Esto lo he hecho en un DataTransformer para
hacer las transformaciones necesarias sobre los mensajes para devolverlos en mayuscula con la exclamación al final.

Ademas, he metido una capa de cache en el app service para cachear los tweets de un usuario por 1h usando como clave el username y 
el numero de tweets solicitados, por lo que si se pide mas de 1 vez un numero de tweets para un usuario, se devuelve la información cacheada
para evitar hacer consultas y optimizar el tiempo de respuesta. He usado el componente de cache de Symfony para hacerlo sencillo,
pero se podria haber usado cualquier otro como por ejemplo Redis.

He añadido la restriccion del numero de tweets para que el maximo que devuelva el API sea de 10. Si se piden mas de 10, devuelve un error.

## Tests

Para comprobar que todo funciona como se espera, he creado una bateria de tests entre ellos unitarios y funcionales.
Los unitarios comprueban la logica de los app services y del data transformer. Los funcionales comprueban que el endpoint
devuelve lo que se espera del API.

Para lanzar la suite de tests: `bin/phpunit`

## Uso

Tal y como se pedia, desde la consola se puede lanzar el siguiente comando: 

`curl --location --request GET 'http://localhost:8000/shout/realDonaldTrump?limit=2`

Tambien se puede hacer la petición desde Postman.

