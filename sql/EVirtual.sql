-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-05-2020 a las 04:19:38
-- Versión del servidor: 5.7.18
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
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
(1, 'alumno', 'escolar', 'a@a.a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(2, 'b', 'b', 'b@b.b', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98'),
(3, 'c', 'c', 'c@c.c', '84a516841ba77a5b4648de2cd0dfcb30ea46dbb4');

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
(-104, 1, 104, 5, 3),
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
(172, 52),
(181, 55),
(182, 55),
(183, 55),
(184, 55),
(185, 56),
(186, 56),
(187, 56),
(188, 56),
(189, 57),
(190, 57),
(191, 57),
(192, 57),
(193, 58),
(194, 58),
(195, 58),
(196, 58),
(197, 59),
(198, 59),
(199, 59),
(200, 59),
(201, 60),
(202, 60),
(203, 60),
(204, 60),
(209, 62),
(210, 62),
(211, 62),
(212, 62),
(217, 64),
(218, 64),
(219, 64),
(220, 64),
(221, 65),
(222, 65),
(223, 65),
(224, 65),
(225, 66),
(226, 66),
(227, 66),
(228, 66),
(229, 67),
(230, 67),
(231, 67),
(232, 67),
(233, 68),
(234, 68),
(235, 68),
(236, 68),
(241, 70),
(242, 70),
(243, 70),
(244, 70),
(245, 71),
(246, 71),
(247, 71),
(248, 71),
(253, 73),
(254, 73),
(255, 73),
(256, 73),
(261, 75),
(262, 75),
(263, 75),
(264, 75),
(265, 76),
(266, 76),
(267, 76),
(268, 76),
(269, 77),
(270, 77),
(271, 77),
(272, 77),
(273, 78),
(274, 78),
(275, 78),
(276, 78),
(277, 79),
(278, 79),
(279, 79),
(280, 79),
(281, 80),
(282, 80),
(283, 80),
(284, 80),
(285, 81),
(286, 81),
(287, 81),
(288, 81),
(289, 82),
(290, 82),
(291, 82),
(292, 82),
(293, 83),
(294, 83),
(295, 83),
(296, 83),
(297, 84),
(298, 84),
(299, 84),
(300, 84),
(301, 85),
(302, 85),
(303, 85),
(304, 85),
(309, 87),
(310, 87),
(311, 87),
(312, 87),
(317, 89),
(318, 89),
(319, 89),
(320, 89),
(321, 90),
(322, 90),
(323, 90),
(324, 90),
(325, 91),
(326, 91),
(327, 91),
(328, 91),
(329, 92),
(330, 92),
(331, 92),
(332, 92),
(333, 93),
(334, 93),
(335, 93),
(336, 93),
(337, 94),
(338, 94),
(339, 94),
(340, 94),
(341, 95),
(342, 95),
(343, 95),
(344, 95),
(345, 96),
(346, 96),
(347, 96),
(348, 96),
(349, 97),
(350, 97),
(351, 97),
(352, 97),
(357, 99),
(358, 99),
(359, 99),
(360, 99),
(361, 100),
(362, 100),
(363, 100),
(364, 100),
(365, 101),
(366, 101),
(367, 101),
(368, 101),
(373, 103),
(374, 103),
(375, 103),
(376, 103),
(377, 104),
(378, 104),
(379, 104),
(380, 104),
(381, 105),
(382, 105),
(383, 105),
(384, 105),
(389, 107),
(390, 107),
(391, 107),
(392, 107);

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
(1, 2, 'a'),
(2, 2, 'a'),
(3, 2, 'e');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Curso`
--

DROP TABLE IF EXISTS `Curso`;
CREATE TABLE `Curso` (
  `id_curso` int(10) NOT NULL,
  `clave` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Curso`
--

