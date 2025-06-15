-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-05-2025 a las 09:42:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `artista` varchar(100) NOT NULL,
  `stock` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `costo` decimal(8,2) NOT NULL,
  `precio` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `nombre`, `categoria`, `marca`, `artista`, `stock`, `descripcion`, `cantidad`, `costo`, `precio`) VALUES
(1, 'Ramen Jin spicy', 'comida', 'Jin ramen', '', '19', 'Ramen de pollo picante', 0, 0.00, 0.00),
(2, 'Ramen Bowl Udon', 'Comida', 'Udon', '', '23', 'Ramen picante de sur coreano\r\n', 0, 0.00, 0.00),
(3, 'Ice Tea', 'Bebidas', 'Miso', '', '24', 'Te helado citron', 0, 0.00, 0.00),
(4, 'Photofolio de Jin BTS', 'Merch', '', 'BTS', '23', 'Photofolio de Jin Sea', 0, 0.00, 0.00),
(5, 'Lickstick TXT', 'Merch', '    ', 'TXT', '12', 'Lickstick de txt', 0, 0.00, 0.00),
(6, 'Photofolio Twice', 'Merch', '     ', 'Twice', '13', 'Phptofolio del grupo twice', 0, 0.00, 0.00),
(7, 'Album Face', 'Alum', '   ', 'BTS', '8', 'Album-merch Jin', 0, 0.00, 0.00),
(8, 'Army Bomb BTS', 'Merch', '    ', 'BTS', '7', 'Lickstick del grupo BTS', 0, 0.00, 0.00),
(9, 'Album Day- Suga', 'Album', '    ', 'SUGA', '23', 'Album solo Suga-BTS', 0, 0.00, 0.00),
(10, 'Album the chaos ', 'Album', '     ', 'TXT', '53', 'Album txt merch oficial', 0, 0.00, 0.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
