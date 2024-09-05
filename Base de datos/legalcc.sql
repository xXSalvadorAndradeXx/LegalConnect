-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2024 a las 04:24:20
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
-- Error leyendo datos de la tabla legalcc.audiencias: #2006 - MySQL server has gone away
<div class="alert alert-danger" role="alert"><h1>Error</h1><p><strong>consulta SQL:</strong>  <a href="#" class="copyQueryBtn" data-text="SET SQL_QUOTE_SHOW_CREATE = 1">Copiar</a>
<a href="index.php?route=/database/sql&sql_query=SET+SQL_QUOTE_SHOW_CREATE+%3D+1&show_query=1&db=legalcc"><span class="text-nowrap"><img src="themes/dot.gif" title="Editar" alt="Editar" class="icon ic_b_edit">&nbsp;Editar</span></a>    </p>
<p>
<code class="sql"><pre>
SET SQL_QUOTE_SHOW_CREATE = 1
</pre></code>
</p>
<p>
    <strong>MySQL ha dicho: </strong><a href="./url.php?url=https%3A%2F%2Fdev.mysql.com%2Fdoc%2Frefman%2F8.0%2Fen%2Fserver-error-reference.html" target="mysql_doc"><img src="themes/dot.gif" title="Documentación" alt="Documentación" class="icon ic_b_help"></a>
</p>
<code>#2006 - MySQL server has gone away</code><br></div>