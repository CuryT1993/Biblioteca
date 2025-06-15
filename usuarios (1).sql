-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2025 a las 02:42:13
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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(4) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `tipo` enum('Cliente','Usuario','','') NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `estado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `apellidos`, `nombres`, `tipo`, `email`, `celular`, `direccion`, `estado`) VALUES
(1, '1003191259', 'NARVAEZ PIPIALES ', 'MARCIA YOLANDA', 'Cliente', 'yolandanarvaez9@gmail.com', '0988022358', 'San Antonio Barrio Moras', 'Activo'),
(2, '1001924503', 'PUPIALES CARLOSAMA', 'ELSA MARINA', 'Cliente', 'elsamarina82@gmail.com', '0981161874', 'San Antonio Barrio Las Orquideas', 'Activo'),
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
