-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-08-2024 a las 21:51:45
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
(7, 'Primera', '2024-05-12-04-04-41-5949', 'Virtual', '2024-05-16', '13:46:00', 'Maria', 'Maria', 'Hurto', '12345678', 'Juzgado 3', 'Abogado 2', 'Fiscal 3', 'Sala 1', 'Suplente 1');

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
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(10) DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos_archivados`
--

CREATE TABLE `casos_archivados` (
  `referencia` varchar(255) NOT NULL,
  `victima` varchar(255) DEFAULT NULL,
  `imputado` varchar(255) DEFAULT NULL,
  `tipo_delito` varchar(255) DEFAULT NULL,
  `archivos_documento` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `casos_archivados`
--

INSERT INTO `casos_archivados` (`referencia`, `victima`, `imputado`, `tipo_delito`, `archivos_documento`, `fecha_creacion`) VALUES
('2024-08-19-21-46-47-5646', 'Salvador', 'Maria', 'robo', NULL, '2024-08-19 13:46:47'),
('2024-08-19-21-49-48-1461', 'Salvador', 'MAria', 'robo', NULL, '2024-08-19 13:49:48');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_archivados`
--

CREATE TABLE `documentos_archivados` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `nombre_archivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos_archivados`
--

INSERT INTO `documentos_archivados` (`id`, `caso_referencia`, `nombre_archivo`) VALUES
(1, '2024-08-19-21-46-47-5646', 'storyboard-plantilla-aprendercine.pdf'),
(2, '2024-08-19-21-46-47-5646', 'storyboard-plantilla-aprendercine.pdf'),
(3, '2024-08-19-21-46-47-5646', 'storyboard-plantilla-aprendercine.pdf');

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
(5, 'Salvador', 'Andrade', '1111-1111', 'juez', 'parcial@gmail.com', '$2y$10$ZJaMfM.tMPusmJayhqFI0uP2.aYlufS8gKJ/NYk2KfP27w3S.Ump2'),
(6, 'Maria', 'Salgado', '2222-2222', 'juez', 'maria@gmail.com', '$2y$10$SrZV1pcnr8u83jdJK2Qb1.ZJxQWizo5hWApT7Bmxw7t.Pgrc5Jxc.');

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
  ADD PRIMARY KEY (`referencia`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `casos`
--
ALTER TABLE `casos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `delete_requests`
--
ALTER TABLE `delete_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `documentos_archivados`
--
ALTER TABLE `documentos_archivados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `evidencias_archivadas`
--
ALTER TABLE `evidencias_archivadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
