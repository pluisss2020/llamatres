-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-08-2021 a las 07:44:45
-- Versión del servidor: 5.5.49
-- Versión de PHP: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `texto` text,
  `imagen` varchar(128) DEFAULT NULL,
  `plantilla` int(11) DEFAULT '1',
  `v_desde` varchar(20) DEFAULT NULL,
  `v_hasta` varchar(20) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  `link` varchar(128) DEFAULT NULL,
  `texto1` text,
  `texto2` text,
  `imagen1` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `carteles`
--

INSERT INTO `carteles` (`id_cartel`, `categoria`, `titulo`, `texto`, `imagen`, `plantilla`, `v_desde`, `v_hasta`, `activo`, `link`, `texto1`, `texto2`, `imagen1`) VALUES
(21, 'PORTADA', 'HOLA MUNDO', '		   ', '', 0, '', '', 0, '', '		   ', '		   ', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `id_j1` int(11) NOT NULL DEFAULT '0',
  `id_j2` int(11) NOT NULL DEFAULT '0',
  `id_j3` int(11) NOT NULL DEFAULT '0',
  `id_j4` int(11) NOT NULL DEFAULT '0',
  `id_j5` int(11) NOT NULL DEFAULT '0',
  `pts1` int(11) NOT NULL DEFAULT '0',
  `pts2` int(11) NOT NULL DEFAULT '0',
  `pts3` int(11) NOT NULL DEFAULT '0',
  `pts4` int(11) DEFAULT '0',
  `pts5` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `puntos` int(6) NOT NULL DEFAULT '0',
  `status` varchar(1) NOT NULL DEFAULT 'I',
  `id_mesa` int(4) NOT NULL DEFAULT '0',
  `nro_jugador` int(1) NOT NULL DEFAULT '0',
  `passwd` varchar(32) NOT NULL,
  `foto` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nick`, `email`, `rol`, `imagen`, `puntos`, `status`, `id_mesa`, `nro_jugador`, `passwd`, `foto`) VALUES
(1, 'lp', '', 'administrador', '', 0, 'I', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(2, 'cm', 'cc@gmail', 'JUGADOR', '', 0, 'I', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(3, 'Anto', 'ap@gmail.com', 'JUGADOR', '', 0, 'I', 0, 0, '81dc9bdb52d04dc20036dbd8313ed055', NULL);

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
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
