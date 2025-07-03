-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2021 a las 22:46:47
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `llamatres`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carteles`
--

CREATE TABLE `carteles` (
  `id_cartel` int(11) NOT NULL,
  `categoria` varchar(25) NOT NULL DEFAULT '''AGENDA''',
  `titulo` text NOT NULL,
  `texto` text DEFAULT NULL,
  `imagen` varchar(128) DEFAULT NULL,
  `plantilla` int(11) DEFAULT 1,
  `v_desde` varchar(20) DEFAULT NULL,
  `v_hasta` varchar(20) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  `link` varchar(128) DEFAULT NULL,
  `texto1` text DEFAULT NULL,
  `texto2` text DEFAULT NULL,
  `imagen1` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carteles`
--

INSERT INTO `carteles` (`id_cartel`, `categoria`, `titulo`, `texto`, `imagen`, `plantilla`, `v_desde`, `v_hasta`, `activo`, `link`, `texto1`, `texto2`, `imagen1`) VALUES
(21, 'PORTADA', 'HOLA MUNDO', '		   ', 'B11.jpg', 1, '', '', 1, '', '		   ', '		   ', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `codigo` int(2) NOT NULL,
  `descripcion` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_user`
--

CREATE TABLE `log_user` (
  `id_log` int(11) NOT NULL,
  `id_usuario` smallint(6) UNSIGNED NOT NULL,
  `fecha` date NOT NULL DEFAULT '2000-01-01',
  `hora` time NOT NULL DEFAULT '00:00:00',
  `ip` varchar(25) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id_mesa` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `fecha_i` datetime NOT NULL,
  `fecha_f` datetime NOT NULL,
  `status_M` varchar(1) NOT NULL DEFAULT 'I',
  `id_j1` int(11) NOT NULL DEFAULT 0,
  `id_j2` int(11) NOT NULL DEFAULT 0,
  `id_j3` int(11) NOT NULL DEFAULT 0,
  `id_j4` int(11) NOT NULL DEFAULT 0,
  `id_j5` int(11) NOT NULL DEFAULT 0,
  `pts1` int(11) NOT NULL DEFAULT 0,
  `pts2` int(11) NOT NULL DEFAULT 0,
  `pts3` int(11) NOT NULL DEFAULT 0,
  `pts4` int(11) DEFAULT 0,
  `pts5` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id_mesa`, `nombre`, `fecha_i`, `fecha_f`, `status_M`, `id_j1`, `id_j2`, `id_j3`, `id_j4`, `id_j5`, `pts1`, `pts2`, `pts3`, `pts4`, `pts5`) VALUES
(3, 'plinda', '2021-10-24 09:58:32', '2021-10-24 09:58:32', 'A', 1, 9, 10, 8, 12, 0, 0, 0, 0, 0),
(4, 'pfea', '2021-10-24 09:59:01', '2021-10-24 09:59:01', 'A', 1, 9, 8, 0, 0, 0, 0, 0, 0, 0),
(5, 'frangaso', '2021-10-24 10:00:16', '2021-10-24 10:00:16', 'J', 9, 10, 11, 13, 14, 2, 1, 0, -3, 4),
(6, 'parnangarazo', '2021-10-26 02:00:30', '2021-10-26 02:00:30', 'A', 13, 9, 0, 8, 0, 0, 0, 0, 0, 0),
(8, 'FROTOSZA', '2021-10-29 12:37:14', '2021-10-29 12:37:14', 'A', 10, 8, 1, 0, 0, 0, 0, 0, 0, 0),
(9, 'OnceDeBasto', '2021-10-29 01:40:24', '2021-10-29 01:40:24', 'A', 12, 8, 1, 0, 0, 0, 0, 0, 0, 0),
(10, 'TrilloYpico', '2021-10-29 01:43:32', '2021-10-29 01:43:32', 'A', 12, 8, 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `naipes`
--

CREATE TABLE `naipes` (
  `id_naipe` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_mano` int(11) NOT NULL,
  `naipe` varchar(4) NOT NULL,
  `status_N` varchar(1) NOT NULL DEFAULT 'A',
  `nro_jug` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `sexo` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `dni` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `carrera` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `user` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `passwd` varchar(32) COLLATE latin1_spanish_ci NOT NULL,
  `rol` varchar(20) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `apellido`, `sexo`, `dni`, `carrera`, `telefono`, `email`, `user`, `passwd`, `rol`) VALUES
