-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2022 a las 00:53:54
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alivianate`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletos_paquetes`
--

CREATE TABLE `boletos_paquetes` (
  `id_paquete` int(10) UNSIGNED NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `folio_inicial` bigint(20) NOT NULL,
  `folio_final` bigint(20) NOT NULL,
  `ult_folio_asignado` int(11) NOT NULL,
  `folios_disponibles` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `boletos_paquetes`
--

INSERT INTO `boletos_paquetes` (`id_paquete`, `id_ciclo`, `folio_inicial`, `folio_final`, `ult_folio_asignado`, `folios_disponibles`, `created_at`, `updated_at`) VALUES
(1, 2223, 1, 10, 10, 0, '2022-11-11 23:35:22', '2022-11-19 02:00:47'),
(2, 2223, 1001, 3000, 3000, 0, '2022-11-12 00:46:50', '2022-11-23 17:57:44'),
(4, 2223, 3001, 3500, 3500, 0, '2022-11-12 14:19:45', '2022-11-23 18:01:35'),
(5, 2223, 3501, 5000, 3562, 1438, '2022-11-14 17:04:08', '2022-11-24 18:27:56'),
(6, 2223, 5001, 9000, 0, 4000, '2022-11-14 17:09:40', '2022-11-18 18:48:19'),
(7, 2223, 3490, 3500, 3500, 0, '2022-11-24 18:08:30', '2022-11-24 20:55:25'),
(8, 2223, 3501, 3504, 3504, 0, '2022-11-24 18:08:30', '2022-11-24 20:55:25'),
(9, 2223, 3000, 3000, 3000, 0, '2022-11-24 21:14:56', '2022-11-24 21:15:36'),
(10, 2223, 3001, 3014, 3014, 0, '2022-11-24 21:14:56', '2022-11-24 21:15:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boletos_paquetes`
--
ALTER TABLE `boletos_paquetes`
  ADD UNIQUE KEY `boletos_paquetes_id_paquete_id_ciclo_unique` (`id_paquete`,`id_ciclo`),
  ADD KEY `boletos_paquetes_id_ciclo_foreign` (`id_ciclo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boletos_paquetes`
--
ALTER TABLE `boletos_paquetes`
  MODIFY `id_paquete` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletos_paquetes`
--
ALTER TABLE `boletos_paquetes`
  ADD CONSTRAINT `boletos_paquetes_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
