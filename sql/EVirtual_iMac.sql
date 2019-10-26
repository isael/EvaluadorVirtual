-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 05, 2019 at 02:27 AM
-- Server version: 5.7.24
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `EVirtual`
--

-- --------------------------------------------------------

--
-- Table structure for table `Alumno`
--

CREATE TABLE `Alumno` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `nombres` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `apellidos` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_bin NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Alumno`
--

INSERT INTO `Alumno` (`n_cuenta`, `nombres`, `apellidos`, `correo`, `contrasenia`) VALUES
(12345, 'asdfghj', 'asdfghj', 'a@a.a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8');

-- --------------------------------------------------------

--
-- Table structure for table `BasadoEn`
--

CREATE TABLE `BasadoEn` (
  `id_examen` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `CometeErroresEn`
--

CREATE TABLE `CometeErroresEn` (
  `id_respuesta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL,
  `n_cuenta` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Contiene`
--

CREATE TABLE `Contiene` (
  `id_respuesta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Cursa`
--

CREATE TABLE `Cursa` (
  `n_cuenta` int(11) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL,
  `estado` varchar(1) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Cursa`
--

INSERT INTO `Cursa` (`n_cuenta`, `id_curso`, `estado`) VALUES
(12345, 2, 'a'),
(12345, 5, 'a'),
(12345, 9, 'r');

-- --------------------------------------------------------

--
-- Table structure for table `Curso`
--

