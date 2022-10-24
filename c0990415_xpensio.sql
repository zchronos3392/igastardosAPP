-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-04-2022 a las 00:47:23
-- Versión del servidor: 5.7.33
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `c0990415_xpensio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasmovdiarios`
--

CREATE TABLE `gasmovdiarios` (
  `gasid` int(11) NOT NULL,
  `tipoMedioPago` int(11) NOT NULL,
  `gasFecha` date NOT NULL,
  `gasDescripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `gasPUnit` decimal(10,2) NOT NULL,
  `gasCant` decimal(10,2) NOT NULL,
  `ComercioId` int(11) NOT NULL,
  `monedaId` int(11) NOT NULL,
  `descuento` decimal(10,2) NOT NULL,
  `gasobservaciones1` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `gasobservaciones2` varchar(512) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gasmovdiarios`
--

INSERT INTO `gasmovdiarios` (`gasid`, `tipoMedioPago`, `gasFecha`, `gasDescripcion`, `gasPUnit`, `gasCant`, `ComercioId`, `monedaId`, `descuento`, `gasobservaciones1`, `gasobservaciones2`) VALUES
(1, 1, '2022-04-18', 'BOBINA DE ARRANQUE 25X35', '440.00', '2.00', 6, 1, '0.00', '', ''),
(2, 1, '2022-04-18', 'BOBINA DE ARRANQUE 15X20', '230.00', '1.00', 6, 1, '0.00', '', ''),
(3, 1, '2022-04-18', 'LIMPIADOR DE TAPIZADOS', '620.00', '1.00', 6, 1, '0.00', '', ''),
(4, 1, '2022-04-18', 'KI MA QUITA BIROME', '380.00', '1.00', 6, 1, '0.00', '', ''),
(5, 1, '2022-04-18', 'KI-MA QUITA GRASA', '380.00', '1.00', 6, 1, '0.00', '', ''),
(6, 1, '2022-04-18', 'KI MA QUITA TINTA', '380.00', '1.00', 6, 1, '0.00', '', ''),
(7, 1, '2022-04-18', 'ADHESIVOS PARA INODORO', '110.00', '1.00', 6, 1, '0.00', '', ''),
(8, 1, '2022-04-18', 'ROYALCANIN - Adulto Raza Pequeña', '830.00', '2.00', 3, 1, '0.00', '', ''),
(9, 1, '2022-04-18', 'PAN', '307.00', '1.00', 2, 1, '0.30', '', ''),
(10, 1, '2022-04-18', 'BANANA GRANEL', '189.00', '1.76', 4, 3, '0.00', '', ''),
(11, 1, '2022-04-18', 'MANDARINA GRANEL', '99.00', '1.09', 4, 3, '0.00', '', ''),
(12, 1, '2022-04-18', 'LECHUGA MANTECOSA', '419.00', '0.55', 4, 3, '0.00', '', ''),
(13, 1, '2022-04-18', 'LIMON GRANEL', '149.00', '0.81', 4, 3, '0.00', '', ''),
(14, 1, '2022-04-18', 'PALTA', '99.00', '2.00', 4, 3, '0.00', '', ''),
(15, 1, '2022-04-19', 'Pata y Muslo', '330.00', '3.00', 7, 3, '0.00', '', ''),
(16, 1, '2022-04-19', 'Milanesas de Pollo (?)', '500.00', '2.00', 7, 3, '0.00', '', ''),
(17, 1, '2022-04-19', 'Filet panado', '850.00', '1.00', 7, 3, '0.00', '', ''),
(18, 1, '2022-04-19', 'Harina 000 Caserita', '70.95', '6.00', 1, 3, '0.00', '', ''),
(19, 1, '2022-04-19', 'Sal fina Carrefour', '56.00', '6.00', 1, 3, '0.00', '', ''),
(20, 1, '2022-04-19', 'Crema Carrefour', '105.00', '1.00', 1, 3, '0.00', '', ''),
(21, 1, '2022-04-19', 'Arroz largo fino', '98.00', '2.00', 1, 3, '0.00', '', ''),
(24, 1, '2022-04-20', 'Dulce de Leche CLASICO', '163.16', '3.00', 1, 3, '0.00', '', ''),
(25, 1, '2022-04-20', 'Queso Crema', '209.00', '3.00', 1, 3, '0.00', '', ''),
(26, 1, '2022-04-20', 'Galletitas dulces AMOR', '76.15', '1.00', 1, 3, '0.00', '', ''),
(27, 3, '2022-04-20', 'Pan Mignon', '300.00', '1.50', 1, 3, '0.00', '', ''),
(28, 1, '2022-04-20', 'Fideos Codito', '98.10', '2.00', 4, 3, '0.00', ' ', ' '),
(29, 1, '2022-04-20', 'Crema de Leche', '157.99', '1.00', 4, 3, '0.00', ' ', ' '),
(30, 1, '2022-04-20', 'DDL Repostero', '195.00', '2.00', 4, 3, '0.00', ' ', ' '),
(31, 1, '2022-04-20', 'Bizcocho Salado Dsatur', '70.08', '2.00', 4, 3, '0.00', ' ', ' '),
(32, 1, '2022-04-20', 'Galletira Chip Chocolate', '119.00', '2.00', 4, 3, '0.00', ' ', ' '),
(33, 1, '2022-04-20', 'Envase Esteril', '95.00', '2.00', 9, 3, '0.00', ' ', ' '),
(34, 1, '2022-04-21', 'Acemuk', '1188.36', '1.00', 9, 3, '0.00', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasmediospago`
--

CREATE TABLE `gasmediospago` (
  `mediopagoid` int(11) NOT NULL,
  `descripcionmediopago` varchar(256) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gasmediospago`
--

INSERT INTO `gasmediospago` (`mediopagoid`, `descripcionmediopago`) VALUES
(1, 'TARJETA HSBC'),
(2, 'DEBITO FRANCES'),
(3, 'EFECTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasmonedas`
--

CREATE TABLE `gasmonedas` (
  `monedaId` int(11) NOT NULL,
  `descripcionmoneda` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `abrmoneda` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gasmonedas`
--

INSERT INTO `gasmonedas` (`monedaId`, `descripcionmoneda`, `abrmoneda`) VALUES
(3, 'PESOS', '$'),
(4, 'DOLARES', 'U$S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasnegocios`
--

CREATE TABLE `gasnegocios` (
  `ComercioId` int(11) NOT NULL,
  `descripcionComercio` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gasnegocios`
--

INSERT INTO `gasnegocios` (`ComercioId`, `descripcionComercio`, `tipo`) VALUES
(1, 'CARREFOUR', 'SUPERMERCADO'),
(2, 'EL PUENTE', 'USINA LACTEA'),
(3, 'PATITAS FELICES', 'ALIMENTOS PERROS'),
(4, 'DIA%', 'SUPERMERCADO'),
(5, 'YPF-PRINGLES', 'ESTACION DE SERVICIO'),
(6, 'NEW CASMOND', 'ARTICULOS DE LIMPIEZA'),
(7, 'CARNICERIA SCALABRINI', 'CARNICERIA'),
(8, 'PANADERIA CORDOBA', 'PANADERIA'),
(9, 'FARMACITY CBA', 'FARMACIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasumedidas`
--

CREATE TABLE `gasumedidas` (
  `unidadmedidaid` int(11) NOT NULL,
  `descripcionumedida` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gasumedidas`
--

INSERT INTO `gasumedidas` (`unidadmedidaid`, `descripcionumedida`) VALUES
(1, 'Kilogramos');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gasmovdiarios`
--
ALTER TABLE `gasmovdiarios`
  ADD PRIMARY KEY (`gasid`);

--
-- Indices de la tabla `gasmediospago`
--
ALTER TABLE `gasmediospago`
  ADD PRIMARY KEY (`mediopagoid`);

--
-- Indices de la tabla `gasmonedas`
--
ALTER TABLE `gasmonedas`
  ADD PRIMARY KEY (`monedaId`);

--
-- Indices de la tabla `gasnegocios`
--
ALTER TABLE `gasnegocios`
  ADD PRIMARY KEY (`ComercioId`);

--
-- Indices de la tabla `gasumedidas`
--
ALTER TABLE `gasumedidas`
  ADD PRIMARY KEY (`unidadmedidaid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gasmovdiarios`
--
ALTER TABLE `gasmovdiarios`
  MODIFY `gasid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `gasmediospago`
--
ALTER TABLE `gasmediospago`
  MODIFY `mediopagoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gasmonedas`
--
ALTER TABLE `gasmonedas`
  MODIFY `monedaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gasnegocios`
--
ALTER TABLE `gasnegocios`
  MODIFY `ComercioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `gasumedidas`
--
ALTER TABLE `gasumedidas`
  MODIFY `unidadmedidaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
