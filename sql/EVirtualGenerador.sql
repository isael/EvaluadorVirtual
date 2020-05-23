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
-- Base de datos: `evaluado_EVirtual`
--
-- CREATE DATABASE IF NOT EXISTS `evaluado_EVirtual` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
-- USE `evaluado_EVirtual`;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contiene`
--

DROP TABLE IF EXISTS `Contiene`;
CREATE TABLE `Contiene` (
  `id_respuesta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Evalua`
--

DROP TABLE IF EXISTS `Evalua`;
CREATE TABLE `Evalua` (
  `id_examen` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FundamentadoEn`
--

DROP TABLE IF EXISTS `FundamentadoEn`;
CREATE TABLE `FundamentadoEn` (
  `id_referencia` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Genera`
--

DROP TABLE IF EXISTS `Genera`;
CREATE TABLE `Genera` (
  `id_pregunta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imparte`
--

DROP TABLE IF EXISTS `Imparte`;
CREATE TABLE `Imparte` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Estructura Stand-in para la vista `PreguntasExternas`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `PreguntasExternas`;
CREATE TABLE `PreguntasExternas` (
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
-- Estructura para la vista `PreguntasExternas`
--
DROP TABLE IF EXISTS `PreguntasExternas`;

DROP VIEW IF EXISTS `PreguntasExternas`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `PreguntasExternas`  AS  select `CursoPreguntasCompartidas`.`id_pregunta` AS `id_pregunta`,`CursoPreguntasCompartidas`.`id_curso` AS `id_curso`,`CursoPreguntasCompartidas`.`por_cambiar` AS `por_cambiar` from `CursoPreguntasCompartidas` where (`CursoPreguntasCompartidas`.`por_cambiar` <> 1) union (select `RespaldoDe`.`id_pregunta_respaldo` AS `id_pregunta_respaldo`,`CursoPreguntasCompartidas`.`id_curso` AS `id_curso`,`CursoPreguntasCompartidas`.`por_cambiar` AS `por_cambiar` from (`CursoPreguntasCompartidas` join `RespaldoDe` on((`RespaldoDe`.`id_pregunta` = `CursoPreguntasCompartidas`.`id_pregunta`))) where (`CursoPreguntasCompartidas`.`por_cambiar` = 1)) ;

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
