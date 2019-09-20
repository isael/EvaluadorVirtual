-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-09-2019 a las 05:57:17
-- Versión del servidor: 5.7.18
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `EVirtual`
--
CREATE DATABASE IF NOT EXISTS `EVirtual` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `EVirtual`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Alumno`
--

DROP TABLE IF EXISTS `Alumno`;
CREATE TABLE IF NOT EXISTS `Alumno` (
  `n_cuenta` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`n_cuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Alumno`
--

INSERT INTO `Alumno` (`n_cuenta`, `nombres`, `apellidos`, `correo`, `contrasenia`) VALUES
(1, 'alumno', 'escolar', 'a@a.a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BasadoEn`
--

DROP TABLE IF EXISTS `BasadoEn`;
CREATE TABLE IF NOT EXISTS `BasadoEn` (
  `id_examen` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  PRIMARY KEY (`id_examen`,`id_tema`),
  KEY `id_examen` (`id_examen`),
  KEY `id_tema` (`id_tema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CometeErroresEn`
--

DROP TABLE IF EXISTS `CometeErroresEn`;
CREATE TABLE IF NOT EXISTS `CometeErroresEn` (
  `id_respuesta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_respuesta`),
  KEY `id_tema` (`id_tema`),
  KEY `id_alumno` (`n_cuenta`),
  KEY `id_respuesta` (`id_respuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contiene`
--

DROP TABLE IF EXISTS `Contiene`;
CREATE TABLE IF NOT EXISTS `Contiene` (
  `id_respuesta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  PRIMARY KEY (`id_respuesta`),
  KEY `id_pregunta` (`id_pregunta`),
  KEY `id_respuesta` (`id_respuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Contiene`
--

INSERT INTO `Contiene` (`id_respuesta`, `id_pregunta`) VALUES
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 6),
(14, 6),
(15, 6),
(16, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cursa`
--

DROP TABLE IF EXISTS `Cursa`;
CREATE TABLE IF NOT EXISTS `Cursa` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`n_cuenta`,`id_curso`),
  KEY `n_cuenta` (`n_cuenta`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Cursa`
--

INSERT INTO `Cursa` (`n_cuenta`, `id_curso`, `estado`) VALUES
(1, 1, 'r');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Curso`
--

DROP TABLE IF EXISTS `Curso`;
CREATE TABLE IF NOT EXISTS `Curso` (
  `id_curso` int(10) NOT NULL AUTO_INCREMENT,
  `clave` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_curso`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Curso`
--

INSERT INTO `Curso` (`id_curso`, `clave`, `nombre`) VALUES
(1, 1234, 'Redes'),
(2, 1212, '1212'),
(3, 1111, 'Prueba'),
(4, 123, 'Redes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoFuente`
--

DROP TABLE IF EXISTS `CursoFuente`;
CREATE TABLE IF NOT EXISTS `CursoFuente` (
  `id_curso` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_curso`,`id_fuente`),
  KEY `id_curso` (`id_curso`),
  KEY `id_fuente` (`id_fuente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CursoFuente`
--

INSERT INTO `CursoFuente` (`id_curso`, `id_fuente`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoTema`
--

DROP TABLE IF EXISTS `CursoTema`;
CREATE TABLE IF NOT EXISTS `CursoTema` (
  `id_tema` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL,
  `cantidad_preguntas` int(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tema`,`id_curso`),
  KEY `id_tema` (`id_tema`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CursoTema`
--

INSERT INTO `CursoTema` (`id_tema`, `id_curso`, `cantidad_preguntas`) VALUES
(1, 1, 1),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DeTipo`
--

DROP TABLE IF EXISTS `DeTipo`;
CREATE TABLE IF NOT EXISTS `DeTipo` (
  `id_pregunta` int(10) NOT NULL,
  `id_tipo` int(10) NOT NULL,
  PRIMARY KEY (`id_pregunta`),
  KEY `id_tipo` (`id_tipo`),
  KEY `id_pregunta` (`id_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `DeTipo`
--

INSERT INTO `DeTipo` (`id_pregunta`, `id_tipo`) VALUES
(2, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Edicion`
--

DROP TABLE IF EXISTS `Edicion`;
CREATE TABLE IF NOT EXISTS `Edicion` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `anio` smallint(6) NOT NULL,
  `liga` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_fuente`,`numero`),
  KEY `id_fuente` (`id_fuente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Edicion`
--

INSERT INTO `Edicion` (`id_fuente`, `numero`, `anio`, `liga`) VALUES
(4, 1, 1999, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Evalua`
--

DROP TABLE IF EXISTS `Evalua`;
CREATE TABLE IF NOT EXISTS `Evalua` (
  `id_examen` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL,
  PRIMARY KEY (`id_examen`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Examen`
--

DROP TABLE IF EXISTS `Examen`;
CREATE TABLE IF NOT EXISTS `Examen` (
  `id_examen` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `tiempo` smallint(6) NOT NULL,
  `oportunidades` tinyint(4) NOT NULL,
  `vidas` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_examen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fuente`
--

DROP TABLE IF EXISTS `Fuente`;
CREATE TABLE IF NOT EXISTS `Fuente` (
  `id_fuente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `autores` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_fuente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Fuente`
--

INSERT INTO `Fuente` (`id_fuente`, `autores`, `nombre`) VALUES
(4, 'autores', 'nombre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FundamentadoEn`
--

DROP TABLE IF EXISTS `FundamentadoEn`;
CREATE TABLE IF NOT EXISTS `FundamentadoEn` (
  `id_referencia` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  PRIMARY KEY (`id_referencia`),
  KEY `id_pregunta` (`id_pregunta`),
  KEY `id_referencia` (`id_referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `FundamentadoEn`
--

INSERT INTO `FundamentadoEn` (`id_referencia`, `id_pregunta`) VALUES
(1, 2),
(4, 5),
(5, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Genera`
--

DROP TABLE IF EXISTS `Genera`;
CREATE TABLE IF NOT EXISTS `Genera` (
  `id_pregunta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  PRIMARY KEY (`id_pregunta`),
  KEY `id_tema` (`id_tema`),
  KEY `id_pregunta` (`id_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Genera`
--

INSERT INTO `Genera` (`id_pregunta`, `id_tema`) VALUES
(2, 1),
(5, 4),
(6, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imparte`
--

DROP TABLE IF EXISTS `Imparte`;
CREATE TABLE IF NOT EXISTS `Imparte` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL,
  PRIMARY KEY (`n_trabajador`,`id_curso`),
  KEY `n_trabajador` (`n_trabajador`),
  KEY `id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Imparte`
--

INSERT INTO `Imparte` (`n_trabajador`, `id_curso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pregunta`
--

DROP TABLE IF EXISTS `Pregunta`;
CREATE TABLE IF NOT EXISTS `Pregunta` (
  `id_pregunta` int(10) NOT NULL AUTO_INCREMENT,
  `dificultad` tinyint(4) NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `justificacion` text COLLATE utf8_spanish_ci NOT NULL,
  `tiene_subpreguntas` tinyint(1) NOT NULL,
  `tiempo` int(10) UNSIGNED NOT NULL DEFAULT '30',
  PRIMARY KEY (`id_pregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Pregunta`
--

INSERT INTO `Pregunta` (`id_pregunta`, `dificultad`, `texto`, `justificacion`, `tiene_subpreguntas`, `tiempo`) VALUES
(2, 3, '¿Quién soy yo?', 'Ser o no ser...', 0, 30),
(5, 2, 'esta es la pregunta 2', 'justificación 2', 0, 20),
(6, 1, 'la tercer pregunta', 'tercera justificación', 0, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Presenta`
--

DROP TABLE IF EXISTS `Presenta`;
CREATE TABLE IF NOT EXISTS `Presenta` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_examen` int(10) NOT NULL,
  `calificacion` tinyint(3) UNSIGNED NOT NULL,
  `vidas` tinyint(4) UNSIGNED NOT NULL,
  `oportunidades` tinyint(4) UNSIGNED NOT NULL,
  `terminado` tinyint(1) NOT NULL,
  PRIMARY KEY (`n_cuenta`,`id_examen`),
  KEY `n_cuenta` (`n_cuenta`),
  KEY `id_examen` (`id_examen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Profesor`
--

DROP TABLE IF EXISTS `Profesor`;
CREATE TABLE IF NOT EXISTS `Profesor` (
  `n_trabajador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`n_trabajador`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Profesor`
--

INSERT INTO `Profesor` (`n_trabajador`, `nombres`, `apellidos`, `correo`, `contrasenia`) VALUES
(1, 'yolo', 'qwerty', 'p@p.p', '516b9783fca517eecbd1d064da2d165310b19759');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Referencia`
--

DROP TABLE IF EXISTS `Referencia`;
CREATE TABLE IF NOT EXISTS `Referencia` (
  `id_referencia` int(10) NOT NULL AUTO_INCREMENT,
  `capitulo` tinyint(4) NOT NULL,
  `pagina` smallint(6) NOT NULL,
  PRIMARY KEY (`id_referencia`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Referencia`
--

INSERT INTO `Referencia` (`id_referencia`, `capitulo`, `pagina`) VALUES
(1, 22, 11),
(4, 2, 2),
(5, 22, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ReferenciaFuente`
--

DROP TABLE IF EXISTS `ReferenciaFuente`;
CREATE TABLE IF NOT EXISTS `ReferenciaFuente` (
  `id_referencia` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_referencia`),
  KEY `id_fuente` (`id_fuente`),
  KEY `id_referencia` (`id_referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ReferenciaFuente`
--

INSERT INTO `ReferenciaFuente` (`id_referencia`, `id_fuente`) VALUES
(1, 4),
(4, 4),
(5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Respuesta`
--

DROP TABLE IF EXISTS `Respuesta`;
CREATE TABLE IF NOT EXISTS `Respuesta` (
  `id_respuesta` int(10) NOT NULL AUTO_INCREMENT,
  `contenido` text COLLATE utf8_spanish_ci NOT NULL,
  `porcentaje` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_respuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Respuesta`
--

INSERT INTO `Respuesta` (`id_respuesta`, `contenido`, `porcentaje`) VALUES
(1, '123', 100),
(2, '1234', 0),
(3, '12345', 0),
(4, '123456', 0),
(5, 'resp 1', 100),
(6, 'resp 2', 0),
(7, 'resp 3', 0),
(8, 'resp 4', 0),
(9, 'resp 1', 100),
(10, 'resp 2', 0),
(11, 'resp 3', 0),
(12, 'resp 4', 0),
(13, 'resp 1', 100),
(14, 'fghj', 0),
(15, 'ghjk', 0),
(16, 'hjklmn', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tema`
--

DROP TABLE IF EXISTS `Tema`;
CREATE TABLE IF NOT EXISTS `Tema` (
  `id_tema` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tema`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Tema`
--

INSERT INTO `Tema` (`id_tema`, `nombre`) VALUES
(1, 'el tema'),
(4, 'Segundo tema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TemaFuente`
--

DROP TABLE IF EXISTS `TemaFuente`;
CREATE TABLE IF NOT EXISTS `TemaFuente` (
  `id_tema` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `cantidad_preguntas` int(10) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tema`,`id_fuente`),
  KEY `id_tema` (`id_tema`),
  KEY `id_fuente` (`id_fuente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `TemaFuente`
--

INSERT INTO `TemaFuente` (`id_tema`, `id_fuente`, `cantidad_preguntas`) VALUES
(1, 4, 1),
(4, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tipo`
--

DROP TABLE IF EXISTS `Tipo`;
CREATE TABLE IF NOT EXISTS `Tipo` (
  `id_tipo` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tiene_subpreguntas` tinyint(1) NOT NULL,
  `min_respuestas` int(10) UNSIGNED NOT NULL DEFAULT '4',
  `max_respuestas` int(10) UNSIGNED NOT NULL DEFAULT '4',
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Tipo`
--

INSERT INTO `Tipo` (`id_tipo`, `nombre`, `tiene_subpreguntas`, `min_respuestas`, `max_respuestas`) VALUES
(1, 'Selección Multiple', 0, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VieneDe`
--

DROP TABLE IF EXISTS `VieneDe`;
CREATE TABLE IF NOT EXISTS `VieneDe` (
  `id_subpregunta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  PRIMARY KEY (`id_subpregunta`),
  KEY `id_pregunta` (`id_pregunta`),
  KEY `id_subpregunta` (`id_subpregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Presenta`
--
ALTER TABLE `Presenta`
  ADD CONSTRAINT `presenta_ibfk_1` FOREIGN KEY (`n_cuenta`) REFERENCES `Alumno` (`n_cuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presenta_ibfk_2` FOREIGN KEY (`id_examen`) REFERENCES `Examen` (`id_examen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ReferenciaFuente`
--
ALTER TABLE `ReferenciaFuente`
  ADD CONSTRAINT `referenciafuente_ibfk_1` FOREIGN KEY (`id_referencia`) REFERENCES `Referencia` (`id_referencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `referenciafuente_ibfk_2` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `TemaFuente`
--
ALTER TABLE `TemaFuente`
  ADD CONSTRAINT `temafuente_ibfk_1` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `temafuente_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `VieneDe`
--
ALTER TABLE `VieneDe`
  ADD CONSTRAINT `vienede_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vienede_ibfk_2` FOREIGN KEY (`id_subpregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
