-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-08-2017 a las 02:06:39
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Alumno`
--

CREATE TABLE `Alumno` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `nombres` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `apellidos` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_bin NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BasadoEn`
--

CREATE TABLE `BasadoEn` (
  `id_examen` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CometeErroresEn`
--

CREATE TABLE `CometeErroresEn` (
  `id_respuesta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  `n_cuenta` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contiene`
--

CREATE TABLE `Contiene` (
  `id_respuesta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cursa`
--

CREATE TABLE `Cursa` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL,
  `estado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Curso`
--

CREATE TABLE `Curso` (
  `id_curso` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoFuente`
--

CREATE TABLE `CursoFuente` (
  `id_curso` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CursoTema`
--

CREATE TABLE `CursoTema` (
  `id_tema` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DeTipo`
--

CREATE TABLE `DeTipo` (
  `id_pregunta` int(10) NOT NULL,
  `id_tipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Edicion`
--

CREATE TABLE `Edicion` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `anio` smallint(6) NOT NULL,
  `liga` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Evalua`
--

CREATE TABLE `Evalua` (
  `id_examen` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Examen`
--

CREATE TABLE `Examen` (
  `id_examen` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `tiempo` smallint(6) NOT NULL,
  `oportunidades` tinyint(4) NOT NULL,
  `vidas` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Fuente`
--

CREATE TABLE `Fuente` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `autores` text COLLATE utf8_bin NOT NULL,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FundamentadoEn`
--

CREATE TABLE `FundamentadoEn` (
  `id_referencia` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Genera`
--

CREATE TABLE `Genera` (
  `id_pregunta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Imparte`
--

CREATE TABLE `Imparte` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pregunta`
--

CREATE TABLE `Pregunta` (
  `id_pregunta` int(10) NOT NULL,
  `dificultad` tinyint(4) NOT NULL,
  `texto` text COLLATE utf8_bin NOT NULL,
  `justificacion` text COLLATE utf8_bin NOT NULL,
  `tiene_subpregunta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Presenta`
--

CREATE TABLE `Presenta` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_examen` int(10) NOT NULL,
  `calificacion` tinyint(3) UNSIGNED NOT NULL,
  `vidas` tinyint(4) UNSIGNED NOT NULL,
  `oportunidades` tinyint(4) UNSIGNED NOT NULL,
  `terminado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Profesor`
--

CREATE TABLE `Profesor` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `nombres` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `apellidos` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_bin NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Referencia`
--

CREATE TABLE `Referencia` (
  `id_referencia` int(10) NOT NULL,
  `capitulo` tinyint(4) NOT NULL,
  `pagina` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ReferenciaFuente`
--

CREATE TABLE `ReferenciaFuente` (
  `id_referencia` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Respuesta`
--

CREATE TABLE `Respuesta` (
  `id_respuesta` int(10) NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `porcentaje` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tema`
--

CREATE TABLE `Tema` (
  `id_tema` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tipo`
--

CREATE TABLE `Tipo` (
  `id_tipo` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VieneDe`
--

CREATE TABLE `VieneDe` (
  `id_subpregunta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_alumno` (`n_cuenta`),
  ADD KEY `id_respuesta` (`id_respuesta`);

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
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `CursoFuente`
--
ALTER TABLE `CursoFuente`
  ADD PRIMARY KEY (`id_curso`,`id_fuente`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_fuente` (`id_fuente`);

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
  ADD PRIMARY KEY (`id_referencia`),
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
  MODIFY `n_cuenta` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Curso`
--
ALTER TABLE `Curso`
  MODIFY `id_curso` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Examen`
--
ALTER TABLE `Examen`
  MODIFY `id_examen` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Fuente`
--
ALTER TABLE `Fuente`
  MODIFY `id_fuente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Pregunta`
--
ALTER TABLE `Pregunta`
  MODIFY `id_pregunta` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Profesor`
--
ALTER TABLE `Profesor`
  MODIFY `n_trabajador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Referencia`
--
ALTER TABLE `Referencia`
  MODIFY `id_referencia` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Respuesta`
--
ALTER TABLE `Respuesta`
  MODIFY `id_respuesta` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Tema`
--
ALTER TABLE `Tema`
  MODIFY `id_tema` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Tipo`
--
ALTER TABLE `Tipo`
  MODIFY `id_tipo` int(10) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `BasadoEn`
--
ALTER TABLE `BasadoEn`
  ADD CONSTRAINT `basadoen_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `Examen` (`id_examen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `basadoen_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `CometeErroresEn`
--
ALTER TABLE `CometeErroresEn`
  ADD CONSTRAINT `cometeerroresen_ibfk_1` FOREIGN KEY (`id_respuesta`) REFERENCES `Respuesta` (`id_respuesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cometeerroresen_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cometeerroresen_ibfk_3` FOREIGN KEY (`n_cuenta`) REFERENCES `Alumno` (`n_cuenta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Contiene`
--
ALTER TABLE `Contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`id_respuesta`) REFERENCES `Respuesta` (`id_respuesta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Cursa`
--
ALTER TABLE `Cursa`
  ADD CONSTRAINT `cursa_ibfk_1` FOREIGN KEY (`n_cuenta`) REFERENCES `Alumno` (`n_cuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursa_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `CursoFuente`
--
ALTER TABLE `CursoFuente`
  ADD CONSTRAINT `cursofuente_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursofuente_ibfk_2` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `CursoTema`
--
ALTER TABLE `CursoTema`
  ADD CONSTRAINT `cursotema_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursotema_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `DeTipo`
--
ALTER TABLE `DeTipo`
  ADD CONSTRAINT `detipo_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `Tipo` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detipo_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Edicion`
--
ALTER TABLE `Edicion`
  ADD CONSTRAINT `edicion_ibfk_1` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Evalua`
--
ALTER TABLE `Evalua`
  ADD CONSTRAINT `evalua_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `Examen` (`id_examen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evalua_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `FundamentadoEn`
--
ALTER TABLE `FundamentadoEn`
  ADD CONSTRAINT `fundamentadoen_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fundamentadoen_ibfk_2` FOREIGN KEY (`id_referencia`) REFERENCES `Referencia` (`id_referencia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Genera`
--
ALTER TABLE `Genera`
  ADD CONSTRAINT `genera_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genera_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Imparte`
--
ALTER TABLE `Imparte`
  ADD CONSTRAINT `imparte_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imparte_ibfk_2` FOREIGN KEY (`n_trabajador`) REFERENCES `Profesor` (`n_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `VieneDe`
--
ALTER TABLE `VieneDe`
  ADD CONSTRAINT `vienede_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vienede_ibfk_2` FOREIGN KEY (`id_subpregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
