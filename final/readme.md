## Trabajo final de Proyecto de Software 2014

#####Integrantes: Dante Barba, Jonathan Loscalzo.
#####Framework utilizado: Laravel 4.2
#####Base de datos: Mysql

Documentación se encuentra en **/final/docs**. Allí se describen las consignas presentadas y el informe sobre el framework.
>Para acceder a la página web, se debe usar la dirección /final/public como índice, todas las rutas se encuentran a partir de /final/public/

#####Puntos a considerar a la hora de utilizar la App

- Unicamente se realizaron las vistas: index, login, backend, estadísticas, ABM de Usuarios, Editar Usuario debido a que era lo solicitado por el enunciado. El resto de los links no se encuentran operativos.
- La pagina base del proyecto esta deshabilitada también, automáticamente se redirige a la pagina Final.
- Se consideraron a los roles como parte del Login.
 - Usuario Admin: admin1 Pass: 123456
 - Usuario Gestion: gestion1 Pass: 123456
 - Usuario Consulta: consulta1 Pass: 123456

>Si bien se implementaron los roles, tenga en cuenta que no es posible probar las funcionalidades de los roles debido a que no estaban incluidas en el enunciado. Únicamente puede intentar acceder a **/final/public/backend/usuarios** con por ej. un usuario Consulta y ver como es rechazado por el servidor.

#####Ver el funcionamiento con datos (DataSeed)

Tenga en cuenta también que los datos para generar las Estadísticas están pre-cargados con un muestreo básico. Esto se debe a que para generar los datos de Estadisticas se requieren otras funcionalidades que no serán incluidas.
Los datos que se deben ingresar para probar la funcionalidad de estadísticas son:
- Gráfico 1: 1ro de Diciembre de 2014, a 31 de Enero de 2015.
- Grafico 2: 1ro de Diciembre de 2014, a 31 de Enero de 2015.
- Grafico 3: Se pone el botón actualizar y carga datos directamente.