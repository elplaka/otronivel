-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2022 a las 00:55:44
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
-- Estructura de tabla para la tabla `boletos_asignados`
--

CREATE TABLE `boletos_asignados` (
  `id_remesa` int(10) UNSIGNED NOT NULL,
  `id_paquete` int(10) UNSIGNED NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `id_estudiante` bigint(20) UNSIGNED NOT NULL,
  `folio_inicial` bigint(20) NOT NULL,
  `folio_final` bigint(20) NOT NULL,
  `entregados` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `boletos_asignados`
--

INSERT INTO `boletos_asignados` (`id_remesa`, `id_paquete`, `id_ciclo`, `id_estudiante`, `folio_inicial`, `folio_final`, `entregados`, `created_at`, `updated_at`) VALUES
(3, 4, 2223, 1, 3129, 3143, 0, '2022-11-23 18:00:42', '2022-11-23 18:00:42'),
(3, 4, 2223, 3, 3159, 3174, 0, '2022-11-23 18:00:42', '2022-11-23 18:00:42'),
(3, 4, 2223, 5, 3080, 3095, 0, '2022-11-23 18:00:42', '2022-11-23 18:00:42'),
(3, 4, 2223, 6, 3144, 3158, 0, '2022-11-23 18:00:42', '2022-11-23 18:00:42'),
(3, 4, 2223, 10, 3112, 3128, 0, '2022-11-23 18:00:42', '2022-11-23 18:00:42'),
(3, 4, 2223, 12, 3096, 3111, 0, '2022-11-23 18:00:42', '2022-11-23 18:00:42'),
(4, 4, 2223, 5, 3475, 3489, 0, '2022-11-23 18:01:35', '2022-11-23 18:01:35'),
(4, 5, 2223, 1, 3520, 3529, 0, '2022-11-23 18:01:35', '2022-11-23 18:01:35'),
(4, 5, 2223, 3, 3540, 3554, 0, '2022-11-23 18:01:35', '2022-11-23 18:01:35'),
(4, 5, 2223, 6, 3530, 3539, 0, '2022-11-23 18:01:35', '2022-11-23 18:01:35'),
(4, 5, 2223, 10, 3505, 3519, 0, '2022-11-23 18:01:35', '2022-11-23 18:01:35'),
(4, 7, 2223, 12, 3490, 3500, 0, '2022-11-24 20:55:25', '2022-11-24 20:55:25'),
(4, 8, 2223, 12, 3501, 3504, 0, '2022-11-24 20:55:25', '2022-11-24 20:55:25'),
(5, 4, 2223, 1, 3045, 3054, 0, '2022-11-23 17:57:44', '2022-11-23 17:57:44'),
(5, 4, 2223, 3, 3065, 3079, 0, '2022-11-23 17:57:44', '2022-11-23 17:57:44'),
(5, 4, 2223, 6, 3055, 3064, 0, '2022-11-23 17:57:44', '2022-11-23 17:57:44'),
(5, 4, 2223, 10, 3030, 3044, 0, '2022-11-23 17:57:44', '2022-11-23 17:57:44'),
(5, 4, 2223, 12, 3015, 3029, 0, '2022-11-23 17:57:44', '2022-11-23 17:57:44'),
(5, 9, 2223, 5, 3000, 3000, 0, '2022-11-24 21:15:36', '2022-11-24 21:15:36'),
(5, 10, 2223, 5, 3001, 3014, 0, '2022-11-24 21:15:36', '2022-11-24 21:15:36');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boletos_asignados`
--
ALTER TABLE `boletos_asignados`
  ADD UNIQUE KEY `boletos_asignados_pk` (`id_remesa`,`id_paquete`,`id_ciclo`,`id_estudiante`),
  ADD KEY `boletos_asignados_id_ciclo_foreign` (`id_ciclo`),
  ADD KEY `boletos_asignados_id_paquete_foreign` (`id_paquete`),
  ADD KEY `boletos_asignados_id_estudiante_foreign` (`id_estudiante`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boletos_asignados`
--
ALTER TABLE `boletos_asignados`
  ADD CONSTRAINT `boletos_asignados_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_asignados_id_estudiante_foreign` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_asignados_id_paquete_foreign` FOREIGN KEY (`id_paquete`) REFERENCES `boletos_paquetes` (`id_paquete`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `boletos_asignados_id_remesa_foreign` FOREIGN KEY (`id_remesa`) REFERENCES `boletos_remesas` (`id_remesa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
