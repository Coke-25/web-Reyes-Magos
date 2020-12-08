-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2020 a las 14:41:16
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reyesmagos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juguetes`
--

CREATE TABLE `juguetes` (
  `idJuguete` int(11) NOT NULL,
  `nombreJuguete` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precioJuguete` decimal(6,2) NOT NULL,
  `idReyFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `juguetes`
--

INSERT INTO `juguetes` (`idJuguete`, `nombreJuguete`, `precioJuguete`, `idReyFK`) VALUES
(1, 'Aula de ciencia: Robot Mini ERP', '159.95', 1),
(2, 'Carbón', '0.00', 2),
(3, 'Cochecito Classic', '99.95', 3),
(4, 'Consola PS4 1 TB', '349.90', 3),
(5, 'Lego Villa familiar modular', '64.99', 1),
(6, 'Magia Borrás Clásica 150 trucos con luz', '32.95', 1),
(7, 'Meccano Excavadora construcción', '30.99', 2),
(8, 'Nenuco Hace pompas', '29.95', 3),
(9, 'Peluche delfín rosa', '34.00', 2),
(10, 'Pequeordenador', '22.95', 2),
(11, 'Robot Coji', '69.95', 3),
(12, 'Telescopio astronómico terrestre', '72.00', 1),
(13, 'Twister', '17.95', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ninios`
--

CREATE TABLE `ninios` (
  `idNinio` int(11) NOT NULL,
  `nombreNinio` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidosNinio` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaNacimientoNinio` date NOT NULL,
  `comportamientoNinio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ninios`
--

INSERT INTO `ninios` (`idNinio`, `nombreNinio`, `apellidosNinio`, `fechaNacimientoNinio`, `comportamientoNinio`) VALUES
(1, 'Alberto', 'Alcántara', '1994-10-13', 0),
(2, 'Beatriz', 'Bueno', '1982-04-18', 1),
(3, 'Carlos', 'Crepo', '1998-12-01', 1),
(4, 'Diana', 'Domínguez', '1987-09-02', 0),
(5, 'Emilio', 'Enamorado', '1996-08-12', 1),
(6, 'Francisca', 'Fernández', '1990-07-28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piden`
--

CREATE TABLE `piden` (
  `idNinioFK` int(11) NOT NULL,
  `idJugueteFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `piden`
--

INSERT INTO `piden` (`idNinioFK`, `idJugueteFK`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 11),
(2, 13),
(3, 7),
(4, 1),
(4, 13),
(5, 6),
(5, 10),
(6, 4),
(6, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reyes`
--

CREATE TABLE `reyes` (
  `idRey` int(11) NOT NULL,
  `nombreRey` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reyes`
--

INSERT INTO `reyes` (`idRey`, `nombreRey`) VALUES
(1, 'Melchor'),
(2, 'Gaspar'),
(3, 'Baltasar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `juguetes`
--
ALTER TABLE `juguetes`
  ADD PRIMARY KEY (`idJuguete`),
  ADD KEY `idReyFK` (`idReyFK`);

--
-- Indices de la tabla `ninios`
--
ALTER TABLE `ninios`
  ADD PRIMARY KEY (`idNinio`);

--
-- Indices de la tabla `piden`
--
ALTER TABLE `piden`
  ADD PRIMARY KEY (`idNinioFK`,`idJugueteFK`),
  ADD KEY `idNinioFK` (`idNinioFK`,`idJugueteFK`),
  ADD KEY `idJugueteFK` (`idJugueteFK`);

--
-- Indices de la tabla `reyes`
--
ALTER TABLE `reyes`
  ADD PRIMARY KEY (`idRey`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `juguetes`
--
ALTER TABLE `juguetes`
  MODIFY `idJuguete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ninios`
--
ALTER TABLE `ninios`
  MODIFY `idNinio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reyes`
--
ALTER TABLE `reyes`
  MODIFY `idRey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `juguetes`
--
ALTER TABLE `juguetes`
  ADD CONSTRAINT `juguetes_ibfk_1` FOREIGN KEY (`idReyFK`) REFERENCES `reyes` (`idRey`);

--
-- Filtros para la tabla `piden`
--
ALTER TABLE `piden`
  ADD CONSTRAINT `piden_ibfk_1` FOREIGN KEY (`idJugueteFK`) REFERENCES `juguetes` (`idJuguete`),
  ADD CONSTRAINT `piden_ibfk_2` FOREIGN KEY (`idNinioFK`) REFERENCES `ninios` (`idNinio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
