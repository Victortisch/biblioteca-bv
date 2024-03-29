-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-11-2019 a las 19:02:07
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `biblioteca`
--
CREATE DATABASE IF NOT EXISTS `biblioteca` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `biblioteca`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
  `auto_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `auto_nombre` varchar(45) NOT NULL,
  `auto_apellido` varchar(45) NOT NULL,
  PRIMARY KEY (`auto_codigo`),
  UNIQUE KEY `auto_codigo_UNIQUE` (`auto_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`auto_codigo`, `auto_nombre`, `auto_apellido`) VALUES
(1, 'Augusto ', 'Roa Bastos'),
(2, 'Mario', 'Halley Mora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE IF NOT EXISTS `carreras` (
  `carr_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `carr_descripcion` varchar(45) NOT NULL,
  `facultades_facu_codigo` int(11) NOT NULL,
  PRIMARY KEY (`carr_codigo`),
  UNIQUE KEY `carr_codigo_UNIQUE` (`carr_codigo`),
  UNIQUE KEY `carr_descripcion_UNIQUE` (`carr_descripcion`),
  KEY `fk_carreras_facultades1_idx` (`facultades_facu_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`carr_codigo`, `carr_descripcion`, `facultades_facu_codigo`) VALUES
(1, 'Analisis de Sistemas Informaticos', 1),
(2, 'Disenho de Modas', 1),
(3, 'contabilidad publica', 2),
(5, 'que te parece ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultades`
--

CREATE TABLE IF NOT EXISTS `facultades` (
  `facu_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `facu_descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`facu_codigo`),
  UNIQUE KEY `facu_codigo_UNIQUE` (`facu_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`facu_codigo`, `facu_descripcion`) VALUES
(1, 'Ciencia, Arte y Tecnologia'),
(2, 'Ciencias Humanas y Juridicas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE IF NOT EXISTS `generos` (
  `gene_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `gene_descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`gene_codigo`),
  UNIQUE KEY `gene_codigo_UNIQUE` (`gene_codigo`),
  UNIQUE KEY `gene_descripcion_UNIQUE` (`gene_descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`gene_codigo`, `gene_descripcion`) VALUES
(1, 'Historia'),
(2, 'Literatura paraguaya');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE IF NOT EXISTS `libros` (
  `libr_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `libr_nombre` varchar(45) NOT NULL,
  `generos_gene_codigo` int(11) NOT NULL,
  `autores_auto_codigo` int(11) NOT NULL,
  `tipos_libros_tili_codigo` int(11) NOT NULL,
  `origenes_libros_orli_codigo` int(11) NOT NULL,
  `ejemplares_disp` smallint(6) DEFAULT '1',
  PRIMARY KEY (`libr_codigo`),
  UNIQUE KEY `libr_codigo_UNIQUE` (`libr_codigo`),
  KEY `fk_libros_generos1_idx` (`generos_gene_codigo`),
  KEY `fk_libros_autores1_idx` (`autores_auto_codigo`),
  KEY `fk_libros_tipos_libros1_idx` (`tipos_libros_tili_codigo`),
  KEY `fk_libros_origenes_libros1_idx` (`origenes_libros_orli_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`libr_codigo`, `libr_nombre`, `generos_gene_codigo`, `autores_auto_codigo`, `tipos_libros_tili_codigo`, `origenes_libros_orli_codigo`, `ejemplares_disp`) VALUES
(1, 'Hijo de Hombre', 2, 1, 1, 1, 1),
(2, 'Los hombres de Celina', 1, 2, 1, 1, 1),
(3, 'Informatica', 1, 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `origenes_libros`
--

CREATE TABLE IF NOT EXISTS `origenes_libros` (
  `orli_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `orli_descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`orli_codigo`),
  UNIQUE KEY `orli_codigo_UNIQUE` (`orli_codigo`),
  UNIQUE KEY `orli_descripcion_UNIQUE` (`orli_descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `origenes_libros`
--

INSERT INTO `origenes_libros` (`orli_codigo`, `orli_descripcion`) VALUES
(1, 'Donacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE IF NOT EXISTS `prestamos` (
  `pres_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pres_fecha_s` date NOT NULL,
  `pres_plazo` int(11) NOT NULL,
  `pres_fecha_d` date DEFAULT NULL,
  `usuarios_usua_documento` int(11) NOT NULL,
  `libros_libr_codigo` int(11) NOT NULL,
  PRIMARY KEY (`pres_codigo`),
  UNIQUE KEY `pres_codigo_UNIQUE` (`pres_codigo`),
  KEY `fk_prestamos_usuarios1_idx` (`usuarios_usua_documento`),
  KEY `fk_prestamos_libros1_idx` (`libros_libr_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`pres_codigo`, `pres_fecha_s`, `pres_plazo`, `pres_fecha_d`, `usuarios_usua_documento`, `libros_libr_codigo`) VALUES
(1, '2017-06-01', 7, '2017-06-08', 4852254, 1),
(2, '2017-06-02', 7, '2017-06-09', 5622355, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_libros`
--

CREATE TABLE IF NOT EXISTS `tipos_libros` (
  `tili_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tili_descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`tili_codigo`),
  UNIQUE KEY `tili_codigo_UNIQUE` (`tili_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos_libros`
--

INSERT INTO `tipos_libros` (`tili_codigo`, `tili_descripcion`) VALUES
(1, 'Tesis'),
(2, 'Revistas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usua_documento` int(11) NOT NULL,
  `usua_nombre` varchar(45) NOT NULL,
  `usua_apellido` varchar(45) NOT NULL,
  `usua_nacimiento` date DEFAULT NULL,
  `usua_direccion` varchar(255) NOT NULL,
  `usua_contac` varchar(13) NOT NULL,
  `usua_biometrico` varchar(45) DEFAULT NULL,
  `carreras_carr_codigo` int(11) NOT NULL,
  PRIMARY KEY (`usua_documento`),
  UNIQUE KEY `usua_documento_UNIQUE` (`usua_documento`),
  KEY `fk_usuarios_carreras_idx` (`carreras_carr_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usua_documento`, `usua_nombre`, `usua_apellido`, `usua_nacimiento`, `usua_direccion`, `usua_contac`, `usua_biometrico`, `carreras_carr_codigo`) VALUES
(2, 'lolo', 'l', '0022-02-22', 'grti', '1', NULL, 2),
(8, 'lolo', 'l', '0022-02-22', 'grt', '2', NULL, 2),
(4852254, 'Laura Anahi', 'Gonzalez Irala', '1998-02-25', '', '', NULL, 1),
(5622355, 'Magaly Vanesa', 'Suchecki Endler', '1997-06-24', '', '', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE IF NOT EXISTS `visitas` (
  `vita_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `vita_nombre` varchar(150) NOT NULL,
  `vita_fecha` date NOT NULL,
  `vita_motivo` text,
  PRIMARY KEY (`vita_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `visitas`
--

INSERT INTO `visitas` (`vita_id`, `vita_nombre`, `vita_fecha`, `vita_motivo`) VALUES
(1, 'loro', '2019-11-21', 'mmmmmmmm'),
(2, 'ggg', '0000-00-00', 'f');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `fk_carreras_facultades1` FOREIGN KEY (`facultades_facu_codigo`) REFERENCES `facultades` (`facu_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_libros_autores1` FOREIGN KEY (`autores_auto_codigo`) REFERENCES `autores` (`auto_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_libros_generos1` FOREIGN KEY (`generos_gene_codigo`) REFERENCES `generos` (`gene_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_libros_origenes_libros1` FOREIGN KEY (`origenes_libros_orli_codigo`) REFERENCES `origenes_libros` (`orli_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_libros_tipos_libros1` FOREIGN KEY (`tipos_libros_tili_codigo`) REFERENCES `tipos_libros` (`tili_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_prestamos_libros1` FOREIGN KEY (`libros_libr_codigo`) REFERENCES `libros` (`libr_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prestamos_usuarios1` FOREIGN KEY (`usuarios_usua_documento`) REFERENCES `usuarios` (`usua_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_carreras` FOREIGN KEY (`carreras_carr_codigo`) REFERENCES `carreras` (`carr_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
