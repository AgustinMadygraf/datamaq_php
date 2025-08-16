-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-03-2024 a las 16:44:37
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registro_stock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listado_precios`
--

CREATE TABLE `listado_precios` (
  `ID_listado` int(11) NOT NULL,
  `ID_formato` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_u_sIVA` decimal(8,2) DEFAULT NULL,
  `fecha_listado` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `listado_precios`
--

INSERT INTO `listado_precios` (`ID_listado`, `ID_formato`, `cantidad`, `precio_u_sIVA`, `fecha_listado`) VALUES
(1, 1, 5000, '63.66', '2023-12-01'),
(2, 2, 5000, '79.97', '2023-12-01'),
(3, 3, 5000, '88.38', '2023-12-01'),
(4, 4, 5000, '105.23', '2023-12-01'),
(5, 5, 5000, '107.95', '2023-12-01'),
(6, 6, 5000, '124.37', '2023-12-01'),
(7, 7, 5000, '121.40', '2023-12-01'),
(8, 8, 5000, '124.37', '2023-12-01'),
(9, 10, 5000, '105.89', '2023-12-01'),
(10, 11, 5000, '155.22', '2023-12-01'),
(11, 12, 5000, '195.35', '2023-12-01'),
(12, 13, 5000, '102.66', '2023-12-01'),
(13, 14, 5000, '202.66', '2023-12-01'),
(14, 1, 5000, '73.21', '2024-02-01'),
(15, 1, 10000, '71.01', '2024-02-01'),
(16, 2, 5000, '91.96', '2024-02-01'),
(17, 2, 10000, '90.48', '2024-02-01'),
(18, 3, 5000, '101.64', '2024-02-01'),
(19, 3, 10000, '101.64', '2024-02-01'),
(20, 4, 5000, '121.02', '2024-02-01'),
(21, 4, 10000, '117.14', '2024-02-01'),
(22, 5, 5000, '124.14', '2024-02-01'),
(23, 5, 10000, '120.29', '2024-02-01'),
(24, 6, 5000, '143.03', '2024-02-01'),
(25, 6, 10000, '139.81', '2024-02-01'),
(26, 7, 5000, '139.61', '2024-02-01'),
(27, 7, 10000, '132.50', '2024-02-01'),
(29, 8, 5000, '143.03', '2024-02-01'),
(30, 8, 10000, '138.56', '2024-02-01'),
(31, 10, 5000, '105.89', '2024-02-01'),
(32, 10, 10000, '105.89', '2024-02-01'),
(33, 11, 5000, '164.51', '2024-02-01'),
(34, 11, 10000, '159.32', '2024-02-01'),
(35, 12, 5000, '187.52', '2024-02-01'),
(36, 12, 10000, '181.61', '2024-02-01'),
(37, 13, 5000, '102.66', '2024-02-01'),
(38, 13, 10000, '102.66', '2024-02-01'),
(39, 14, 5000, '237.12', '2024-02-01'),
(40, 14, 10000, '229.72', '2024-02-01'),
(41, 15, 5000, '0.00', '2024-02-01'),
(42, 15, 10000, '0.00', '2024-02-01'),
(43, 16, 5000, '0.00', '2024-02-01'),
(44, 16, 10000, '0.00', '2024-02-01'),
(45, 17, 5000, '0.00', '2024-02-01'),
(46, 17, 10000, '0.00', '2024-02-01'),
(47, 90, 5000, '0.00', '2024-02-01'),
(48, 90, 10000, '0.00', '2024-02-01'),
(49, 91, 5000, '0.00', '2024-02-01'),
(50, 91, 10000, '0.00', '2024-02-01'),
(51, 92, 5000, '0.00', '2024-02-01'),
(52, 92, 10000, '0.00', '2024-02-01'),
(53, 93, 5000, '0.00', '2024-02-01'),
(54, 93, 10000, '0.00', '2024-02-01'),
(55, 94, 5000, '0.00', '2024-02-01'),
(56, 94, 10000, '0.00', '2024-02-01'),
(57, 95, 5000, '0.00', '2024-02-01'),
(58, 95, 10000, '0.00', '2024-02-01'),
(59, 96, 5000, '0.00', '2024-02-01'),
(60, 96, 10000, '0.00', '2024-02-01'),
(61, 97, 5000, '0.00', '2024-02-01'),
(62, 97, 10000, '0.00', '2024-02-01'),
(63, 98, 5000, '0.00', '2024-02-01'),
(64, 98, 10000, '0.00', '2024-02-01'),
(65, 99, 5000, '0.00', '2024-02-01'),
(66, 99, 10000, '0.00', '2024-02-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_bolsas_aux`
--

CREATE TABLE `produccion_bolsas_aux` (
  `ID` int(11) NOT NULL,
  `ancho_bobina` decimal(5,2) NOT NULL,
  `ID_formato` int(11) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `produccion_bolsas_aux`
--

INSERT INTO `produccion_bolsas_aux` (`ID`, `ancho_bobina`, `ID_formato`, `Fecha`) VALUES
(1, '790.00', 5, '2024-02-06 10:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_1`
--

CREATE TABLE `tabla_1` (
  `ID_formato` int(11) NOT NULL,
  `formato` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ancho` int(11) NOT NULL,
  `fuelle` int(11) NOT NULL,
  `alto` int(11) NOT NULL,
  `color` varchar(11) NOT NULL,
  `gramaje` int(11) NOT NULL,
  `cantidades` int(11) NOT NULL,
  `manijas` bit(1) NOT NULL,
  `fechatiempo` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tabla_1`
--

INSERT INTO `tabla_1` (`ID_formato`, `formato`, `ancho`, `fuelle`, `alto`, `color`, `gramaje`, `cantidades`, `manijas`) VALUES
(1, '12 X 08 X 19', 125, 80, 190, 'MARRON', 100, 56084, b'0'),
(2, '12 X 08 X 40', 125, 80, 400, 'MARRON', 100, 61464, b'0'),
(3, '22 X 10 X 30', 220, 100, 300, 'MARRON', 100, 50827, b'0'),
(4, '22 X 10 X 42', 220, 100, 420, 'MARRON', 100, 3663, b'0'),
(5, '26 X 12 X 36', 260, 120, 360, 'MARRON', 100, 14277, b'0'),
(6, '28 x 16 x 38', 280, 160, 380, 'MARRON', 100, 0, b'0'),
(7, '30 x 12 x 32', 300, 120, 320, 'MARRON', 100, 6765, b'0'),
(8, '30 X 12 X 41', 300, 120, 410, 'MARRON', 100, 18260, b'0'),
(9, '28 x 16 x 38', 280, 160, 380, 'MARRON', 80, 23348, b'0'),
(10, '12 X 08 X 19', 125, 80, 190, 'BLANCO', 100, 31225, b'0'),
(11, '12 X 08 X 40', 125, 80, 400, 'BLANCO', 100, 0, b'0'),
(12, '22 X 10 X 30', 220, 100, 300, 'BLANCO', 100, 5239, b'0'),
(13, '22 X 10 X 42', 220, 100, 420, 'BLANCO', 100, 0, b'0'),
(14, '26 X 12 X 36', 260, 120, 360, 'BLANCO', 100, 22996, b'0'),
(15, '28 x 16 x 38', 280, 160, 380, 'BLANCO', 80, 29, b'0'),
(16, '30 x 12 x 32', 300, 120, 320, 'BLANCO', 80, 12, b'0'),
(17, '30 X 12 X 41', 300, 120, 410, 'BLANCO', 80, 1907, b'0'),
(90, '28 x 12 x 41', 280, 120, 410, 'MARRON', 80, 23968, b'0'),
(91, '28 x 16 x 38', 280, 160, 380, 'MARRON', 80, 10499, b'0'),
(92, '30 X 12 X 41', 300, 120, 410, 'MARRON', 80, 1651, b'0'),
(93, '30 X 16 X 43', 300, 160, 430, 'MARRON', 100, 580, b'0'),
(94, '26 X 12 X 41', 260, 120, 410, 'MARRON', 100, 200, b'0'),
(95, '22 X 12 X 41', 220, 120, 410, 'MARRON', 100, 3062, b'0'),
(96, '22 X 12 X 30', 220, 120, 300, 'MARRON', 100, 1965, b'0'),
(97, '22 X 10 X 24', 220, 100, 240, 'MARRON', 100, 884, b'0'),
(98, '22 X 10 X 20', 220, 100, 200, 'MARRON', 100, 741, b'0'),
(99, '12 X 08 X 26', 125, 80, 260, 'MARRON', 100, 1295, b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_2`
--

CREATE TABLE `tabla_2` (
  `ID_registro` int(11) NOT NULL,
  `ID_formato` int(11) NOT NULL,
  `papel` varchar(11) NOT NULL,
  `fecha` date NOT NULL,
  `pedido` int(11) NOT NULL,
  `detalle` varchar(50) NOT NULL,
  `origen` int(11) NOT NULL,
  `ingreso` int(11) NOT NULL,
  `egreso` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `destino_sobrante` int(11) NOT NULL,
  `sobrante` int(11) NOT NULL,
  `facturado` int(11) NOT NULL,
  `entregado` int(11) NOT NULL,
  `remito` int(11) NOT NULL,
  `sobreconsumo` int(11) NOT NULL,
  `lote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tabla_2`
--

INSERT INTO `tabla_2` (`ID_registro`, `ID_formato`, `papel`, `fecha`, `pedido`, `detalle`, `origen`, `ingreso`, `egreso`, `saldo`, `destino_sobrante`, `sobrante`, `facturado`, `entregado`, `remito`, `sobreconsumo`, `lote`) VALUES
(1, 6, 'Kraft', '2023-04-13', 11, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 6, 'Kraft', '0000-00-00', 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 10, 'Kraft', '2024-01-23', 0, '0', 0, 5000, 0, 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `listado_precios`
--
ALTER TABLE `listado_precios`
  ADD PRIMARY KEY (`ID_listado`),
  ADD KEY `ID_formato` (`ID_formato`);

--
-- Indices de la tabla `produccion_bolsas_aux`
--
ALTER TABLE `produccion_bolsas_aux`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_ID_formato` (`ID_formato`);

--
-- Indices de la tabla `tabla_1`
--
ALTER TABLE `tabla_1`
  ADD PRIMARY KEY (`ID_formato`);

--
-- Indices de la tabla `tabla_2`
--
ALTER TABLE `tabla_2`
  ADD PRIMARY KEY (`ID_registro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `produccion_bolsas_aux`
--
ALTER TABLE `produccion_bolsas_aux`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tabla_2`
--
ALTER TABLE `tabla_2`
  MODIFY `ID_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `produccion_bolsas_aux`
--
ALTER TABLE `produccion_bolsas_aux`
  ADD CONSTRAINT `fk_produccion_bolsas_aux_formato` FOREIGN KEY (`ID_formato`) REFERENCES `tabla_1` (`ID_formato`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
