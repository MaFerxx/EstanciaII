SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS bdestancia;

USE bdestancia;

DROP TABLE IF EXISTS campanas;

CREATE TABLE `campanas` (
  `id_campana` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_campana` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_campana`),
  KEY `fk_campana_empresa` (`id_empresa`),
  CONSTRAINT `fk_campana_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO campanas VALUES("1","C","eeee","2024-11-27","2024-12-07","5");



DROP TABLE IF EXISTS citas;

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `estado` varchar(20) NOT NULL,
  `usuarios_id_usuario` int(11) DEFAULT NULL,
  `empresas_id_empresa` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  PRIMARY KEY (`id_cita`),
  KEY `fk_citas_usuarios` (`usuarios_id_usuario`),
  KEY `fk_citas_empresas` (`empresas_id_empresa`),
  CONSTRAINT `fk_citas_empresas` FOREIGN KEY (`empresas_id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_citas_usuarios` FOREIGN KEY (`usuarios_id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO citas VALUES("2","2024-11-21 11:49:00","Cancelada","5","4","n0");
INSERT INTO citas VALUES("3","2024-11-29 11:53:00","Cancelada","5","4","jjjjjjjjj");
INSERT INTO citas VALUES("4","2024-12-04 00:07:00","Cancelada","5","4","mmm");
INSERT INTO citas VALUES("5","2025-01-04 17:28:00","Cancelada","5","4","aaa");
INSERT INTO citas VALUES("6","2025-02-01 17:28:00","Cancelada","5","4","aaa");
INSERT INTO citas VALUES("7","2024-11-27 12:35:00","Cancelada","5","4","hhh");
INSERT INTO citas VALUES("8","2024-11-21 07:15:00","Pendiente","5","4","jjj");
INSERT INTO citas VALUES("9","2024-11-29 19:17:00","Pendiente","5","4","pppp");
INSERT INTO citas VALUES("10","2024-11-20 02:37:00","Pendiente","5","4","pp");
INSERT INTO citas VALUES("11","2024-11-28 14:00:00","Pendiente","9","6","x");



DROP TABLE IF EXISTS empresas;

CREATE TABLE `empresas` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `direccion_empresa` text DEFAULT NULL,
  `telefono_empresa` varchar(15) DEFAULT NULL,
  `correo_empresa` varchar(30) NOT NULL,
  `altitud` decimal(10,8) NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO empresas VALUES("4","UPEMOR","$2y$10$evTu2hKJXK6RqrlDg.v5/.KvQUNWhMJgNNbAlr27.8.HY.OcFNn0u","Boulevard Cuauhnáhuac #566, Col. Lomas del Texcal, Jiutepec, Morelos.","7772948451","upe@gmail.com","-99.14035875","18.88990229");
INSERT INTO empresas VALUES("5","UAEM","","Av. Universidad No. 1001, Chamilpa, 62210 Cuernavaca, Mor.","2222","uaem@uaem.edu.mx","-99.24226320","18.98189410");
INSERT INTO empresas VALUES("6","Atlihuayan","","Yautepec de Zaragoza, Mor.","555","atli@gmail.com","-99.08432090","18.86633270");



DROP TABLE IF EXISTS empresas_has_residuos;

CREATE TABLE `empresas_has_residuos` (
  `residuos_id_residuo` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `idresiduo` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idresiduo`),
  KEY `fk_empresas_residuos_empresas` (`id_empresa`),
  KEY `fk_empresas_residuos_residuos` (`residuos_id_residuo`),
  CONSTRAINT `fk_empresas_residuos_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_empresas_residuos_residuos` FOREIGN KEY (`residuos_id_residuo`) REFERENCES `residuos` (`id_residuo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS recomendaciones;

CREATE TABLE `recomendaciones` (
  `id_recomendacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_recomendacion`),
  KEY `fk_recomendaciones_empresas` (`id_empresa`),
  CONSTRAINT `fk_recomendaciones_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO recomendaciones VALUES("1","mmmmmm","4");



DROP TABLE IF EXISTS residuos;

CREATE TABLE `residuos` (
  `id_residuo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `tipo_residuo` varchar(20) NOT NULL,
  `descripcion_residuo` text DEFAULT NULL,
  PRIMARY KEY (`id_residuo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO residuos VALUES("1","Pilas","Corrosivo","hhh");
INSERT INTO residuos VALUES("2","Gato","Reactivo","sfsgv");



DROP TABLE IF EXISTS roles;

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(20) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO roles VALUES("1","Administrador");
INSERT INTO roles VALUES("2","Usuario");
INSERT INTO roles VALUES("3","Empresa");



DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `apellidoP` varchar(25) NOT NULL,
  `apellidoM` varchar(25) NOT NULL,
  `correo` varchar(35) NOT NULL,
  `genero` varchar(25) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuario_rol` (`id_rol`),
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO usuarios VALUES("5","Jorge Alonso","yorch","$2y$10$sg4AC56SWq.ZEcBBPYdUoePDdwlVlV5HGcHMF6afNpVQVYXrgT0lS","1","Gomez","Estrada","jorge@gmail.com","Masculino");
INSERT INTO usuarios VALUES("9","Fernanda","mafer","$2y$10$OwDDTbY3hzEJ7WADrhrssOEbvrn3hQuMC8OKehW6cQg5.x1Yik6Ta","1","García","García","gg@gmail.com","Femenino");
INSERT INTO usuarios VALUES("10","Alan","alan","$2y$10$OExQuCW.tZw9SOp0Sc027Ozy0rHIYoW0Zoui6jrCvgekM2htBMC12","2","Garcia","Garcia","alan@upe.edu.mx","Masculino");



SET FOREIGN_KEY_CHECKS=1;