(150, 'Claudia Alejandra', 'Malvicini', 'Femenino', '14398969', 'Construcciones', '4256 4177', 'cm@hotmail', 'cm', '81dc9bdb52d04dc20036dbd8313ed055', 'administrador'),
(151, 'Luis', 'Perconti', 'Masculino', '', '', '', 'p_luisss@yahoo.com.ar', 'lp', '81dc9bdb52d04dc20036dbd8313ed055', 'administrador'),
(152, 'Milo', 'Perconti Gutierrez', 'Masculino', '45454545', 'Mecatronica', '42564177', 'milo@milo', 'mp', '81dc9bdb52d04dc20036dbd8313ed055', 'Moderador'),
(153, 'Lucia', 'Guti', 'Femenino', '', 'Quimica', '', 'luli@gmail', 'lg', '81dc9bdb52d04dc20036dbd8313ed055', 'Jugador'),
(155, 'Hector', 'Marucci', 'Masculino', '12121212', 'Quimica', '1143435445', 'hetito@gmail', 'hm', '81dc9bdb52d04dc20036dbd8313ed055', 'Jugador'),
(156, '', '', 'Masculino', '', '', '', 'cfk@gmail', 'cfk', '81dc9bdb52d04dc20036dbd8313ed055', 'Invitado'),
(157, '', '', 'Masculino', '', '', '', 'meto@gmail', 'meto', '81dc9bdb52d04dc20036dbd8313ed055', 'Moderador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` varchar(128) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'Puede :'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`, `descripcion`) VALUES
(1, 'Administrador General', 'Puede : Hacer Todo'),
(2, 'Supervisor Proyecto', 'Adminstra un proyecto determin'),
(3, 'Programador Senior', 'Realiza tareas de desarollo'),
(4, 'Docente', 'Supervisa un proyecto de su materia\r\nuno y solo uno'),
(5, 'Directivo', 'Puede ver informes y generar tickets para este proyecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nick` varchar(25) NOT NULL,
  `email` varchar(60) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'JUGADOR',
  `imagen` varchar(60) DEFAULT '',
  `puntos` int(6) NOT NULL DEFAULT 0,
  `status_J` varchar(1) NOT NULL DEFAULT 'I',
  `id_mesa` int(4) NOT NULL DEFAULT 0,
  `nro_jugador` int(1) NOT NULL DEFAULT 0,
  `passwd` varchar(32) NOT NULL,
  `foto` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nick`, `email`, `rol`, `imagen`, `puntos`, `status_J`, `id_mesa`, `nro_jugador`, `passwd`, `foto`) VALUES
(1, 'lp', '', 'administrador', '', 0, 'J', 8, 3, '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(8, 'fertengo', 'fr@gmail.com', 'Jugador', '', 0, 'J', 6, 4, '81dc9bdb52d04dc20036dbd8313ed055', ''),
(9, 'frotongas', 'pr@cmail.com', 'Jugador', '', 0, 'J', 0, 1, '81dc9bdb52d04dc20036dbd8313ed055', ''),
(10, 'frandanga', 'fr@ltmail.com', 'Jugador', 'B11.jpg', 0, 'J', 3, 3, '81dc9bdb52d04dc20036dbd8313ed055', ''),
(11, 'prandosa', 'prandosa@ltmail.com', 'Jugador', 'x', 0, '', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', ''),
(12, 'antoper', 'ap@gmail', 'Jugador', '', 0, 'J', 3, 5, '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(13, 'parnanga', 'parnanga@gamil.com', 'Jugador', '', 0, 'I', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(14, 'marcozo', 'marcozo@gmail.com', 'Jugador', '', 0, 'I', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carteles`
--
ALTER TABLE `carteles`
  ADD PRIMARY KEY (`id_cartel`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `log_user`
--
ALTER TABLE `log_user`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id_mesa`);

--
-- Indices de la tabla `naipes`
--
ALTER TABLE `naipes`
  ADD PRIMARY KEY (`id_naipe`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carteles`
--
ALTER TABLE `carteles`
  MODIFY `id_cartel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_user`
--
ALTER TABLE `log_user`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `naipes`
--
ALTER TABLE `naipes`
  MODIFY `id_naipe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
