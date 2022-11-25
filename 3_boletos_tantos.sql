-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2022 a las 00:55:19
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
-- Estructura de tabla para la tabla `boletos_tantos`
--

CREATE TABLE `boletos_tantos` (
  `id_remesa` int(10) UNSIGNED NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `cve_escuela` int(10) UNSIGNED NOT NULL,
  `cantidad_folios` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `boletos_tantos`
--

INSERT INTO `boletos_tantos` (`id_remesa`, `id_ciclo`, `cve_escuela`, `cantidad_folios`, `created_at`, `updated_at`) VALUES
(3, 2223, 1, 15, '2022-11-22 19:05:34', '2022-11-22 19:05:34'),
(3, 2223, 3, 16, '2022-11-22 19:05:34', '2022-11-22 19:05:34'),
(3, 2223, 4, 16, '2022-11-22 19:05:34', '2022-11-22 19:05:34'),
(3, 2223, 5, 17, '2022-11-22 21:24:22', '2022-11-22 21:24:22'),
(4, 2223, 1, 10, '2022-11-23 17:35:34', '2022-11-23 17:35:34'),
(4, 2223, 3, 15, '2022-11-23 17:35:34', '2022-11-23 17:35:34'),
(4, 2223, 4, 15, '2022-11-23 17:35:34', '2022-11-23 17:35:34'),
(4, 2223, 5, 15, '2022-11-23 17:35:34', '2022-11-23 17:35:34'),
(5, 2223, 1, 10, '2022-11-23 17:38:47', '2022-11-23 17:38:47'),
(5, 2223, 3, 15, '2022-11-23 17:38:47', '2022-11-23 17:38:47'),
(5, 2223, 4, 15, '2022-11-23 17:38:47', '2022-11-23 17:38:47'),
(5, 2223, 5, 15, '2022-11-23 17:38:47', '2022-11-23 17:38:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boletos_tantos`
--
ALTER TABLE `boletos_tantos`
  ADD UNIQUE KEY `boletos_tantos_id_remesa_id_ciclo_cve_escuela_unique` (`id_remesa`,`id_ciclo`,`cve_escuela`),
  ADD KEY `boletos_tantos_id_ciclo_foreign` (`id_ciclo`),
  ADD KEY `boletos_tantos_cve_escuela_foreign` (`cve_escuela`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletos_tantos`
--
ALTER TABLE `boletos_tantos`
  ADD CONSTRAINT `boletos_tantos_cve_escuela_foreign` FOREIGN KEY (`cve_escuela`) REFERENCES `escuelas` (`cve_escuela`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_tantos_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_tantos_id_remesa_foreign` FOREIGN KEY (`id_remesa`) REFERENCES `boletos_remesas` (`id_remesa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