CREATE TABLE `Curso` (
  `id_curso` int(10) NOT NULL,
  `clave` varchar(20) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Curso`
--

INSERT INTO `Curso` (`id_curso`, `clave`, `nombre`) VALUES
(2, '1234', 'mate'),
(5, '123', 'mate'),
(9, '12', '12');

-- --------------------------------------------------------

--
-- Table structure for table `CursoFuente`
--

CREATE TABLE `CursoFuente` (
  `id_curso` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `CursoFuente`
--

INSERT INTO `CursoFuente` (`id_curso`, `id_fuente`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `CursoTema`
--

CREATE TABLE `CursoTema` (
  `id_tema` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `DeTipo`
--

CREATE TABLE `DeTipo` (
  `id_pregunta` int(10) NOT NULL,
  `id_tipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `DeTipo`
--

INSERT INTO `DeTipo` (`id_pregunta`, `id_tipo`) VALUES
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Edicion`
--

CREATE TABLE `Edicion` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `anio` smallint(6) NOT NULL,
  `liga` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Edicion`
--

INSERT INTO `Edicion` (`id_fuente`, `numero`, `anio`, `liga`) VALUES
(1, 1, 1999, '');

-- --------------------------------------------------------

--
-- Table structure for table `Evalua`
--

CREATE TABLE `Evalua` (
  `id_examen` int(10) NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Examen`
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
-- Table structure for table `Fuente`
--

CREATE TABLE `Fuente` (
  `id_fuente` int(10) UNSIGNED NOT NULL,
  `autores` text COLLATE utf8_bin NOT NULL,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Fuente`
--

INSERT INTO `Fuente` (`id_fuente`, `autores`, `nombre`) VALUES
(1, 'autores', 'nombre');

-- --------------------------------------------------------

--
-- Table structure for table `FundamentadoEn`
--

CREATE TABLE `FundamentadoEn` (
  `id_referencia` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `FundamentadoEn`
--

INSERT INTO `FundamentadoEn` (`id_referencia`, `id_pregunta`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Genera`
--

CREATE TABLE `Genera` (
  `id_pregunta` int(10) NOT NULL,
  `id_tema` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Imparte`
--

CREATE TABLE `Imparte` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `id_curso` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Imparte`
--

INSERT INTO `Imparte` (`n_trabajador`, `id_curso`) VALUES
(123456, 2),
(123456, 5),
(123456, 9);

-- --------------------------------------------------------

--
-- Table structure for table `Pregunta`
--

CREATE TABLE `Pregunta` (
  `id_pregunta` int(10) NOT NULL,
  `dificultad` tinyint(4) NOT NULL,
  `texto` text COLLATE utf8_bin NOT NULL,
  `justificacion` text COLLATE utf8_bin NOT NULL,
  `tiene_subpregunta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Pregunta`
--

INSERT INTO `Pregunta` (`id_pregunta`, `dificultad`, `texto`, `justificacion`, `tiene_subpregunta`) VALUES
(1, 2, '¿Cómo te llamas?', 'Porque así me pusieron mis papás', 0),
(2, 2, '¿Cómo te llamas?', 'Porque así me pusieron mis papás', 0),
(3, 2, '¿Cómo te llamas?', 'Porque así me pusieron mis papás', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Presenta`
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
-- Table structure for table `Profesor`
--

CREATE TABLE `Profesor` (
  `n_trabajador` int(10) UNSIGNED NOT NULL,
  `nombres` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `apellidos` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_bin NOT NULL,
  `contrasenia` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Profesor`
--

INSERT INTO `Profesor` (`n_trabajador`, `nombres`, `apellidos`, `correo`, `contrasenia`) VALUES
(123456, 'warty', 'qwerty', 'q@q.q', '22ea1c649c82946aa6e479e1ffd321e4a318b1b0');

-- --------------------------------------------------------

--
-- Table structure for table `Referencia`
--

CREATE TABLE `Referencia` (
  `id_referencia` int(10) NOT NULL,
  `capitulo` tinyint(4) NOT NULL,
  `pagina` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Referencia`
--

INSERT INTO `Referencia` (`id_referencia`, `capitulo`, `pagina`) VALUES
(1, 2, 23);

-- --------------------------------------------------------

--
-- Table structure for table `ReferenciaFuente`
--

CREATE TABLE `ReferenciaFuente` (
  `id_referencia` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ReferenciaFuente`
--

INSERT INTO `ReferenciaFuente` (`id_referencia`, `id_fuente`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Respuesta`
--

CREATE TABLE `Respuesta` (
  `id_respuesta` int(10) NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `porcentaje` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `Tema`
--

CREATE TABLE `Tema` (
  `id_tema` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Tema`
--

INSERT INTO `Tema` (`id_tema`, `nombre`) VALUES
(1, 'Primer tema'),
(2, 'Primer tema');

-- --------------------------------------------------------

--
-- Table structure for table `TemaFuente`
--

CREATE TABLE `TemaFuente` (
  `id_tema` int(10) NOT NULL,
  `id_fuente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Tipo`
--

CREATE TABLE `Tipo` (
  `id_tipo` int(10) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Tipo`
--

INSERT INTO `Tipo` (`id_tipo`, `nombre`) VALUES
(1, 'Selección múltiple');

-- --------------------------------------------------------

--
-- Table structure for table `VieneDe`
--

CREATE TABLE `VieneDe` (
  `id_subpregunta` int(10) NOT NULL,
  `id_pregunta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Alumno`
--
ALTER TABLE `Alumno`
  ADD PRIMARY KEY (`n_cuenta`);

--
-- Indexes for table `BasadoEn`
--
ALTER TABLE `BasadoEn`
  ADD PRIMARY KEY (`id_examen`,`id_tema`),
  ADD KEY `id_examen` (`id_examen`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indexes for table `CometeErroresEn`
--
ALTER TABLE `CometeErroresEn`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_alumno` (`n_cuenta`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indexes for table `Contiene`
--
ALTER TABLE `Contiene`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_respuesta` (`id_respuesta`);

--
-- Indexes for table `Cursa`
--
ALTER TABLE `Cursa`
  ADD PRIMARY KEY (`n_cuenta`,`id_curso`),
  ADD KEY `n_cuenta` (`n_cuenta`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indexes for table `Curso`
--
ALTER TABLE `Curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indexes for table `CursoFuente`
--
ALTER TABLE `CursoFuente`
  ADD PRIMARY KEY (`id_curso`,`id_fuente`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_fuente` (`id_fuente`);

--
-- Indexes for table `CursoTema`
--
ALTER TABLE `CursoTema`
  ADD PRIMARY KEY (`id_tema`,`id_curso`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indexes for table `DeTipo`
--
ALTER TABLE `DeTipo`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indexes for table `Edicion`
--
ALTER TABLE `Edicion`
  ADD PRIMARY KEY (`id_fuente`,`numero`),
  ADD KEY `id_fuente` (`id_fuente`);

--
-- Indexes for table `Evalua`
--
ALTER TABLE `Evalua`
  ADD PRIMARY KEY (`id_examen`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indexes for table `Examen`
--
ALTER TABLE `Examen`
  ADD PRIMARY KEY (`id_examen`);

--
-- Indexes for table `Fuente`
--
ALTER TABLE `Fuente`
  ADD PRIMARY KEY (`id_fuente`);

--
-- Indexes for table `FundamentadoEn`
--
ALTER TABLE `FundamentadoEn`
  ADD PRIMARY KEY (`id_referencia`,`id_pregunta`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_referencia` (`id_referencia`);

--
-- Indexes for table `Genera`
--
ALTER TABLE `Genera`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- Indexes for table `Imparte`
--
ALTER TABLE `Imparte`
  ADD PRIMARY KEY (`n_trabajador`,`id_curso`),
  ADD KEY `n_trabajador` (`n_trabajador`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indexes for table `Pregunta`
--
ALTER TABLE `Pregunta`
  ADD PRIMARY KEY (`id_pregunta`);

--
-- Indexes for table `Presenta`
--
ALTER TABLE `Presenta`
  ADD PRIMARY KEY (`n_cuenta`,`id_examen`),
  ADD KEY `n_cuenta` (`n_cuenta`),
  ADD KEY `id_examen` (`id_examen`);

--
-- Indexes for table `Profesor`
--
ALTER TABLE `Profesor`
  ADD PRIMARY KEY (`n_trabajador`);

--
-- Indexes for table `Referencia`
--
ALTER TABLE `Referencia`
  ADD PRIMARY KEY (`id_referencia`);

--
-- Indexes for table `ReferenciaFuente`
--
ALTER TABLE `ReferenciaFuente`
  ADD PRIMARY KEY (`id_referencia`,`id_fuente`),
  ADD KEY `id_fuente` (`id_fuente`),
  ADD KEY `id_referencia` (`id_referencia`);

--
-- Indexes for table `Respuesta`
--
ALTER TABLE `Respuesta`
  ADD PRIMARY KEY (`id_respuesta`);

--
-- Indexes for table `Tema`
--
ALTER TABLE `Tema`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indexes for table `TemaFuente`
--
ALTER TABLE `TemaFuente`
  ADD PRIMARY KEY (`id_tema`,`id_fuente`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_fuente` (`id_fuente`);

--
-- Indexes for table `Tipo`
--
ALTER TABLE `Tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indexes for table `VieneDe`
--
ALTER TABLE `VieneDe`
  ADD PRIMARY KEY (`id_subpregunta`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_subpregunta` (`id_subpregunta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Alumno`
--
ALTER TABLE `Alumno`
  MODIFY `n_cuenta` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12346;
--
-- AUTO_INCREMENT for table `Curso`
--
ALTER TABLE `Curso`
  MODIFY `id_curso` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `Examen`
--
ALTER TABLE `Examen`
  MODIFY `id_examen` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Fuente`
--
ALTER TABLE `Fuente`
  MODIFY `id_fuente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Pregunta`
--
ALTER TABLE `Pregunta`
  MODIFY `id_pregunta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Profesor`
--
ALTER TABLE `Profesor`
  MODIFY `n_trabajador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;
--
-- AUTO_INCREMENT for table `Referencia`
--
ALTER TABLE `Referencia`
  MODIFY `id_referencia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Respuesta`
--
ALTER TABLE `Respuesta`
  MODIFY `id_respuesta` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Tema`
--
ALTER TABLE `Tema`
  MODIFY `id_tema` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Tipo`
--
ALTER TABLE `Tipo`
  MODIFY `id_tipo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `BasadoEn`
--
ALTER TABLE `BasadoEn`
  ADD CONSTRAINT `basadoen_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `Examen` (`id_examen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `basadoen_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CometeErroresEn`
--
ALTER TABLE `CometeErroresEn`
  ADD CONSTRAINT `cometeerroresen_ibfk_1` FOREIGN KEY (`id_respuesta`) REFERENCES `Respuesta` (`id_respuesta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cometeerroresen_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cometeerroresen_ibfk_3` FOREIGN KEY (`n_cuenta`) REFERENCES `Alumno` (`n_cuenta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Contiene`
--
ALTER TABLE `Contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contiene_ibfk_2` FOREIGN KEY (`id_respuesta`) REFERENCES `Respuesta` (`id_respuesta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Cursa`
--
ALTER TABLE `Cursa`
  ADD CONSTRAINT `cursa_ibfk_1` FOREIGN KEY (`n_cuenta`) REFERENCES `Alumno` (`n_cuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursa_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CursoFuente`
--
ALTER TABLE `CursoFuente`
  ADD CONSTRAINT `cursofuente_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursofuente_ibfk_2` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CursoTema`
--
ALTER TABLE `CursoTema`
  ADD CONSTRAINT `cursotema_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cursotema_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `DeTipo`
--
ALTER TABLE `DeTipo`
  ADD CONSTRAINT `detipo_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `Tipo` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detipo_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Edicion`
--
ALTER TABLE `Edicion`
  ADD CONSTRAINT `edicion_ibfk_1` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Evalua`
--
ALTER TABLE `Evalua`
  ADD CONSTRAINT `evalua_ibfk_1` FOREIGN KEY (`id_examen`) REFERENCES `Examen` (`id_examen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evalua_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `FundamentadoEn`
--
ALTER TABLE `FundamentadoEn`
  ADD CONSTRAINT `fundamentadoen_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fundamentadoen_ibfk_2` FOREIGN KEY (`id_referencia`) REFERENCES `Referencia` (`id_referencia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Genera`
--
ALTER TABLE `Genera`
  ADD CONSTRAINT `genera_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genera_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Imparte`
--
ALTER TABLE `Imparte`
  ADD CONSTRAINT `imparte_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `Curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imparte_ibfk_2` FOREIGN KEY (`n_trabajador`) REFERENCES `Profesor` (`n_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Presenta`
--
ALTER TABLE `Presenta`
  ADD CONSTRAINT `presenta_ibfk_1` FOREIGN KEY (`n_cuenta`) REFERENCES `Alumno` (`n_cuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presenta_ibfk_2` FOREIGN KEY (`id_examen`) REFERENCES `Examen` (`id_examen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ReferenciaFuente`
--
ALTER TABLE `ReferenciaFuente`
  ADD CONSTRAINT `referenciafuente_ibfk_1` FOREIGN KEY (`id_referencia`) REFERENCES `Referencia` (`id_referencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `referenciafuente_ibfk_2` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TemaFuente`
--
ALTER TABLE `TemaFuente`
  ADD CONSTRAINT `temafuente_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `Tema` (`id_tema`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `temafuente_ibfk_2` FOREIGN KEY (`id_fuente`) REFERENCES `Fuente` (`id_fuente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `VieneDe`
--
ALTER TABLE `VieneDe`
  ADD CONSTRAINT `vienede_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vienede_ibfk_2` FOREIGN KEY (`id_subpregunta`) REFERENCES `Pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
