-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2024 a las 21:54:24
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
-- Base de datos: `legalcc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audiencias`
--

CREATE TABLE `audiencias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `caso` varchar(50) NOT NULL,
  `modalidad` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `imputado` varchar(255) NOT NULL,
  `victima` varchar(255) NOT NULL,
  `delito` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `juzgado` varchar(50) NOT NULL,
  `abogado` varchar(50) NOT NULL,
  `fiscal` varchar(50) NOT NULL,
  `sala` varchar(50) NOT NULL,
  `juez_suplente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `audiencias`
--

INSERT INTO `audiencias` (`id`, `titulo`, `caso`, `modalidad`, `fecha`, `hora`, `imputado`, `victima`, `delito`, `descripcion`, `juzgado`, `abogado`, `fiscal`, `sala`, `juez_suplente`) VALUES
(8, 'Primera 1', '2024-08-23-08-25-14-7711', 'Virtual', '2024-09-02', '20:16:00', 'Maria', 'Salvador', 'Homicidio', 'Nada', 'Juzgado 1', 'Abogado 1', 'Fiscal 1', 'Sala 1', 'Suplente 1'),
(9, 'Primera', '2024-08-23-08-25-14-7711', 'Presencial', '2024-09-02', '21:20:00', 'Maria', 'Andrade', 'Violación', 'sdasdasd', 'Juzgado 1', 'Abogado 1', 'Fiscal 1', 'Sala 1', 'Suplente 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos`
--

CREATE TABLE `casos` (
  `id` int(11) NOT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `victima` varchar(255) DEFAULT NULL,
  `imputado` varchar(255) DEFAULT NULL,
  `tipo_delito` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `fecha_creacion` date NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(10) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `casos`
--

INSERT INTO `casos` (`id`, `referencia`, `victima`, `imputado`, `tipo_delito`, `documento`, `fecha_creacion`, `estado`) VALUES
(135, '2024-08-25-08-46-38-1598', 'Salvador', 'Maria', 'asalto', NULL, '2024-08-25', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos_archivados`
--

CREATE TABLE `casos_archivados` (
  `id` int(11) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `victima` varchar(255) NOT NULL,
  `imputado` varchar(255) NOT NULL,
  `tipo_delito` varchar(255) NOT NULL,
  `archivos_documento` text DEFAULT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_expiracion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `casos_archivados`
--

INSERT INTO `casos_archivados` (`id`, `referencia`, `victima`, `imputado`, `tipo_delito`, `archivos_documento`, `fecha_creacion`, `fecha_expiracion`) VALUES
(81, '2024-08-23-16-57-04-8065', 'Maria', 'Salvador', 'fraude', NULL, '2024-08-23', '2025-08-23'),
(87, '2024-08-23-08-25-14-7711', 'Salvador', 'Juan', 'homicidio', NULL, '2024-08-23', '2025-08-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delete_requests`
--

CREATE TABLE `delete_requests` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `razon` text NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `delete_requests`
--

INSERT INTO `delete_requests` (`id`, `nombre_usuario`, `razon`, `fecha_hora`, `fecha_solicitud`) VALUES
(5, 'Salvador Salgado', 'assdaasd', '2024-08-28 00:21:00', '2024-08-28 06:18:27'),
(6, 'Salvador Salgado', 'sdasdsad', '2024-08-28 02:19:00', '2024-08-28 06:19:06'),
(7, 'Salvador Salgado', 'Necesito mas tiempo', '2024-08-29 00:21:00', '2024-08-28 06:21:38'),
(8, 'Salvador Salgado', 'sdasd', '2024-08-29 00:22:00', '2024-08-28 06:22:20'),
(9, 'Salvador Salgado', 'asdsd', '2024-08-28 00:30:00', '2024-08-28 06:30:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `ubicacion_archivo` varchar(255) DEFAULT NULL,
  `archivado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `caso_referencia`, `nombre_archivo`, `tipo_archivo`, `ubicacion_archivo`, `archivado`) VALUES
(35, '2024-08-25-08-46-38-1598', 'Entregable planificación del sprint (1).docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'documentos/Entregable planificación del sprint (1).docx', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_archivados`
--

CREATE TABLE `documentos_archivados` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `nombre_archivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

CREATE TABLE `evidencias` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `ubicacion_archivo` varchar(255) DEFAULT NULL,
  `tipo_evidencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias_archivadas`
--

CREATE TABLE `evidencias_archivadas` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `tipo_evidencia` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `juez` varchar(100) NOT NULL,
  `razon` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `juez_id` int(11) NOT NULL,
  `razon` text NOT NULL,
  `fecha_sugerida` date NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `caso_id` int(11) DEFAULT NULL,
  `respuesta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `usuario_id`, `juez_id`, `razon`, `fecha_sugerida`, `estado`, `fecha_creacion`, `caso_id`, `respuesta`) VALUES
(10, 7, 9, 'Necesito mas tiempo para recolectar mas información', '2024-09-11', 'Rechazada', '2024-09-03 15:55:24', 8, 'Sin Respuesta'),
(13, 7, 9, 'Tremendo', '2024-09-04', 'Pendiente', '2024-09-04 06:45:04', 8, 'Sin Respuesta'),
(14, 7, 9, 'sdasdas', '2024-09-04', 'Pendiente', '2024-09-05 00:29:56', 8, 'Sin Respuesta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `telefono`, `tipo`, `correo`, `contrasena`) VALUES
(7, 'Salvador', 'Salgado', '1111-1111', 'abogado', 'parcial111@gmail.com', '$2y$10$xAaoM6TMmGcIb1YsIiJ9CumCMm9QAZ/DqOaMjpBEImwa.iXHh9pti'),
(9, 'Maria', 'Salgado', '2222-2222', 'juez', 'salva@gmail.com', '$2y$10$COTDr3mZ32Pm3w10uOIhYuoM4WqNNLUeVMXWV9DL03ub/yvN7LZwW'),
(10, 'Salvador', 'Andrade', '1111-1111', 'juez', 'maria@gmail.com', '$2y$10$xmqexZHLtL7JVT46LEIDWemn9S4pXXSDG4kn0cCe2zJ82sHGndsuu');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `audiencias`
--
ALTER TABLE `audiencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `casos`
--
ALTER TABLE `casos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referencia` (`referencia`);

--
-- Indices de la tabla `casos_archivados`
--
ALTER TABLE `casos_archivados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referencia` (`referencia`);

--
-- Indices de la tabla `delete_requests`
--
ALTER TABLE `delete_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_referencia` (`caso_referencia`);

--
-- Indices de la tabla `documentos_archivados`
--
ALTER TABLE `documentos_archivados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_referencia` (`caso_referencia`);

--
-- Indices de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_referencia` (`caso_referencia`);

--
-- Indices de la tabla `evidencias_archivadas`
--
ALTER TABLE `evidencias_archivadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_referencia` (`caso_referencia`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `juez_id` (`juez_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `audiencias`
--
ALTER TABLE `audiencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `casos`
--
ALTER TABLE `casos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `casos_archivados`
--
ALTER TABLE `casos_archivados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `delete_requests`
--
ALTER TABLE `delete_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `documentos_archivados`
--
ALTER TABLE `documentos_archivados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `evidencias_archivadas`
--
ALTER TABLE `evidencias_archivadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`caso_referencia`) REFERENCES `casos` (`referencia`);

--
-- Filtros para la tabla `documentos_archivados`
--
ALTER TABLE `documentos_archivados`
  ADD CONSTRAINT `documentos_archivados_ibfk_1` FOREIGN KEY (`caso_referencia`) REFERENCES `casos_archivados` (`referencia`);

--
-- Filtros para la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD CONSTRAINT `evidencias_ibfk_1` FOREIGN KEY (`caso_referencia`) REFERENCES `casos` (`referencia`);

--
-- Filtros para la tabla `evidencias_archivadas`
--
ALTER TABLE `evidencias_archivadas`
  ADD CONSTRAINT `evidencias_archivadas_ibfk_1` FOREIGN KEY (`caso_referencia`) REFERENCES `casos_archivados` (`referencia`);

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`juez_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
