-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2025 a las 15:18:18
-- Versión del servidor: 10.1.37-MariaDB
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
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(4) NOT NULL,
  `cedula` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` enum('Cliente','Usuario','','') COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Teléfono` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `apellidos`, `nombres`, `tipo`, `email`, `Teléfono`, `direccion`, `estado`) VALUES
(1, '1004421515', 'PEÑAFIEL ENRIQUEZ', 'JORDY DANIEL', 'Cliente', 'jordy28daniel@gmail.com', '0999064019', 'Bellavista de San Antonio de Ibarra', 'Activo'),
(2, '1004869184', 'CACUANGO PUMA', 'CINTHYA MISHELL', 'Cliente', 'cinthyacacuango2345@gmail.com', '0959279864', 'San Antonio,Tanguarin', 'Activo'),
(4, '1005115389', 'MALES PORRAS', 'HAROLD ALEJANDRO ', 'Cliente', 'haroldmales2.0@gmail.com', '0999687356', 'Conjunto nueva esperanza, floresta', 'Activo'),
(5, '1003514989', 'POZO RUIZ', 'JESSICA ALEXANDRA', 'Cliente', 'pozojs1996@gmail.com', '0994581848', ' San Antonio de Ibarra', 'Activo'),
(6, '0401339854', 'SALAZAR DIAZ', 'SEGUNDO EMITERIO', 'Cliente', 'segundoemiterio7.0@gmail.com', '0939187230', 'San Antonio,Tanguarin', 'Activo'),
(7, '1004869184', 'CACUANGO PUMA', 'CINTHYA MISHELL', 'Cliente', 'cinthya2.0@gmail.com', '0999064019', 'moseñor leonidas proaño', 'Inactivo'),
(8, '1713398541', 'SALAZAR LARA', 'NELSON XAVIER', 'Cliente', 'xavierzalasar.1977@gmail.com', '0999885548', 'Huertos Familiares', 'Activo'),
(9, '1004871545', 'NARVAEZ PUPIALES', 'PAMELA ESTEFANIA', 'Usuario', 'estefaniapupiales7@gmail.com', '0989087076', 'San Antonio,barrio los soles', 'Activo'),
(10, '1050454261', 'MELO POZO', 'KARLA ESTEFANIA', 'Usuario', 'pozoestefi156@gmail.com', '0967571680', 'huertos familiares-13 de abril', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
