-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-02-2022 a las 21:12:07
-- Versión del servidor: 5.6.45-log
-- Versión de PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `c0990415_cursos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curcolegio`
--

CREATE TABLE `curcolegio` (
  `idcolegio` int(11) NOT NULL,
  `nombreColegio` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `CreaColegio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curcolegio`
--

INSERT INTO `curcolegio` (`idcolegio`, `nombreColegio`, `CreaColegio`) VALUES
(1, 'CEAES', '2022-01-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curcursos`
--

CREATE TABLE `curcursos` (
  `anioCurso` int(11) UNSIGNED NOT NULL,
  `idColegio` int(11) UNSIGNED NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idnivel` int(11) NOT NULL,
  `nombreCurso` varchar(64) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curcursos`
--

INSERT INTO `curcursos` (`anioCurso`, `idColegio`, `idCurso`, `idnivel`, `nombreCurso`) VALUES
(2022, 1, 1, 2, '1ERO_INFORMATICA'),
(2022, 1, 2, 1, '7MO_GRADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curmateria`
--

CREATE TABLE `curmateria` (
  `anioCurso` int(11) NOT NULL,
  `idColegio` int(11) NOT NULL,
  `idcurso` int(11) NOT NULL,
  `idmateria` int(11) NOT NULL,
  `nombreMateria` varchar(64) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curmateria`
--

INSERT INTO `curmateria` (`anioCurso`, `idColegio`, `idcurso`, `idmateria`, `nombreMateria`) VALUES
(2022, 1, 2, 1, 'MATEMATICA'),
(2022, 1, 2, 2, 'PDLENGUAJE'),
(2022, 1, 2, 3, 'SOCIALES'),
(2022, 1, 2, 4, 'NATURALES'),
(2022, 1, 1, 5, 'MATEMATICA'),
(2022, 1, 1, 6, 'PDLENGUAJE'),
(2022, 1, 1, 7, 'CSSOCIALES'),
(2022, 1, 1, 8, 'CSNATURALES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curnivel`
--

CREATE TABLE `curnivel` (
  `idNivel` int(11) NOT NULL,
  `DescripcionNivel` varchar(256) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curnivel`
--

INSERT INTO `curnivel` (`idNivel`, `DescripcionNivel`) VALUES
(1, 'PRIMARIO'),
(2, 'SECUNDARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curpermatcarpeta`
--

CREATE TABLE `curpermatcarpeta` (
  `anioCurso` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `hojaId` int(11) NOT NULL,
  `carpetaUbicacion` varchar(256) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curpersona`
--

CREATE TABLE `curpersona` (
  `idpersona` int(11) NOT NULL,
  `usuariopersona` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `nombrepersona` varchar(64) COLLATE latin1_spanish_ci NOT NULL,
  `tipopersona` varchar(64) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curpersona`
--

INSERT INTO `curpersona` (`idpersona`, `usuariopersona`, `nombrepersona`, `tipopersona`) VALUES
(1, 'Cipriano', 'Cipriano', 'ALUMNO'),
(2, 'Santina', 'Santina', 'ALUMNO'),
(3, 'Valeria', 'Valeria', 'ESPECIALISTA'),
(4, 'Candelaria', 'Candelaria', 'ESPECIALISTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curpersonacolegio`
--

CREATE TABLE `curpersonacolegio` (
  `idcolegio` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL,
  `FechaIngreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curpersonacolegio`
--

INSERT INTO `curpersonacolegio` (`idcolegio`, `idpersona`, `FechaIngreso`) VALUES
(1, 1, '2022-01-14'),
(1, 2, '2022-01-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curpersonamaterias`
--

CREATE TABLE `curpersonamaterias` (
  `anioCurso` int(11) NOT NULL,
  `idcolegio` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idMateria` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `curpersonamaterias`
--

INSERT INTO `curpersonamaterias` (`anioCurso`, `idcolegio`, `idCurso`, `idMateria`, `idpersona`) VALUES
(2022, 1, 1, 5, 1),
(2022, 1, 1, 6, 1),
(2022, 1, 1, 7, 1),
(2022, 1, 1, 8, 1),
(2022, 1, 2, 1, 2),
(2022, 1, 2, 2, 2),
(2022, 1, 2, 3, 2),
(2022, 1, 2, 4, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `curcolegio`
--
ALTER TABLE `curcolegio`
  ADD PRIMARY KEY (`idcolegio`);

--
-- Indices de la tabla `curcursos`
--
ALTER TABLE `curcursos`
  ADD PRIMARY KEY (`idCurso`,`anioCurso`,`idColegio`) USING BTREE;

--
-- Indices de la tabla `curmateria`
--
ALTER TABLE `curmateria`
  ADD PRIMARY KEY (`idmateria`,`idcurso`,`idColegio`,`anioCurso`) USING BTREE;

--
-- Indices de la tabla `curnivel`
--
ALTER TABLE `curnivel`
  ADD PRIMARY KEY (`idNivel`);

--
-- Indices de la tabla `curpermatcarpeta`
--
ALTER TABLE `curpermatcarpeta`
  ADD PRIMARY KEY (`anioCurso`,`idCurso`,`idMateria`,`idpersona`,`hojaId`);

--
-- Indices de la tabla `curpersona`
--
ALTER TABLE `curpersona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `curpersonacolegio`
--
ALTER TABLE `curpersonacolegio`
  ADD PRIMARY KEY (`idcolegio`,`idpersona`);

--
-- Indices de la tabla `curpersonamaterias`
--
ALTER TABLE `curpersonamaterias`
  ADD PRIMARY KEY (`anioCurso`,`idcolegio`,`idCurso`,`idMateria`,`idpersona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `curcolegio`
--
ALTER TABLE `curcolegio`
  MODIFY `idcolegio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `curcursos`
--
ALTER TABLE `curcursos`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `curmateria`
--
ALTER TABLE `curmateria`
  MODIFY `idmateria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `curnivel`
--
ALTER TABLE `curnivel`
  MODIFY `idNivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `curpersona`
--
ALTER TABLE `curpersona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
