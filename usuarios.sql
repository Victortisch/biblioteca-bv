-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-11-2019 a las 22:20:35
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usua_documento` int(11) NOT NULL,
  `usua_nombre` varchar(45) NOT NULL,
  `usua_apellido` varchar(45) NOT NULL,
  `usua_nacimiento` date DEFAULT NULL,
  `usua_contac` varchar(45) NOT NULL,
  `usua_biometrico` varchar(45) DEFAULT NULL,
  `carreras_carr_codigo` int(11) NOT NULL,
  PRIMARY KEY (`usua_documento`),
  UNIQUE KEY `usua_documento_UNIQUE` (`usua_documento`),
  KEY `fk_usuarios_carreras_idx` (`carreras_carr_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usua_documento`, `usua_nombre`, `usua_apellido`, `usua_nacimiento`, `usua_contac`, `usua_biometrico`, `carreras_carr_codigo`) VALUES
(4852254, 'Laura Anahi', 'Gonzalez Irala', '1998-02-25', '0985237297', NULL, 1),
(5622355, 'Magaly Vanesa', 'Suchecki Endler', '1997-06-24', '42', NULL, 1),
(5622356, 'ale', 'asa', '2001-11-11', '0985232323', NULL, 5),
(5622357, 'aswf', 'wrgw', '2001-11-11', '001', NULL, 1),
(5622358, 'dsa', 'df', '2001-11-11', '', NULL, 6);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_carreras` FOREIGN KEY (`carreras_carr_codigo`) REFERENCES `carreras` (`carr_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