INSERT INTO `Curso` (`id_curso`, `clave`, `nombre`, `activo`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 1234, 'Redes', 1, '2020-05-01 23:47:28', '2020-10-01 23:47:28'),
(2, 1212, 'El chido', 1, '2020-04-11 13:55:18', '2020-10-11 14:12:20'),
(3, 1111, 'Prueba', 1, '2020-04-11 13:55:18', '2020-10-11 14:12:20'),
(4, 123, 'Redes 1', 0, '2020-04-28 23:11:30', '2020-09-28 23:11:30'),
(5, 9999, 'Nuevo curso', 1, '2020-04-11 00:00:00', '2020-09-11 00:00:00');

--
-- Disparadores `Curso`
--
DROP TRIGGER IF EXISTS `fecha_fin_curso`;
DELIMITER $$
CREATE TRIGGER `fecha_fin_curso` BEFORE INSERT ON `Curso` FOR EACH ROW BEGIN
SET NEW.fecha_fin = NOW() + INTERVAL 5 MONTH;
END
$$
DELIMITER ;

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
(1, 8),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(4, 10),
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
(1, 100, '2020-05-04 00:29:49', 0),
(2, 42, '2020-04-29 17:07:11', 0);

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
(4, 1, 1),
(5, 2, 11),
(6, 2, 10),
(7, 2, 1),
(8, 5, 17),
(9, 5, 20),
(12, 5, 2),
(13, 1, 1),
(14, 2, 1);

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
(52, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(62, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(70, 1),
(71, 1),
(73, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(87, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(99, 1),
(100, 1),
(101, 1),
(103, 1),
(104, 1),
(105, 1),
(107, 1);

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
(9, 2, 1992, ''),
(10, 6, 1996, '');

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
(2, 'Examen chidoris', '2019-10-04 00:00:00', '2019-11-04 23:59:59', 4, 2, 10, 16),
(3, 'Examen: (2019-11-12)', '2019-11-12 00:00:00', '2020-12-12 00:00:00', 3, 1, 10, 18),
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
(9, 'aut 2', 'biblio 2'),
(10, 'Autor de la fuente 1', 'Fuente 1');

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
(30, 52),
(29, 55),
(29, 56),
(29, 57),
(29, 58),
(25, 59),
(25, 60),
(25, 62),
(25, 64),
(25, 65),
(25, 66),
(25, 67),
(25, 68),
(30, 70),
(30, 71),
(30, 73),
(30, 75),
(30, 76),
(30, 77),
(30, 78),
(30, 79),
(30, 80),
(30, 81),
(30, 82),
(30, 83),
(30, 84),
(30, 85),
(30, 87),
(30, 89),
(30, 90),
(30, 91),
(30, 92),
(30, 93),
(30, 94),
(30, 95),
(30, 96),
(30, 97),
(30, 99),
(31, 100),
(31, 101),
(31, 103),
(32, 104),
(32, 105),
(30, 107);

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
(8, 5),
(9, 5),
(10, 5),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(104, 5),
(105, 5),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(99, 6),
(26, 7),
(27, 7),
(29, 7),
(36, 7),
(38, 7),
(39, 7),
(40, 7),
(43, 7),
(49, 7),
(55, 7),
(56, 7),
(57, 7),
(58, 7),
(59, 7),
(60, 7),
(62, 7),
(64, 7),
(65, 7),
(66, 7),
(67, 7),
(41, 8),
(42, 8),
(44, 8),
(45, 8),
(46, 8),
(47, 8),
(48, 8),
(50, 8),
(51, 8),
(52, 8),
(70, 8),
(71, 8),
(73, 8),
(75, 8),
(76, 8),
(77, 8),
(78, 8),
(79, 8),
(80, 8),
(81, 8),
(82, 8),
(83, 8),
(84, 8),
(85, 8),
(87, 8),
(89, 8),
(90, 8),
(91, 8),
(92, 8),
(93, 8),
(94, 8),
(95, 8),
(96, 8),
(97, 8),
(68, 9),
(100, 9),
(101, 12),
(103, 13),
(107, 14);

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
-- Estructura de tabla para la tabla `Pendiente`
--

DROP TABLE IF EXISTS `Pendiente`;
CREATE TABLE `Pendiente` (
  `clave` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_usuario` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
(8, 1, '¿Esta es la pregunta 1?', 'Justificación 1', 0, 30, 0),
(9, 1, '¿Esta es la pregunta 2?', 'Justificación 2', 0, 30, 0),
(10, 2, '¿Esta es la pregunta 3?', 'Justificación 3', 0, 30, 0),
(11, 2, 'https://www.youtube.com/watch?v=MjwtTSoIYYs', 'Justificación 4', 0, 30, 0),
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
(26, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1000', 0, 30, 1),
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
(42, 2, 'Pregunta número P2.1.2 TODES', 'J2 P2 N2', 0, 40, 1),
(43, 1, 'Pregunta número 1 new', 'Justificación 1', 0, 30, 0),
(44, 2, 'Pregunta número P2.1', 'J2 P2', 0, 40, 0),
(45, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(46, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(47, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(48, 2, 'Pregunta número P2.1.1', 'J2 P2', 0, 40, 0),
(49, 1, 'Pregunta número 1 nueva', 'Justificación 1', 0, 30, 0),
(50, 2, 'Pregunta número P222.234', 'J2 P2', 0, 40, 1),
(51, 2, 'Pregunta número P222..', 'J2 P2', 0, 40, 0),
(52, 2, 'Pregunta número P222.1111111', 'J2 P2', 0, 40, 0),
(55, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(56, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(57, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(58, 2, 'Pregunta número P1', 'J1', 0, 30, 0),
(59, 1, 'Pregunta número 1 nueva lolol', 'Justificación 1', 0, 30, 0),
(60, 1, 'Pregunta número 1 nueva lolol', 'Justificación 1', 0, 30, 0),
(62, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1', 0, 30, 0),
(64, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1', 0, 30, 0),
(65, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1', 0, 30, 0),
(66, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1', 0, 30, 0),
(67, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1', 0, 30, 0),
(68, 1, 'Pregunta número 1 nueva cambio', 'Justificación 1', 0, 30, 0),
(70, 2, 'Pregunta número P2.1.2', 'J2 P2', 0, 40, 0),
(71, 2, 'Pregunta número P2.1.2', 'J2 P2', 0, 40, 0),
(73, 2, 'Pregunta número P2.1.2 Juas Juas', 'J2 P2', 0, 40, 0),
(75, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(76, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(77, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(78, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(79, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(80, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(81, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(82, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(83, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(84, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(85, 2, 'Pregunta número P2.1.2 YOMERO', 'J2 P2', 0, 40, 0),
(87, 2, 'Pregunta número P2.1.2 TUMERO', 'J2 P2', 0, 40, 0),
(89, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(90, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(91, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(92, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(93, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(94, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(95, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(96, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(97, 2, 'Pregunta número P2.1.2 NADIE', 'J2 P2', 0, 40, 0),
(99, 2, 'Pregunta número P2.1.2 JOJOJO', 'J2 P2', 0, 40, 0),
(100, 1, 'La segunda pregunta de prueba', 'La segunda justificación de prueba', 0, 45, 1),
(101, 1, 'La nueva pregunta de prueba', 'La nueva justificación de prueba', 0, 45, 1),
(103, 1, 'La nueva pregunta de prueba', 'La nueva justificación de prueba', 0, 45, 0),
(104, 1, 'pregunta querty', 'justificación qwerty', 0, 30, 0),
(105, 1, 'pregunta querty duplicada', 'justificación qwerty duplicada', 0, 30, 0),
(107, 2, 'Pregunta número P2.1.2 TODES', 'J2 P2', 0, 40, 0);

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
-- Estructura Stand-in para la vista `preguntasexternas`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `preguntasexternas`;
CREATE TABLE `preguntasexternas` (
`id_pregunta` int(11)
,`id_curso` int(11)
,`por_cambiar` tinyint(4)
);

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
(1, 2, 8, 2, 0, 0),
(1, 3, 7, 1, 3, 1),
(1, 4, 8, 1, 2, 1),
(2, 3, 0, 0, 0, 0);

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
(1, 'yolo', 'query', 'p@p.p', '516b9783fca517eecbd1d064da2d165310b19759'),
(2, 'q', 'q', 'q@q.q', '22ea1c649c82946aa6e479e1ffd321e4a318b1b0'),
(111111, 'profe1', 'profe1', 'isael191@gmail.com', '45ab2e8db459cb9869239064d01fcaf771d92be9'),
(123456780, 'profesor', 'doctor2', 'doctor2@profesor.unam.mx', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(123456781, 'profesor', 'doctor3', 'doctor3@profesor.unam.mx', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(123456782, 'profesor', 'doctor4', 'doctor4@profesor.unam.mx', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(123456789, 'doctor', 'profesor', 'doctor@profesor.unam.mx', '8cb2237d0679ca88db6464eac60da96345513964');

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
(30, 2, 22),
(31, 9, 99),
(32, 1, 1);

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
(30, 9, 2),
(31, 8, 1),
(32, 8, 1);

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
(34, 'https://www.youtube.com/watch?v=MjwtTSoIYYs', 0),
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
(93, 'buenisima', 100),
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
(172, '0', 0),
(181, 'P1', 100),
(182, '0', 0),
(183, '0', 0),
(184, '0', 0),
(185, 'P1', 100),
(186, '0', 0),
(187, '0', 0),
(188, '0', 0),
(189, 'P1', 100),
(190, '0', 0),
(191, '0', 0),
(192, '0', 0),
(193, 'P1', 100),
(194, '0', 0),
(195, '0', 0),
(196, '0', 0),
(197, 'buenisima', 100),
(198, 'mala', 0),
(199, 'mala', 0),
(200, 'mala', 0),
(201, 'buenisima', 100),
(202, 'mala', 0),
(203, 'mala', 0),
(204, 'mala', 0),
(209, 'buenisima', 100),
(210, 'mala', 0),
(211, 'mala', 0),
(212, 'mala', 0),
(217, 'buenisima', 100),
(218, 'mala', 0),
(219, 'mala', 0),
(220, 'mala', 0),
(221, 'buenisima', 100),
(222, 'mala', 0),
(223, 'mala', 0),
(224, 'mala', 0),
(225, 'buenisima', 100),
(226, 'mala', 0),
(227, 'mala', 0),
(228, 'mala', 0),
(229, 'buenisima', 100),
(230, 'mala', 0),
(231, 'mala', 0),
(232, 'mala', 0),
(233, 'buenisima', 100),
(234, 'mala', 0),
(235, 'mala', 0),
(236, 'mala', 0),
(241, 'P2', 100),
(242, '0', 0),
(243, '0', 0),
(244, '0', 0),
(245, 'P2', 100),
(246, '0', 0),
(247, '0', 0),
(248, '0', 0),
(253, 'P2', 100),
(254, '0', 0),
(255, '0', 0),
(256, '0', 0),
(261, 'P2', 100),
(262, '0', 0),
(263, '0', 0),
(264, '0', 0),
(265, 'P2', 100),
(266, '0', 0),
(267, '0', 0),
(268, '0', 0),
(269, 'P2', 100),
(270, '0', 0),
(271, '0', 0),
(272, '0', 0),
(273, 'P2', 100),
(274, '0', 0),
(275, '0', 0),
(276, '0', 0),
(277, 'P2', 100),
(278, '0', 0),
(279, '0', 0),
(280, '0', 0),
(281, 'P2', 100),
(282, '0', 0),
(283, '0', 0),
(284, '0', 0),
(285, 'P2', 100),
(286, '0', 0),
(287, '0', 0),
(288, '0', 0),
(289, 'P2', 100),
(290, '0', 0),
(291, '0', 0),
(292, '0', 0),
(293, 'P2', 100),
(294, '0', 0),
(295, '0', 0),
(296, '0', 0),
(297, 'P2', 100),
(298, '0', 0),
(299, '0', 0),
(300, '0', 0),
(301, 'P2', 100),
(302, '0', 0),
(303, '0', 0),
(304, '0', 0),
(309, 'P2', 100),
(310, '0', 0),
(311, '0', 0),
(312, '0', 0),
(317, 'P2', 100),
(318, '0', 0),
(319, '0', 0),
(320, '0', 0),
(321, 'P2', 100),
(322, '0', 0),
(323, '0', 0),
(324, '0', 0),
(325, 'P2', 100),
(326, '0', 0),
(327, '0', 0),
(328, '0', 0),
(329, 'P2', 100),
(330, '0', 0),
(331, '0', 0),
(332, '0', 0),
(333, 'P2', 100),
(334, '0', 0),
(335, '0', 0),
(336, '0', 0),
(337, 'P2', 100),
(338, '0', 0),
(339, '0', 0),
(340, '0', 0),
(341, 'P2', 100),
(342, '0', 0),
(343, '0', 0),
(344, '0', 0),
(345, 'P2', 100),
(346, '0', 0),
(347, '0', 0),
(348, '0', 0),
(349, 'P2', 100),
(350, '0', 0),
(351, '0', 0),
(352, '0', 0),
(357, 'P2', 100),
(358, '0', 0),
(359, '0', 0),
(360, '0', 0),
(361, 'resp 1', 0),
(362, 'resp 2', 0),
(363, 'resp 3', 0),
(364, 'resp 4', 100),
(365, 'resp 1', 0),
(366, 'resp 2', 0),
(367, 'resp 3', 0),
(368, 'resp 4', 100),
(373, 'resp 1', 0),
(374, 'resp 2', 0),
(375, 'resp 3', 0),
(376, 'resp 4', 100),
(377, 'r1', 100),
(378, 'r2', 0),
(379, 'r3', 0),
(380, 'r4', 0),
(381, 'r1', 100),
(382, 'r2', 0),
(383, 'r3', 0),
(384, 'r4', 0),
(389, 'P2', 100),
(390, '0', 0),
(391, '0', 0),
(392, '0', 0);

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
(8, 'El tema número 2'),
(9, 'Tema copiado'),
(10, 'El tema número 2'),
(11, 'El tema número 2'),
(12, 'El nuevo tema de prueba'),
(13, 'Tema copiado'),
(14, 'El tema número 2');

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
(4, 4, 1),
(5, 6, 9),
(5, 8, 2),
(6, 6, 6),
(6, 7, 3),
(6, 9, 1),
(7, 8, 19),
(8, 9, 10),
(9, 8, 3),
(10, 9, 10),
(11, 9, 1),
(13, 8, 1),
(14, 9, 1);

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

-- --------------------------------------------------------

--
-- Estructura para la vista `preguntasexternas`
--
DROP TABLE IF EXISTS `preguntasexternas`;

DROP VIEW IF EXISTS `preguntasexternas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `preguntasexternas`  AS  select `cursopreguntascompartidas`.`id_pregunta` AS `id_pregunta`,`cursopreguntascompartidas`.`id_curso` AS `id_curso`,`cursopreguntascompartidas`.`por_cambiar` AS `por_cambiar` from `cursopreguntascompartidas` where (`cursopreguntascompartidas`.`por_cambiar` <> 1) union (select `respaldode`.`id_pregunta_respaldo` AS `id_pregunta_respaldo`,`cursopreguntascompartidas`.`id_curso` AS `id_curso`,`cursopreguntascompartidas`.`por_cambiar` AS `por_cambiar` from (`cursopreguntascompartidas` join `respaldode` on((`respaldode`.`id_pregunta` = `cursopreguntascompartidas`.`id_pregunta`))) where (`cursopreguntascompartidas`.`por_cambiar` = 1)) ;

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
  MODIFY `n_cuenta` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_fuente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `Pregunta`
--
ALTER TABLE `Pregunta`
  MODIFY `id_pregunta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `Profesor`
--
ALTER TABLE `Profesor`
  MODIFY `n_trabajador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456790;

--
-- AUTO_INCREMENT de la tabla `Referencia`
--
ALTER TABLE `Referencia`
  MODIFY `id_referencia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  MODIFY `id_respuesta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- AUTO_INCREMENT de la tabla `Tema`
--
ALTER TABLE `Tema`
  MODIFY `id_tema` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
