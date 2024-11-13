-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-11-2024 a las 15:28:24
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `elecciones`
--
CREATE DATABASE IF NOT EXISTS `elecciones` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `elecciones`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administracion`
--

DROP TABLE IF EXISTS `administracion`;
CREATE TABLE IF NOT EXISTS `administracion` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_Administracion_Ciudadanos1_idx` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `administracion`
--

INSERT INTO `administracion` (`id_usuario`, `usuario`, `clave`, `nombre`, `apellido`, `cedula`) VALUES
(4, 'angel', '09182329', 'angel', 'Sañez', '70756458');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

DROP TABLE IF EXISTS `candidatos`;
CREATE TABLE IF NOT EXISTS `candidatos` (
  `id_candidato` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `id_partido` int NOT NULL,
  `id_puesto` int NOT NULL,
  `foto_perfil` varchar(45) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '0',
  `nom-teni` varchar(100) DEFAULT NULL,
  `gra-teni` varchar(100) DEFAULT NULL,
  `nom-salu` varchar(100) DEFAULT NULL,
  `gra-salu` varchar(100) DEFAULT NULL,
  `nom-educ` varchar(100) DEFAULT NULL,
  `gra-educ` varchar(100) DEFAULT NULL,
  `nom-dere` varchar(100) DEFAULT NULL,
  `gra-dere` varchar(100) DEFAULT NULL,
  `nom-comu` varchar(100) DEFAULT NULL,
  `gra-comu` varchar(100) DEFAULT NULL,
  `nom-empr` varchar(100) DEFAULT NULL,
  `gra-empr` varchar(100) DEFAULT NULL,
  `plan-trab` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id_candidato`),
  KEY `fk_Candidatos_Partidos_idx` (`id_partido`),
  KEY `fk_Candidatos_Puestos1_idx` (`id_puesto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudadanos`
--

DROP TABLE IF EXISTS `ciudadanos`;
CREATE TABLE IF NOT EXISTS `ciudadanos` (
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '0',
  `Grado` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `ciudadanos`
--

INSERT INTO `ciudadanos` (`cedula`, `nombre`, `apellido`, `email`, `estado`, `Grado`) VALUES
('70756458', 'angel', 'sañez', 'msaneshuaman@gmail.com', 0, 'primero de secundaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elecciones`
--

DROP TABLE IF EXISTS `elecciones`;
CREATE TABLE IF NOT EXISTS `elecciones` (
  `id_elecciones` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_elecciones`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elecciones_cont`
--

DROP TABLE IF EXISTS `elecciones_cont`;
CREATE TABLE IF NOT EXISTS `elecciones_cont` (
  `id_elecciones` int NOT NULL,
  `id_candidato` int NOT NULL,
  `id_partido` int NOT NULL,
  `id_puesto` int NOT NULL,
  `cedula` varchar(20) NOT NULL,
  PRIMARY KEY (`id_elecciones`,`cedula`,`id_puesto`,`id_candidato`),
  KEY `fk_Elecciones_Cont_Elecciones1_idx` (`id_elecciones`),
  KEY `fk_Elecciones_Cont_Candidatos1_idx` (`id_candidato`),
  KEY `fk_Elecciones_Cont_Partidos1_idx` (`id_partido`),
  KEY `fk_Elecciones_Cont_Puestos1_idx` (`id_puesto`),
  KEY `fk_Elecciones_Cont_Ciudadanos1_idx` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

DROP TABLE IF EXISTS `partidos`;
CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partido` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_partido`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

DROP TABLE IF EXISTS `puestos`;
CREATE TABLE IF NOT EXISTS `puestos` (
  `id_puesto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  `estado` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_puesto`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administracion`
--
ALTER TABLE `administracion`
  ADD CONSTRAINT `fk_Administracion_Ciudadanos1` FOREIGN KEY (`cedula`) REFERENCES `ciudadanos` (`cedula`);

--
-- Filtros para la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD CONSTRAINT `fk_Candidatos_Partidos` FOREIGN KEY (`id_partido`) REFERENCES `partidos` (`id_partido`),
  ADD CONSTRAINT `fk_Candidatos_Puestos1` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id_puesto`);

--
-- Filtros para la tabla `elecciones_cont`
--
ALTER TABLE `elecciones_cont`
  ADD CONSTRAINT `fk_Elecciones_Cont_Candidatos1` FOREIGN KEY (`id_candidato`) REFERENCES `candidatos` (`id_candidato`),
  ADD CONSTRAINT `fk_Elecciones_Cont_Ciudadanos1` FOREIGN KEY (`cedula`) REFERENCES `ciudadanos` (`cedula`),
  ADD CONSTRAINT `fk_Elecciones_Cont_Elecciones1` FOREIGN KEY (`id_elecciones`) REFERENCES `elecciones` (`id_elecciones`),
  ADD CONSTRAINT `fk_Elecciones_Cont_Partidos1` FOREIGN KEY (`id_partido`) REFERENCES `partidos` (`id_partido`),
  ADD CONSTRAINT `fk_Elecciones_Cont_Puestos1` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id_puesto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
