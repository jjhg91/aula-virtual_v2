# AULA VIRTUAL (version 2)
Se creo un aula virtual bajos las necesidades de las clases a distancias arraigado por la pandemia a nivel mundial y las medidas preventivas tomadas por los organizmos de salud de distintos paises.

El aula virtual cuenta con diferentes modulos para una mejor organizacion y control de los alumnos a nivel universitario, cuenta con dos tipos de perfiles diferentes de alumno y profesor, los cuales se pueden observar los diferentes modulos por cada asignatura registrada con el:

	Conetenido
	Plan de Evaluacion
	Evaluaciones
	Blog
	Foro
	Alumnos
	Cargar Nota

------------
### *NOVEDADES*
**Se realizo una reestrucutracion en el patron de la arquitectura de software de la aplicacion utilizando un patron Modelo-Vista-Controlador (MVC).**

**De igual manera se comenzo a utilizar un paradigma de programacion orientado a objetos (POO).**

**Se comenzo a utilizar javascripts para las validaciones y las conexciones asincronas en HttpRequest con el servidor, de esta manera obteniendo un mejor resultado en la experiencia del usuario al no tener que refrescar la pantalla y liberando al servidor de altas transferencias de datos.**

**Se creo un panel administrativo del aula virtual.**

------------



### INTALACION

Para su instalacion de debera contar con la version de php mayor a 5.6.

Constar con mysql dos bases de datos, las cuales llevaran de nombre **aula** y **jmc**. las cuales se restauraran desde los respectivos archivos aula.sql y jmc.sql ubicados en la raiz del repositorio. El archivo de configuracion de la conexion con la base de datos se encuenta en: `config/config.php`

modificar la declaracion estatica la URL en el achivo: `config/config.php`

##### USUARIOS DE PRUEBA

`PROFESOR DE PRUEBA, USUARIOS Y CONTRASEÑA:  18051065`

`ESTUDIANTE DE PRUEBA, USUARIOS Y CONTRASEÑA: 31699106`

------------


### USO
Cada modulo de la aplicacion tiene diferentes objetivos para la evaluacion y interaccion del alumno y el profesor.

>##### CONTENIDO
>Estara dedicado para que el profesor pueda ingresar todo el temario de contenido que este impartira en su materia y asi el alumno tenga un facil acceso a estos.
> 
>##### PLAN DE EVALUACION
>  Un area para donde el profesor creara su planificacion de trabajo a evaluar en la asignatura y los alumnos puedan observarla y estar informados referente al tipo de evalaucion, tema y fecha de la lisma.
> 
>##### EVALUACIONES
>  El profesor podra crear actividades evaluativas referentes al plan de evaluacion para que el alumno pueda cargar archivos y comentar dichas avtividades creadas por el profesor.
> 
>##### BLOG
> Un area para que el profesor pueda subir informacion referente a la materia y de interes para el alumno, como tambien materiales de apoyo que puedan ayudar al estudiante.
> 
>##### FORO
> Un area de discusion de diferentes temas, entre el profesor y los alumnos que integran  esa asignatura.
> 
>##### ALUMNOS
> Una lista de todos los alumnos que integran la asignatura, solo la puede observar el profesor.
> 
>##### CARGAR NOTA
> Un area para que el profesor pueda cargar las notas de los alumnos en cada actividad planteada en el plan de evaluaciones.
> 
