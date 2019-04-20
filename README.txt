1.El primer paso es modificar el programa apoint.ino según sus preferencias ej: la variable host3 debe ser su dirección ip o la de su servidor, las variables httPort, PostData y PostData2, pueden variar dependiendo de si está ejecutando el programa en un entorno local o en un servidor
2.Luego debe cargar el programa apoint.ino en su NodeMCU. 
3.Una vez ejecutado el programa en la NodeMCU, conéctese a la red inalámbrica "iotplant", cuya clave es "12345678" (esto es configurable en el programa apoint.ino).
4.Luego de haberse conectado a "iotplant" diríjase a "http://192.168.4.1/" y coloque el nombre y contraseña de la red wi-fi a la cual se conectará la NodeMCU. 
5.Tras establecer conexión la NodeMCU comenzara a enviar los datos de sus sensores a la página web.
6.Los datos pueden ser visualizados en la aplicación (No olvide importar la base de datos).
7.Para el correcto funcionamiento necesitara un relé, un sensor de humedad y temperatura ambiente, un sensor de humedad de la tierra y una bomba de agua. (Para realizar las conexiones puede guiarse con el programa apoint.ino).

*Cuenta de prueba

user:admin
pass:12345