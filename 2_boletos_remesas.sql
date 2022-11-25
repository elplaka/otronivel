-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2022 a las 00:54:41
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
-- Estructura de tabla para la tabla `boletos_remesas`
--

CREATE TABLE `boletos_remesas` (
  `id_remesa` int(10) UNSIGNED NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `realizada` tinyint(1) NOT NULL DEFAULT 0,
  `con_tantos` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `boletos_remesas`
--

INSERT INTO `boletos_remesas` (`id_remesa`, `id_ciclo`, `fecha`, `descripcion`, `realizada`, `con_tantos`, `created_at`, `updated_at`) VALUES
(3, 2223, '2022-11-26', 'DICIEMBRE 2022', 1, 1, '2022-11-22 18:47:39', '2022-11-23 18:00:42'),
(4, 2223, '2023-01-15', 'ENERO 2024', 1, 1, '2022-11-23 17:35:00', '2022-11-23 18:01:35'),
(5, 2223, '2023-02-16', 'FEBRERO 24', 1, 1, '2022-11-23 17:38:20', '2022-11-23 17:57:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boletos_remesas`
--
ALTER TABLE `boletos_remesas`
  ADD UNIQUE KEY `boletos_remesas_id_remesa_id_ciclo_unique` (`id_remesa`,`id_ciclo`),
  ADD KEY `boletos_remesas_id_ciclo_foreign` (`id_ciclo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boletos_remesas`
--
ALTER TABLE `boletos_remesas`
  MODIFY `id_remesa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletos_remesas`
--
ALTER TABLE `boletos_remesas`
  ADD CONSTRAINT `boletos_remesas_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
