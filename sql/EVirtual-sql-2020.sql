-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-03-2020 a las 07:09:24
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
CREATE TABLE `Alumno` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `nombres` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
CREATE TABLE `BasadoEn` (
  `id_examen` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  `desde_dificultad` tinyint(4) NOT NULL,
  `hasta_dificultad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `BasadoEn`
--

INSERT INTO `BasadoEn` (`id_examen`, `id_tema`, `desde_dificultad`, `hasta_dificultad`) VALUES
(2, 5, 1, 3),
(2, 6, 1, 2),
(3, 5, 1, 3),
(3, 6, 1, 3),
(4, 5, 1, 3),
(4, 6, 1, 2),
(4, 7, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CometeErroresEn`
--

DROP TABLE IF EXISTS `CometeErroresEn`;
CREATE TABLE `CometeErroresEn` (
  `id_respuesta` int(10) NOT NULL,
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  `id_examen` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CometeErroresEn`
--

INSERT INTO `CometeErroresEn` (`id_respuesta`, `n_cuenta`, `id_pregunta`, `id_tema`, `id_examen`) VALUES
(-21, 1, 21, 6, 2),
(-20, 1, 20, 6, 2),
(-19, 1, 19, 6, 2),
(-18, 1, 18, 6, 2),
(-17, 1, 17, 6, 2),
(-16, 1, 16, 5, 2),
(-15, 1, 15, 5, 2),
(-14, 1, 14, 5, 2),
(-13, 1, 13, 5, 2),
(-12, 1, 12, 5, 2),
(-11, 1, 11, 5, 2),
(-10, 1, 10, 5, 2),
(-9, 1, 9, 5, 2),
(-8, 1, 8, 5, 2),
(22, 1, 8, 5, 4),
(54, 1, 16, 5, 2),
(55, 1, 16, 5, 2),
(78, 1, 22, 6, 2),
(95, 1, 26, 7, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contiene`
--

DROP TABLE IF EXISTS `Contiene`;
CREATE TABLE `Contiene` (
  `id_respuesta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
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
(16, 6),
(17, 7),
(18, 7),
(19, 7),
(20, 7),
(21, 8),
(22, 8),
(23, 8),
(24, 8),
(25, 9),
(26, 9),
(27, 9),
(28, 9),
(29, 10),
(30, 10),
(31, 10),
(32, 10),
(33, 11),
(34, 11),
(35, 11),
(36, 11),
(37, 12),
(38, 12),
(39, 12),
(40, 12),
(41, 13),
(42, 13),
(43, 13),
(44, 13),
(45, 14),
(46, 14),
(47, 14),
(48, 14),
(49, 15),
(50, 15),
(51, 15),
(52, 15),
(53, 16),
(54, 16),
(55, 16),
(56, 16),
(57, 17),
(58, 17),
(59, 17),
(60, 17),
(61, 18),
(62, 18),
(63, 18),
(64, 18),
(65, 19),
(66, 19),
(67, 19),
(68, 19),
(69, 20),
(70, 20),
(71, 20),
(72, 20),
(73, 21),
(74, 21),
(75, 21),
(76, 21),
(77, 22),
(78, 22),
(79, 22),
(80, 22),
(81, 23),
(82, 23),
(83, 23),
(84, 23),
(85, 24),
(86, 24),
(87, 24),
(88, 24),
(89, 25),
(90, 25),
(91, 25),
(92, 25),
(93, 26),
(94, 26),
(95, 26),
(96, 26),
(97, 27),
(98, 27),
(99, 27),
(100, 27),
(105, 29),
(106, 29),
(107, 29),
(108, 29),
(109, 36),
(110, 36),
(111, 36),
(112, 36),
(113, 38),
(114, 38),
(115, 38),
(116, 38),
(117, 39),
(118, 39),
(119, 39),
(120, 39),
(121, 40),
(122, 40),
(123, 40),
(124, 40),
(125, 41),
(126, 41),
(127, 41),
(128, 41),
(129, 42),
(130, 42),
(131, 42),
(132, 42),
(133, 43),
(134, 43),
(135, 43),
(136, 43),
(137, 44),
(138, 44),
(139, 44),
(140, 44),
(141, 45),
(142, 45),
(143, 45),
(144, 45),
(145, 46),
(146, 46),
(147, 46),
(148, 46),
(149, 47),
(150, 47),
(151, 47),
(152, 47),
(153, 48),
(154, 48),
(155, 48),
(156, 48),
(157, 49),
(158, 49),
(159, 49),
(160, 49),
(161, 50),
(162, 50),
(163, 50),
(164, 50),
(165, 51),
(166, 51),
(167, 51),
(168, 51),
(169, 52),
(170, 52),
(171, 52),
(172, 52);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cursa`
--

DROP TABLE IF EXISTS `Cursa`;
CREATE TABLE `Cursa` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL,
  `estado` varchar(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Cursa`
--

INSERT INTO `Cursa` (`n_cuenta`, `id_curso`, `estado`) VALUES
(1, 1, 'r'),
(1, 2, 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Curso`
--

DROP TABLE IF EXISTS `Curso`;
CREATE TABLE `Curso` (
  `id_curso` int(10) NOT NULL,
  `clave` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Curso`
--

INSERT INTO `Curso` (`id_curso`, `clave`, `nombre`) VALUES
(1, 1234, 'Redes'),
(2, 1212, '1212'),
(3, 1111, 'Prueba'),
(4, 123, 'Redes'),
(5, 9999, 'nuevo curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoFuente`
--

DROP TABLE IF EXISTS `CursoFuente`;
CREATE TABLE `CursoFuente` (
  `id_curso` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CursoFuente`
--

INSERT INTO `CursoFuente` (`id_curso`, `id_fuente`) VALUES
(1, 4),
(1, 5),
(2, 6),
(2, 7),
(5, 8),
(5, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoPreguntasCompartidas`
--

DROP TABLE IF EXISTS `CursoPreguntasCompartidas`;
CREATE TABLE `CursoPreguntasCompartidas` (
  `id_curso` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL,
  `fecha_de_modificacion` datetime NOT NULL,
  `por_cambiar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CursoPreguntasCompartidas`
--

INSERT INTO `CursoPreguntasCompartidas` (`id_curso`, `id_pregunta`, `fecha_de_modificacion`, `por_cambiar`) VALUES
(1, 26, '2020-02-19 04:47:56', 1),
(2, 26, '2020-02-19 04:47:56', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoTema`
--

DROP TABLE IF EXISTS `CursoTema`;
CREATE TABLE `CursoTema` (
  `id_tema` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL,
  `cantidad_preguntas` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `CursoTema`
--

INSERT INTO `CursoTema` (`id_tema`, `id_curso`, `cantidad_preguntas`) VALUES
(1, 1, 1),
(4, 1, 2),
(5, 2, 9),
(6, 2, 9),
(7, 5, 10),
(8, 5, 10);

--
-- Disparadores `CursoTema`
--
DROP TRIGGER IF EXISTS `ActualizarCursoTema`;
DELIMITER $$
CREATE TRIGGER `ActualizarCursoTema` AFTER UPDATE ON `CursoTema` FOR EACH ROW BEGIN
IF NEW.cantidad_preguntas = 0 THEN
	DELETE FROM CursoTema WHERE id_tema = NEW.id_tema;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DeTipo`
--

DROP TABLE IF EXISTS `DeTipo`;
CREATE TABLE `DeTipo` (
  `id_pregunta` int(10) NOT NULL,
  `id_tipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `DeTipo`
--

INSERT INTO `DeTipo` (`id_pregunta`, `id_tipo`) VALUES
(2, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Edicion`
--

DROP TABLE IF EXISTS `Edicion`;
CREATE TABLE `Edicion` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `anio` smallint(6) NOT NULL,
  `liga` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Edicion`
--

INSERT INTO `Edicion` (`id_fuente`, `numero`, `anio`, `liga`) VALUES
(4, 1, 1999, ''),
(5, 1, 2010, ''),
(6, 1, 1999, ''),
(7, 2, 2000, ''),
(8, 1, 1990, ''),
(9, 2, 1992, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Evalua`
--

DROP TABLE IF EXISTS `Evalua`;
CREATE TABLE `Evalua` (
  `id_examen` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Evalua`
--

INSERT INTO `Evalua` (`id_examen`, `id_curso`) VALUES
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Examen`
--

DROP TABLE IF EXISTS `Examen`;
CREATE TABLE `Examen` (
  `id_examen` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `oportunidades` tinyint(4) NOT NULL,
  `vidas` tinyint(4) NOT NULL,
  `preguntas_por_mostrar` int(10) UNSIGNED NOT NULL,
  `preguntas_por_mezclar` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Examen`
--

INSERT INTO `Examen` (`id_examen`, `nombre`, `fecha_inicio`, `fecha_fin`, `oportunidades`, `vidas`, `preguntas_por_mostrar`, `preguntas_por_mezclar`) VALUES
(2, 'Examen chido: (2019-10-03)', '2019-10-04 00:00:00', '2019-11-04 00:00:00', 4, 2, 10, 15),
(3, 'Examen: (2019-11-12)', '2019-11-12 00:00:00', '2019-12-12 00:00:00', 3, 1, 10, 18),
(4, 'Examen: (2020-01-03)', '2020-01-03 00:00:00', '2020-02-03 00:00:00', 3, 1, 10, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fuente`
--

DROP TABLE IF EXISTS `Fuente`;
CREATE TABLE `Fuente` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `autores` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Fuente`
--

INSERT INTO `Fuente` (`id_fuente`, `autores`, `nombre`) VALUES
(4, 'autores', 'nombre'),
(5, 'Autor Rojo, Autor Azul, Autor Verde', 'libro azul'),
(6, 'Autor chido', 'El libro mas chido'),
(7, 'Autor no tan chido', 'Un libro no tan chido'),
(8, 'bib aut 1', 'biblio 1'),
(9, 'aut 2', 'biblio 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FundamentadoEn`
--

DROP TABLE IF EXISTS `FundamentadoEn`;
CREATE TABLE `FundamentadoEn` (
  `id_referencia` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `FundamentadoEn`
--

INSERT INTO `FundamentadoEn` (`id_referencia`, `id_pregunta`) VALUES
(1, 2),
(4, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9),
(9, 10),
(10, 11),
(11, 12),
(12, 13),
(13, 14),
(14, 15),
(15, 16),
(16, 17),
(17, 18),
(18, 19),
(19, 20),
(20, 21),
(21, 22),
(22, 23),
(23, 24),
(24, 25),
(25, 26),
(26, 27),
(28, 29),
(29, 36),
(25, 38),
(25, 39),
(25, 40),
(30, 41),
(30, 42),
(25, 43),
(30, 44),
(30, 45),
(30, 46),
(30, 47),
(30, 48),
(25, 49),
(30, 50),
(30, 51),
(30, 52);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Genera`
--

DROP TABLE IF EXISTS `Genera`;
CREATE TABLE `Genera` (
  `id_pregunta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Genera`
--

INSERT INTO `Genera` (`id_pregunta`, `id_tema`) VALUES
(2, 1),
(6, 1),
(5, 4),
(7, 4),
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(26, 7),
(27, 7),
(29, 7),
(36, 7),
(38, 7),
(39, 7),
(40, 7),
(43, 7),
(49, 7),
(41, 8),
(42, 8),
(44, 8),
(45, 8),
(46, 8),
(47, 8),
(48, 8),
(50, 8),
(51, 8),
(52, 8);

--
-- Disparadores `Genera`
--
DROP TRIGGER IF EXISTS `BorrarGenera`;
DELIMITER $$
CREATE TRIGGER `BorrarGenera` BEFORE DELETE ON `Genera` FOR EACH ROW BEGIN
DECLARE cantidad_curso_tema INT(10);
DECLARE cantidad_tema_fuente INT(10);
SELECT cantidad_preguntas INTO cantidad_curso_tema FROM CursoTema WHERE CursoTema.id_tema = OLD.id_tema;
UPDATE CursoTema SET cantidad_preguntas = cantidad_curso_tema - 1 WHERE CursoTema.id_tema = OLD.id_tema;
SELECT cantidad_preguntas INTO cantidad_tema_fuente  FROM TemaFuente WHERE TemaFuente.id_tema = OLD.id_tema;
UPDATE TemaFuente SET cantidad_preguntas = cantidad_tema_fuente - 1 WHERE TemaFuente.id_tema = OLD.id_tema;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imparte`
--

DROP TABLE IF EXISTS `Imparte`;
CREATE TABLE `Imparte` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Imparte`
--

INSERT INTO `Imparte` (`n_trabajador`, `id_curso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pregunta`
--

DROP TABLE IF EXISTS `Pregunta`;
CREATE TABLE `Pregunta` (
  `id_pregunta` int(10) NOT NULL,
  `dificultad` tinyint(4) NOT NULL,
  `texto` text COLLATE utf8_spanish_ci NOT NULL,
  `justificacion` text COLLATE utf8_spanish_ci NOT NULL,
  `tiene_subpreguntas` tinyint(1) NOT NULL,
  `tiempo` int(10) UNSIGNED NOT NULL DEFAULT '30',
  `compartida` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Pregunta`
--

INSERT INTO `Pregunta` (`id_pregunta`, `dificultad`, `texto`, `justificacion`, `tiene_subpreguntas`, `tiempo`, `compartida`) VALUES
(5, 2, 'esta es la pregunta 2', 'justificación 2', 0, 20, 0),
(6, 1, 'la tercer pregunta', 'tercera justificación', 0, 23, 0),
(7, 3, 'esta es la pregunta 2.2', 'justificación 2', 0, 20, 0),
(8, 1, '¿Esta es la pregunta 1?', 'Justificación 1', 0, 30, 0),
(9, 1, '¿Esta es la pregunta 2?', 'Justificación 2', 0, 30, 0),
(10, 2, '¿Esta es la pregunta 3?', 'Justificación 3', 0, 30, 0),
(11, 2, '¿Esta es la pregunta 4?', 'Justificación 4', 0, 30, 0),
(12, 2, '¿Esta es la pregunta 5?', 'Justificación 5', 0, 30, 0),
(13, 3, '¿Esta es la pregunta 6?', 'Justificación 6', 0, 30, 0),
(14, 3, '¿Esta es la pregunta 7?', 'Justificación 7', 0, 30, 0),
(15, 3, '¿Esta es la pregunta 8?', 'Justificación 8', 0, 30, 0),
(16, 3, '¿Esta es la pregunta 9?', 'Justificación 9', 0, 30, 0),
(17, 1, '¿Esta es la pregunta 10?', 'Justificación 10', 0, 30, 0),
(18, 1, '¿Esta es la pregunta 11?', 'Justificación 11', 0, 30, 0),
(19, 1, '¿Esta es la pregunta 12?', 'Justificación 12', 0, 30, 0),
(20, 1, '¿Esta es la pregunta 13?', 'Justificación 13', 0, 30, 0),
(21, 2, '¿Esta es la pregunta 14?', 'Justificación 14', 0, 30, 0),
(22, 2, '¿Esta es la pregunta 15?', 'Justificación 15', 0, 30, 0),
(23, 3, '¿Esta es la pregunta 16?', 'Justificación 16', 0, 30, 0),
(24, 3, '¿Esta es la pregunta 17?', 'Justificación 17', 0, 30, 0),
(25, 3, '¿Esta es la pregunta 18?', 'Justificación 18', 0, 30, 0),
(26, 1, 'Pregunta número 1 nueva juas juas', 'Justificación 1', 0, 30, 1),
(27, 1, 'Pregunta número 1', 'Justificación 1', 0, 30, 0),
(29, 1, 'Pregunta número 2', 'Justificación 2', 0, 30, 0),
(30, 2, 'pregunta número P1', 'P1 J1', 0, 30, 0),
(31, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(32, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(33, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(34, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(35, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(36, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(37, 1, 'Pregunta número 1 new', 'Justificación 1', 0, 30, 0),
(38, 1, 'Pregunta número 1 new', 'Justificación 1', 0, 30, 0),
(39, 1, 'Pregunta número 1 new', 'Justificación 1', 0, 30, 0),
(40, 1, 'Pregunta número 1 new', 'Justificación 1', 0, 30, 0),
(41, 2, 'Pregunta número P222', 'J2 P2', 0, 40, 0),
(42, 2, 'Pregunta número P2.1.2', 'J2 P2', 0, 40, 1),
(43, 1, 'Pregunta número 1 new', 'Justificación 1', 0, 30, 0),
(44, 2, 'Pregunta número P2.1', 'J2 P2', 0, 40, 0),
(45, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(46, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(47, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(48, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(49, 1, 'Pregunta número 1 nueva', 'Justificación 1', 0, 30, 0),
(50, 2, 'Pregunta número P222.234', 'J2 P2', 0, 40, 1),
(51, 2, 'Pregunta número P222..', 'J2 P2', 0, 40, 0),
(52, 2, 'Pregunta número P222.1111111', 'J2 P2', 0, 40, 0);

--
-- Disparadores `Pregunta`
--
DROP TRIGGER IF EXISTS `BorraPregunta`;
DELIMITER $$
CREATE TRIGGER `BorraPregunta` BEFORE DELETE ON `Pregunta` FOR EACH ROW BEGIN
DELETE FROM Genera WHERE Genera.id_pregunta = OLD.id_pregunta;
DELETE FROM FundamentadoEn WHERE FundamentadoEn.id_pregunta = OLD.id_pregunta;
DELETE FROM DeTipo WHERE DeTipo.id_pregunta = OLD.id_pregunta;
DELETE FROM Respuesta WHERE Respuesta.id_respuesta IN (SELECT id_respuesta FROM Contiene WHERE Contiene.id_pregunta = OLD.id_pregunta);
DELETE FROM Contiene WHERE Contiene.id_pregunta = OLD.id_pregunta;
DELETE FROM VieneDe WHERE VieneDe.id_pregunta = OLD.id_pregunta;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Presenta`
--

DROP TABLE IF EXISTS `Presenta`;
CREATE TABLE `Presenta` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_examen` int(10) NOT NULL,
  `calificacion` tinyint(3) UNSIGNED NOT NULL,
  `vidas` tinyint(4) UNSIGNED NOT NULL,
  `oportunidades` tinyint(4) UNSIGNED NOT NULL,
  `terminado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Presenta`
--

INSERT INTO `Presenta` (`n_cuenta`, `id_examen`, `calificacion`, `vidas`, `oportunidades`, `terminado`) VALUES
(1, 2, 8, 2, 0, 1),
(1, 4, 8, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Profesor`
--

DROP TABLE IF EXISTS `Profesor`;
CREATE TABLE `Profesor` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `nombres` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Profesor`
--

INSERT INTO `Profesor` (`n_trabajador`, `nombres`, `apellidos`, `correo`, `contrasenia`) VALUES
(1, 'yolo', 'qwerty', 'p@p.p', '516b9783fca517eecbd1d064da2d165310b19759'),
(2, 'q', 'q', 'q@q.q', '22ea1c649c82946aa6e479e1ffd321e4a318b1b0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Referencia`
--

DROP TABLE IF EXISTS `Referencia`;
CREATE TABLE `Referencia` (
  `id_referencia` int(10) NOT NULL,
  `capitulo` tinyint(4) NOT NULL,
  `pagina` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Referencia`
--

INSERT INTO `Referencia` (`id_referencia`, `capitulo`, `pagina`) VALUES
(4, 2, 2),
(5, 22, 22),
(6, 2, 2),
(7, 1, 11),
(8, 1, 12),
(9, 1, 13),
(10, 1, 13),
(11, 2, 14),
(12, 2, 14),
(13, 2, 14),
(14, 2, 14),
(15, 2, 14),
(16, 1, 12),
(17, 1, 12),
(18, 1, 12),
(19, 1, 13),
(20, 1, 13),
(21, 2, 14),
(22, 1, 14),
(23, 1, 14),
(24, 1, 14),
(25, 1, 12),
(26, 1, 12),
(27, 1, 12),
(28, 1, 12),
(29, 12, 123),
(30, 2, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ReferenciaFuente`
--

DROP TABLE IF EXISTS `ReferenciaFuente`;
CREATE TABLE `ReferenciaFuente` (
  `id_referencia` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `numero_edicion` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ReferenciaFuente`
--

INSERT INTO `ReferenciaFuente` (`id_referencia`, `id_fuente`, `numero_edicion`) VALUES
(4, 4, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 1),
(8, 6, 1),
(9, 6, 1),
(10, 6, 1),
(11, 6, 1),
(12, 6, 1),
(13, 6, 1),
(14, 6, 1),
(15, 6, 1),
(16, 6, 1),
(17, 6, 1),
(18, 6, 1),
(19, 6, 1),
(20, 6, 1),
(21, 6, 1),
(22, 7, 2),
(23, 7, 2),
(24, 7, 2),
(25, 8, 1),
(26, 8, 1),
(27, 8, 1),
(28, 8, 1),
(29, 8, 1),
(30, 9, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RespaldoDe`
--

DROP TABLE IF EXISTS `RespaldoDe`;
CREATE TABLE `RespaldoDe` (
  `id_pregunta` int(10) NOT NULL,
  `id_pregunta_respaldo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Respuesta`
--

DROP TABLE IF EXISTS `Respuesta`;
CREATE TABLE `Respuesta` (
  `id_respuesta` int(10) NOT NULL,
  `contenido` text COLLATE utf8_spanish_ci NOT NULL,
  `porcentaje` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Respuesta`
--

INSERT INTO `Respuesta` (`id_respuesta`, `contenido`, `porcentaje`) VALUES
(9, 'resp 1', 100),
(10, 'resp 2', 0),
(11, 'resp 3', 0),
(12, 'resp 4', 0),
(13, 'resp 1', 100),
(14, 'fghj', 0),
(15, 'ghjk', 0),
(16, 'hjklmn', 0),
(17, 'resp 1', 0),
(18, 'resp 2', 100),
(19, 'resp 3', 0),
(20, 'resp 4', 0),
(21, 'resp 1', 100),
(22, 'resp 2', 0),
(23, 'resp 3', 0),
(24, 'resp 4', 0),
(25, 'resp 1', 100),
(26, 'resp 2', 0),
(27, 'resp 3', 0),
(28, 'resp 4', 0),
(29, 'resp 1', 100),
(30, 'resp 2', 0),
(31, 'resp 3', 0),
(32, 'resp 4', 0),
(33, 'resp 1', 100),
(34, 'resp 2', 0),
(35, 'resp 3', 0),
(36, 'resp 4', 0),
(37, 'resp 1', 100),
(38, 'resp 2', 0),
(39, 'resp 3', 0),
(40, 'resp 4', 0),
(41, 'resp 1', 100),
(42, 'resp 2', 0),
(43, 'resp 3', 0),
(44, 'resp 4', 0),
(45, 'resp 1', 100),
(46, 'resp 2', 0),
(47, 'resp 3', 0),
(48, 'resp 4', 0),
(49, 'resp 1', 100),
(50, 'resp 2', 0),
(51, 'resp 3', 0),
(52, 'resp 4', 0),
(53, 'resp 1', 100),
(54, 'resp 2', 0),
(55, 'resp 3', 0),
(56, 'resp 4', 0),
(57, 'resp 1', 100),
(58, 'resp 2', 0),
(59, 'resp 3', 0),
(60, 'resp 4', 0),
(61, 'resp 1', 100),
(62, 'resp 2', 0),
(63, 'resp 3', 0),
(64, 'resp 4', 0),
(65, 'resp 1', 100),
(66, 'resp 2', 0),
(67, 'resp 3', 0),
(68, 'resp 4', 0),
(69, 'resp 1', 100),
(70, 'resp 2', 0),
(71, 'resp 3', 0),
(72, 'resp 4', 0),
(73, 'resp 1', 100),
(74, 'resp 2', 0),
(75, 'resp 3', 0),
(76, 'resp 4', 0),
(77, 'resp 1', 100),
(78, 'resp 2', 0),
(79, 'resp 3', 0),
(80, 'resp 4', 0),
(81, 'resp 1', 100),
(82, 'resp 2', 0),
(83, 'resp 3', 0),
(84, 'resp 4', 0),
(85, 'resp 1', 100),
(86, 'resp 2', 0),
(87, 'resp 3', 0),
(88, 'resp 4', 0),
(89, 'resp 1', 100),
(90, 'resp 2', 0),
(91, 'resp 3', 0),
(92, 'resp 4', 0),
(93, 'buena', 100),
(94, 'mala', 0),
(95, 'mala', 0),
(96, 'mala', 0),
(97, 'buena', 100),
(98, 'mala', 0),
(99, 'mala', 0),
(100, 'mala', 0),
(105, 'buena', 100),
(106, 'mala', 0),
(107, 'mala', 0),
(108, 'mala', 0),
(109, 'P1', 100),
(110, '0', 0),
(111, '0', 0),
(112, '0', 0),
(113, 'buena', 100),
(114, 'mala', 0),
(115, 'mala', 0),
(116, 'mala', 0),
(117, 'buena', 100),
(118, 'mala', 0),
(119, 'mala', 0),
(120, 'mala', 0),
(121, 'buena', 100),
(122, 'mala', 0),
(123, 'mala', 0),
(124, 'mala', 0),
(125, 'P2', 100),
(126, '0', 0),
(127, '0', 0),
(128, '0', 0),
(129, 'P2', 100),
(130, '0', 0),
(131, '0', 0),
(132, '0', 0),
(133, 'buena', 100),
(134, 'mala', 0),
(135, 'mala', 0),
(136, 'mala', 0),
(137, 'P2', 100),
(138, '0', 0),
(139, '0', 0),
(140, '0', 0),
(141, 'P2', 100),
(142, '0', 0),
(143, '0', 0),
(144, '0', 0),
(145, 'P2', 100),
(146, '0', 0),
(147, '0', 0),
(148, '0', 0),
(149, 'P2', 100),
(150, '0', 0),
(151, '0', 0),
(152, '0', 0),
(153, 'P2', 100),
(154, '0', 0),
(155, '0', 0),
(156, '0', 0),
(157, 'buena', 100),
(158, 'mala', 0),
(159, 'mala', 0),
(160, 'mala', 0),
(161, 'P2', 100),
(162, '0', 0),
(163, '0', 0),
(164, '0', 0),
(165, 'P2', 100),
(166, '0', 0),
(167, '0', 0),
(168, '0', 0),
(169, 'P2', 100),
(170, '0', 0),
(171, '0', 0),
(172, '0', 0);

--
-- Disparadores `Respuesta`
--
DROP TRIGGER IF EXISTS `BorrarRespuesta`;
DELIMITER $$
CREATE TRIGGER `BorrarRespuesta` BEFORE DELETE ON `Respuesta` FOR EACH ROW BEGIN
DELETE FROM CometeErroresEn WHERE CometeErroresEn.id_respuesta = OLD.id_respuesta;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tema`
--

DROP TABLE IF EXISTS `Tema`;
CREATE TABLE `Tema` (
  `id_tema` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Tema`
--

INSERT INTO `Tema` (`id_tema`, `nombre`) VALUES
(1, 'el tema'),
(4, 'Segundo tema'),
(5, 'Tema 1'),
(6, 'Tema 2'),
(7, 'El tema número 1'),
(8, 'El tema número 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TemaFuente`
--

DROP TABLE IF EXISTS `TemaFuente`;
CREATE TABLE `TemaFuente` (
  `id_tema` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `cantidad_preguntas` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `TemaFuente`
--

INSERT INTO `TemaFuente` (`id_tema`, `id_fuente`, `cantidad_preguntas`) VALUES
(1, 4, 1),
(4, 4, 2),
(5, 6, 9),
(6, 6, 6),
(6, 7, 3),
(7, 8, 10),
(8, 9, 10);

--
-- Disparadores `TemaFuente`
--
DROP TRIGGER IF EXISTS `ActualizarTemaFuente`;
DELIMITER $$
CREATE TRIGGER `ActualizarTemaFuente` BEFORE INSERT ON `TemaFuente` FOR EACH ROW BEGIN
IF NEW.cantidad_preguntas = 0 THEN
	DELETE FROM TemaFuente WHERE id_tema = NEW.id_tema;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tipo`
--

DROP TABLE IF EXISTS `Tipo`;
CREATE TABLE `Tipo` (
  `id_tipo` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `tiene_subpreguntas` tinyint(1) NOT NULL,
  `min_respuestas` int(10) UNSIGNED NOT NULL DEFAULT '4',
  `max_respuestas` int(10) UNSIGNED NOT NULL DEFAULT '4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
CREATE TABLE `VieneDe` (
  `id_subpregunta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Disparadores `VieneDe`
--
DROP TRIGGER IF EXISTS `BorrarVieneDe`;
DELIMITER $$
CREATE TRIGGER `BorrarVieneDe` AFTER DELETE ON `VieneDe` FOR EACH ROW BEGIN
DELETE FROM Pregunta WHERE Pregunta.id_pregunta = OLD.id_subpregunta;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Alumno`
--
ALTER TABLE `Alumno`
  ADD PRIMARY KEY (`n_cuenta`);

--
-- Indices de la tabla `BasadoEn`
--
ALTER TABLE `BasadoEn`
  ADD PRIMARY KEY (`id_examen`,`id_tema`),
  ADD KEY `id_examen` (`id_examen`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `CometeErroresEn`
--
ALTER TABLE `CometeErroresEn`
  ADD PRIMARY KEY (`id_respuesta`,`n_cuenta`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_alumno` (`n_cuenta`),
  ADD KEY `id_respuesta` (`id_respuesta`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `Contiene`
--
ALTER TABLE `Contiene`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indices de la tabla `Cursa`
--
ALTER TABLE `Cursa`
  ADD PRIMARY KEY (`n_cuenta`,`id_curso`),
  ADD KEY `n_cuenta` (`n_cuenta`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `Curso`
--
ALTER TABLE `Curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `CursoFuente`
--
ALTER TABLE `CursoFuente`
  ADD PRIMARY KEY (`id_curso`,`id_fuente`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_fuente` (`id_fuente`);

--
-- Indices de la tabla `CursoPreguntasCompartidas`
--
ALTER TABLE `CursoPreguntasCompartidas`
  ADD PRIMARY KEY (`id_curso`,`id_pregunta`);

--
-- Indices de la tabla `CursoTema`
--
ALTER TABLE `CursoTema`
  ADD PRIMARY KEY (`id_tema`,`id_curso`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `DeTipo`
--
ALTER TABLE `DeTipo`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `Edicion`
--
ALTER TABLE `Edicion`
  ADD PRIMARY KEY (`id_fuente`,`numero`),
  ADD KEY `id_fuente` (`id_fuente`);

--
-- Indices de la tabla `Evalua`
--
ALTER TABLE `Evalua`
  ADD PRIMARY KEY (`id_examen`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `Examen`
--
ALTER TABLE `Examen`
  ADD PRIMARY KEY (`id_examen`);

--
-- Indices de la tabla `Fuente`
--
ALTER TABLE `Fuente`
  ADD PRIMARY KEY (`id_fuente`);

--
-- Indices de la tabla `FundamentadoEn`
--
ALTER TABLE `FundamentadoEn`
  ADD PRIMARY KEY (`id_referencia`,`id_pregunta`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_referencia` (`id_referencia`);

--
-- Indices de la tabla `Genera`
--
ALTER TABLE `Genera`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indices de la tabla `Imparte`
--
ALTER TABLE `Imparte`
  ADD PRIMARY KEY (`n_trabajador`,`id_curso`),
  ADD KEY `n_trabajador` (`n_trabajador`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `Pregunta`
--
ALTER TABLE `Pregunta`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indices de la tabla `Presenta`
--
ALTER TABLE `Presenta`
  ADD PRIMARY KEY (`n_cuenta`,`id_examen`),
  ADD KEY `n_cuenta` (`n_cuenta`),
  ADD KEY `id_examen` (`id_examen`);

--
-- Indices de la tabla `Profesor`
--
ALTER TABLE `Profesor`
  ADD PRIMARY KEY (`n_trabajador`);

--
-- Indices de la tabla `Referencia`
--
ALTER TABLE `Referencia`
  ADD PRIMARY KEY (`id_referencia`);

--
-- Indices de la tabla `ReferenciaFuente`
--
ALTER TABLE `ReferenciaFuente`
  ADD PRIMARY KEY (`id_referencia`),
  ADD KEY `id_fuente` (`id_fuente`),
  ADD KEY `id_referencia` (`id_referencia`);

--
-- Indices de la tabla `RespaldoDe`
--
ALTER TABLE `RespaldoDe`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indices de la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  ADD PRIMARY KEY (`id_respuesta`);

--
-- Indices de la tabla `Tema`
--
ALTER TABLE `Tema`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indices de la tabla `TemaFuente`
--
ALTER TABLE `TemaFuente`
  ADD PRIMARY KEY (`id_tema`,`id_fuente`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_fuente` (`id_fuente`);

--
-- Indices de la tabla `Tipo`
--
ALTER TABLE `Tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `VieneDe`
--
ALTER TABLE `VieneDe`
  ADD PRIMARY KEY (`id_subpregunta`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_subpregunta` (`id_subpregunta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Alumno`
--
ALTER TABLE `Alumno`
  MODIFY `n_cuenta` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Curso`
--
ALTER TABLE `Curso`
  MODIFY `id_curso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Examen`
--
ALTER TABLE `Examen`
  MODIFY `id_examen` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `Fuente`
--
ALTER TABLE `Fuente`
  MODIFY `id_fuente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `Pregunta`
--
ALTER TABLE `Pregunta`
  MODIFY `id_pregunta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT de la tabla `Profesor`
--
ALTER TABLE `Profesor`
  MODIFY `n_trabajador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `Referencia`
--
ALTER TABLE `Referencia`
  MODIFY `id_referencia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  MODIFY `id_respuesta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT de la tabla `Tema`
--
ALTER TABLE `Tema`
  MODIFY `id_tema` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `Tipo`
--
ALTER TABLE `Tipo`
  MODIFY `id_tipo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
CREATE VIEW PreguntasExternas AS
SELECT `CursoPreguntasCompartidas`.`id_pregunta`,`CursoPreguntasCompartidas`.`id_curso`
FROM `CursoPreguntasCompartidas`
WHERE `CursoPreguntasCompartidas`.`por_cambiar` <> 1
UNION (SELECT `RespaldoDe`.`id_pregunta_respaldo`,`CursoPreguntasCompartidas`.`id_curso`
  FROM `CursoPreguntasCompartidas`
  JOIN `RespaldoDe` ON `RespaldoDe`.`id_pregunta` = `CursoPreguntasCompartidas`.`id_pregunta`
  WHERE `CursoPreguntasCompartidas`.`por_cambiar` = 1);