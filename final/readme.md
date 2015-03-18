----- Trabajo final de Proyecto de Software 2014 ----

Integrantes: Dante Barba, Jonathan Lozcalzo.

Framework utilizado: Laravel 4.2

Base de datos: Mysql

Documentación se encuentra en /final/docs. Allí se describen las consignas presentadas.

Para acceder a la página web, se debe usar la dirección /final/public como índice, todas las rutas se encuentran a partir de /final/public/

Puntos a considerar a la hora de utilizar la App:

-Unicamente se realizaron las vistas: index, login, backend, estadísticas, ABM de Usuarios, Editar Usuario debido a que era lo solicitado por el enunciado. El resto de los links se encuentran inoperativos.

-La pagina base del proyecto esta deshabilitada también, automáticamente se redirige a la pagina Final.

-Se consideraron a los roles como parte del Login.

Usuario Admin: admin1 
Pass: 123456

Usuario Gestion: gestion1
Pass: 123456

Usuario Consulta: consulta1
Pass: 123456

Si bien se implementaron los roles, tenga en cuenta que no es posible probar las funcionalidades de los roles debido a que no estaban incluidas en el enunciado. Unicamente puede intentar acceder a /final/public/backend/usuarios con por ej. un usuario Consulta y ver como es rechazado por el servidor. 

Tenga en cuenta también que los datos para generar las Estadísticas estan pre-cargados con un muestreo básico. Se incluirá un boton para resetear toda la base de datos al muestreo inicial. Esto se debe a que para generar los datos de Estadisticas se requieren otras funcionalidades que no serán incluidas.






