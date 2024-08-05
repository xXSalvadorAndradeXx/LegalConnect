-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2024 a las 16:36:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

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
(4, 'Plazos 2', 'Caso 1', 'Virtual', '2024-04-26', '13:00:00', 'Ramon', 'Juan Carlos Mejia', 'Violacion', 'Ramon abuzo fisicamente de a Juan Carlos de maneras repetidas', 'Juzgado 2', 'Abogado 1', 'Fiscal 1', 'Sala 1', 'Suplente 3'),
(5, 'Primera Audiencia', 'Caso 2', 'Virtual', '2024-04-27', '13:33:00', 'Emilio', 'Salvador', 'Hurto', 'Hurto culposo', 'Juzgado 3', 'Abogado 2', 'Fiscal 3', 'Sala 2', 'Suplente 3'),
(6, 'Cambio de Medidas', 'Caso 2', 'Virtual', '2024-04-27', '13:00:00', 'Salvador', 'Emilio', 'Homicidio', 'Cambio de medidas', 'Juzgado 2', 'Abogado 2', 'Fiscal 2', 'Sala 3', 'Suplente 3'),
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
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `casos`
--

INSERT INTO `casos` (`id`, `referencia`, `victima`, `imputado`, `tipo_delito`, `documento`, `fecha_creacion`) VALUES
(14, '2024-05-12-04-04-41-5949', 'Maria', 'Salvador', 'Asalto', NULL, '2024-05-12 02:04:41'),
(15, '2024-05-13-04-16-17-4724', 'Salvador', 'Maria', 'Asalto', NULL, '2024-05-13 02:16:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `ubicacion_archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `caso_referencia`, `nombre_archivo`, `tipo_archivo`, `ubicacion_archivo`) VALUES
(6, '2024-05-12-04-04-41-5949', 'Ejemplo de Trabajo Final.pdf', 'application/pdf', 'documentos/Ejemplo de Trabajo Final.pdf'),
(7, '2024-05-13-04-16-17-4724', 'Investigaciónes.pdf', 'application/pdf', 'documentos/Investigaciónes.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

CREATE TABLE `evidencias` (
  `id` int(11) NOT NULL,
  `caso_referencia` varchar(255) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `ubicacion_archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evidencias`
--

INSERT INTO `evidencias` (`id`, `caso_referencia`, `nombre_archivo`, `tipo_archivo`, `ubicacion_archivo`) VALUES
(33, '2024-05-12-04-04-41-5949', 'thousand-sunny-ys.jpg', NULL, 'uploads/thousand-sunny-ys.jpg'),
(34, '2024-05-12-04-04-41-5949', 'nfw - unbound (2).mp3', NULL, 'uploads/nfw - unbound (2).mp3'),
(35, '2024-05-13-04-16-17-4724', 'inicio.png', NULL, 'uploads/inicio.png');

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
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caso_referencia` (`caso_referencia`);

--
-- Indices de la tabla `evidencias`
--
ALTER TABLE `evidencias`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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
-- Filtros para la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD CONSTRAINT `evidencias_ibfk_1` FOREIGN KEY (`caso_referencia`) REFERENCES `casos` (`referencia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
