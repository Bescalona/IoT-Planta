1.El primer paso es modificar el programa apoint.ino seg�n sus preferencias ej: la variable host3 debe ser su direcci�n ip o la de su servidor, las variables httPort, PostData y PostData2, pueden variar dependiendo de si est� ejecutando el programa en un entorno local o en un servidor
2.Luego debe cargar el programa apoint.ino en su NodeMCU. 
3.Una vez ejecutado el programa en la NodeMCU, con�ctese a la red inal�mbrica "iotplant", cuya clave es "12345678" (esto es configurable en el programa apoint.ino).
4.Luego de haberse conectado a "iotplant" dir�jase a "http://192.168.4.1/" y coloque el nombre y contrase�a de la red wi-fi a la cual se conectar� la NodeMCU. 
5.Tras establecer conexi�n la NodeMCU comenzara a enviar los datos de sus sensores a la p�gina web.
6.Los datos pueden ser visualizados en la aplicaci�n (No olvide importar la base de datos).
7.Para el correcto funcionamiento necesitara un rel�, un sensor de humedad y temperatura ambiente, un sensor de humedad de la tierra y una bomba de agua. (Para realizar las conexiones puede guiarse con el programa apoint.ino).

*Cuenta de prueba

user:admin
pass:12345