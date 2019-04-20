CREATE DATABASE IF NOT EXISTS test_final;
USE test_final;

CREATE TABLE medicion (
	id					int(4) auto_increment not null,
	humedad_tierra		int(10),
	humedad_aire		float(10),
	temperatura_aire	float(10),
	fecha				timestamp,
	mykey 				varchar(100),
	CONSTRAINT pk_medicion PRIMARY KEY(id)
); 

/*CREATE TABLE humedad(
	id			int(4) auto_increment not null,
	humedad		int(10),
	fecha		timestamp,
	mykey 		varchar(100),
	CONSTRAINT pk_humedad PRIMARY KEY(id)
);*/ 

/*json = {"humedad":"900", "fecha": "", "key": ""}*/

CREATE TABLE consumo_agua(
	id			int(4) auto_increment not null,
	consumo		float(10),
	fecha		timestamp,
	mykey		varchar(100),
	CONSTRAINT pk_consumo_agua PRIMARY KEY(id)
); 

/*json = {"consumo":"100", "fecha": "", "key": ""}*/

CREATE TABLE usuario(
	id				int(4) auto_increment not null,
	nombre			varchar(20),
	contrasena 		varchar(20),
	rol				varchar(10),
	fecha_registro	timestamp,
	CONSTRAINT pk_usuario PRIMARY KEY(id)
); 

