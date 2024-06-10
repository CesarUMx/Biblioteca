-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2021 a las 13:46:05
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for autor
-- ----------------------------
DROP TABLE IF EXISTS `autor`;
CREATE TABLE `autor`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `imagen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of autor
-- ----------------------------
INSERT INTO `autor` VALUES (1, 'ultima prueba', 'logo.png', 1);
INSERT INTO `autor` VALUES (2, 'cambiar el nombre llll', '20210514132528.jpg', 1);
INSERT INTO `autor` VALUES (3, 'popoiipippi', 'logo.png', 1);
INSERT INTO `autor` VALUES (4, 'perez', 'logo.png', 1);

-- ----------------------------
-- Table structure for configuracion
-- ----------------------------
DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of configuracion
-- ----------------------------
INSERT INTO `configuracion` VALUES (1, 'UMx', '925491523', 'Querétaro', 'sistemas@mondragonmexico.edu.mx', 'logo.png');

-- ----------------------------
-- Table structure for detalle_permisos
-- ----------------------------
DROP TABLE IF EXISTS `detalle_permisos`;
CREATE TABLE `detalle_permisos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_permiso` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_usuario`(`id_usuario` ASC) USING BTREE,
  INDEX `id_permiso`(`id_permiso` ASC) USING BTREE,
  CONSTRAINT `detalle_permisos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `detalle_permisos_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_permisos
-- ----------------------------
INSERT INTO `detalle_permisos` VALUES (19, 5, 1);
INSERT INTO `detalle_permisos` VALUES (20, 5, 2);
INSERT INTO `detalle_permisos` VALUES (21, 5, 3);
INSERT INTO `detalle_permisos` VALUES (22, 5, 4);
INSERT INTO `detalle_permisos` VALUES (23, 5, 5);
INSERT INTO `detalle_permisos` VALUES (24, 5, 6);
INSERT INTO `detalle_permisos` VALUES (25, 5, 7);
INSERT INTO `detalle_permisos` VALUES (26, 5, 8);
INSERT INTO `detalle_permisos` VALUES (27, 5, 9);
INSERT INTO `detalle_permisos` VALUES (35, 6, 1);
INSERT INTO `detalle_permisos` VALUES (36, 6, 2);
INSERT INTO `detalle_permisos` VALUES (37, 6, 3);
INSERT INTO `detalle_permisos` VALUES (38, 6, 6);
INSERT INTO `detalle_permisos` VALUES (39, 6, 7);
INSERT INTO `detalle_permisos` VALUES (40, 6, 8);
INSERT INTO `detalle_permisos` VALUES (41, 6, 9);

-- ----------------------------
-- Table structure for editorial
-- ----------------------------
DROP TABLE IF EXISTS `editorial`;
CREATE TABLE `editorial`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `editorial` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of editorial
-- ----------------------------
INSERT INTO `editorial` VALUES (1, 'Ninguna', 1);
INSERT INTO `editorial` VALUES (2, 'Toribio anyarin', 0);
INSERT INTO `editorial` VALUES (3, 'planeta', 1);

-- ----------------------------
-- Table structure for estudiante
-- ----------------------------
DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE `estudiante`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricula` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `carrera` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of estudiante
-- ----------------------------
INSERT INTO `estudiante` VALUES (3, '202003849', 'MACIAS LARA DANIEL ALEJANDRO', 'Licenciatura En Arquitectura Sustentable', '4426403985', 1);

-- ----------------------------
-- Table structure for libro
-- ----------------------------
DROP TABLE IF EXISTS `libro`;
CREATE TABLE `libro`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isbn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_autor` int NOT NULL,
  `id_editorial` int NOT NULL,
  `anio_edicion` year NULL DEFAULT NULL,
  `id_materia` int NOT NULL,
  `num_pagina` int NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `estado` int NOT NULL DEFAULT 1,
  `clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `otros_autores` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `clasificacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_autor`(`id_autor` ASC) USING BTREE,
  INDEX `id_materia`(`id_materia` ASC) USING BTREE,
  INDEX `id_editorial`(`id_editorial` ASC) USING BTREE,
  CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`id_editorial`) REFERENCES `editorial` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of libro
-- ----------------------------
INSERT INTO `libro` VALUES (6, 'libro1', 'jhsdhas', 1, 1, 2002, 2, 20, 'prueba', 1, '101', NULL, 'ssdfsd');
INSERT INTO `libro` VALUES (7, 'Preuba de 2 Libros', '185485', 1, 1, 2000, 2, 100, 'preuba de 2 libros con diferentes claves', 1, '701', 'otros', 'hsye-158-20');
INSERT INTO `libro` VALUES (8, 'Preuba de 2 Libros', '185485', 1, 1, 2000, 2, 100, 'preuba de 2 libros con diferentes claves', 1, '702', 'otros', 'hsye-158-20');

-- ----------------------------
-- Table structure for materia
-- ----------------------------
DROP TABLE IF EXISTS `materia`;
CREATE TABLE `materia`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `materia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of materia
-- ----------------------------
INSERT INTO `materia` VALUES (1, 'Base de Datos', 1);
INSERT INTO `materia` VALUES (2, 'Ingenieria de Software', 1);
INSERT INTO `materia` VALUES (3, 'Algebra', 1);
INSERT INTO `materia` VALUES (4, 'Matematica', 1);

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tipo` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES (1, 'Libros', 1);
INSERT INTO `permisos` VALUES (2, 'Autor', 2);
INSERT INTO `permisos` VALUES (3, 'Editorial', 3);
INSERT INTO `permisos` VALUES (4, 'Usuarios', 4);
INSERT INTO `permisos` VALUES (5, 'Configuracion', 5);
INSERT INTO `permisos` VALUES (6, 'Estudiantes', 6);
INSERT INTO `permisos` VALUES (7, 'Materias', 7);
INSERT INTO `permisos` VALUES (8, 'Reportes', 8);
INSERT INTO `permisos` VALUES (9, 'Prestamos', 9);

-- ----------------------------
-- Table structure for prestamo
-- ----------------------------
DROP TABLE IF EXISTS `prestamo`;
CREATE TABLE `prestamo`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_estudiante` int NOT NULL,
  `id_libro` int NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `cantidad` int NOT NULL,
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_estudiante`(`id_estudiante` ASC) USING BTREE,
  INDEX `id_libro`(`id_libro` ASC) USING BTREE,
  CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of prestamo
-- ----------------------------

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `clave` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `estado` int NOT NULL DEFAULT 1,
  `puesto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'sistemas@mondragonmexico.edu.mx', 'Sistemas', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 'Super administrador');
INSERT INTO `usuarios` VALUES (5, 'cortiz@mondragonmexico.edu.mx', 'Cesar Ortiz', 'b2ee2ffe484e989260c852a6c02492e393064a5a158ed563869b7ffc5af7d52a', 1, 'Administrador');
INSERT INTO `usuarios` VALUES (6, 'aperez@mondragonmexico.edu.mx', 'Arlette Perez', 'c1679c1cb6e60024e81bed2e318c31dd3a3837b42884b4b50365609f558bc07e', 1, 'Coordinador de biblioteca');

SET FOREIGN_KEY_CHECKS = 1;