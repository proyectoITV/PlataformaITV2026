/*
 Navicat Premium Data Transfer

 Source Server         : Plataforma PRODUCCION
 Source Server Type    : MariaDB
 Source Server Version : 100312
 Source Host           : 172.16.91.5:3306
 Source Schema         : itavu

 Target Server Type    : MariaDB
 Target Server Version : 100312
 File Encoding         : 65001

 Date: 14/05/2020 16:07:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for TransparenciaGo
-- ----------------------------
DROP TABLE IF EXISTS `TransparenciaGo`;
CREATE TABLE `TransparenciaGo`  (
  `IdFile` int(5) NOT NULL COMMENT 'Id del Archivo a Subir',
  `FileNombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Nombre del Archivo Original',
  `IdUser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Usuario que lo subio',
  `fecha` date NOT NULL COMMENT 'Fecha de Subida',
  `hora` time(6) NOT NULL COMMENT 'Hora de Subida',
  `FileDescripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Descripcion del Archivo',
  PRIMARY KEY (`IdFile`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
