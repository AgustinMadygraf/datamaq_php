-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-08-2025 a las 18:26:18
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
-- Base de datos: `novus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intervalproduction`
--

CREATE TABLE `intervalproduction` (
  `ID` int(11) NOT NULL,
  `unixtime` int(11) NOT NULL,
  `HR_COUNTER1` int(11) NOT NULL,
  `HR_COUNTER2` int(11) NOT NULL,
  `datetime` datetime GENERATED ALWAYS AS (from_unixtime(`unixtime`)) VIRTUAL,
  `production_rate` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `intervalproduction`
--

INSERT INTO `intervalproduction` (`ID`, `unixtime`, `HR_COUNTER1`, `HR_COUNTER2`, `production_rate`) VALUES
(1, 1705926300, 0, 0, NULL)
(51908, 1756491900, 0, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `intervalproduction`
--
ALTER TABLE `intervalproduction`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `intervalproduction`
--
ALTER TABLE `intervalproduction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51909;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
