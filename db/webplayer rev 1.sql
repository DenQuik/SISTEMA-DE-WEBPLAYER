-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2025 a las 06:30:01
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
-- Base de datos: `webplayer`
--
CREATE DATABASE IF NOT EXISTS `webplayer` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `webplayer`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE `album` (
  `album_id` int(10) NOT NULL,
  `album_titulo` varchar(40) NOT NULL,
  `album_portada` varchar(250) NOT NULL,
  `album_year` year(4) NOT NULL,
  `artista_id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `album`
--

INSERT INTO `album` (`album_id`, `album_titulo`, `album_portada`, `album_year`, `artista_id`, `usuario_id`) VALUES
(1, 'Instrumental Relics', 'uploads/album_portadas/a2329378692_16_jpg_73', '2020', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artista`
--

CREATE TABLE `artista` (
  `artista_id` int(10) NOT NULL,
  `artista_nombre` varchar(50) NOT NULL,
  `artista_biografia` varchar(100) NOT NULL,
  `artista_foto` varchar(250) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `artista`
--

INSERT INTO `artista` (`artista_id`, `artista_nombre`, `artista_biografia`, `artista_foto`, `usuario_id`) VALUES
(1, 'Clams casino', 'Michael Thomas Volpe (born May 12, 1987), known professionally as Clams Casino, is an American recor', 'uploads/artista_fotos/channels4_profile_jpg_87', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancion`
--

CREATE TABLE `cancion` (
  `cancion_id` int(10) NOT NULL,
  `cancion_titulo` varchar(50) NOT NULL,
  `artista_id` int(10) NOT NULL,
  `genero_id` int(10) NOT NULL,
  `album_id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `cancion_archivo` varchar(250) NOT NULL,
  `cancion_foto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `cancion`
--

INSERT INTO `cancion` (`cancion_id`, `cancion_titulo`, `artista_id`, `genero_id`, `album_id`, `usuario_id`, `cancion_archivo`, `cancion_foto`) VALUES
(1, 'Im god', 1, 1, 1, 2, 'uploads/canciones/1765342892_Clams_Casino_-_I_m_God.mp3', 'uploads/cancion_portadas/a2329378692_16_44.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `genero_id` int(10) NOT NULL,
  `genero_nombre` varchar(50) NOT NULL,
  `genero_descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`genero_id`, `genero_nombre`, `genero_descripcion`) VALUES
(1, 'cloud', 'cloud, hip-hop, clams casino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE `playlist` (
  `playlist_id` int(10) NOT NULL,
  `playlist_nombre` varchar(40) NOT NULL,
  `playlist_descripcion` varchar(70) NOT NULL,
  `playlist_foto` varchar(250) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`playlist_id`, `playlist_nombre`, `playlist_descripcion`, `playlist_foto`, `usuario_id`) VALUES
(1, 'fucking nigger', 'tu perra madre', 'uploads/playlist_portadas/image_88.png', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist_cancion`
--

CREATE TABLE `playlist_cancion` (
  `playlistc_id` int(10) NOT NULL,
  `playlist_id` int(10) NOT NULL,
  `cancion_id` int(10) NOT NULL,
  `playlistc_orden` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `playlist_cancion`
--

INSERT INTO `playlist_cancion` (`playlistc_id`, `playlist_id`, `cancion_id`, `playlistc_orden`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(10) NOT NULL,
  `usuario_nombre` varchar(40) NOT NULL,
  `usuario_apellido` varchar(40) NOT NULL,
  `usuario_usuario` varchar(20) NOT NULL,
  `usuario_clave` varchar(200) NOT NULL,
  `usuario_email` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_usuario`, `usuario_clave`, `usuario_email`) VALUES
(1, 'Administrador', 'Principal', 'Administrador', '$2y$10$EPY9LSLOFLDDBriuJICmFOqmZdnDXxLJG8YFbog5LcExp77DBQvgC', ''),
(2, 'Bogart', 'Viloria', 'DenQuik', '$2y$10$QQ8ZLGHbQDeORCiw99aVfuy1aliwDt/UfIzTpWEzxnJIYurKXBOHm', 'DenQuik@hotmail.com'),
(3, 'asfdfsasfasfasf', 'asfasffasafsasffas', 'asfasffasafsasffas', '$2y$10$2TnXknMkwV9Cymja1OJVFeC2srN2xRYBRCbZvOjmfYuvaqqBTh4lO', 'asfasffasafsasffas@hotmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `artista_id` (`artista_id`);

--
-- Indices de la tabla `artista`
--
ALTER TABLE `artista`
  ADD PRIMARY KEY (`artista_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `cancion`
--
ALTER TABLE `cancion`
  ADD PRIMARY KEY (`cancion_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `genero_id` (`genero_id`),
  ADD KEY `artista_id` (`artista_id`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`genero_id`);

--
-- Indices de la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`playlist_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `playlist_cancion`
--
ALTER TABLE `playlist_cancion`
  ADD PRIMARY KEY (`playlistc_id`),
  ADD KEY `cancion_id` (`cancion_id`),
  ADD KEY `playlist_id` (`playlist_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `usuario_usuario` (`usuario_usuario`),
  ADD UNIQUE KEY `usuario_email` (`usuario_email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `artista`
--
ALTER TABLE `artista`
  MODIFY `artista_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cancion`
--
ALTER TABLE `cancion`
  MODIFY `cancion_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `genero_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `playlist`
--
ALTER TABLE `playlist`
  MODIFY `playlist_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `playlist_cancion`
--
ALTER TABLE `playlist_cancion`
  MODIFY `playlistc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`artista_id`) REFERENCES `artista` (`artista_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `artista`
--
ALTER TABLE `artista`
  ADD CONSTRAINT `artista_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cancion`
--
ALTER TABLE `cancion`
  ADD CONSTRAINT `cancion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cancion_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cancion_ibfk_3` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`genero_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cancion_ibfk_4` FOREIGN KEY (`artista_id`) REFERENCES `artista` (`artista_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `playlist`
--
ALTER TABLE `playlist`
  ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `playlist_cancion`
--
ALTER TABLE `playlist_cancion`
  ADD CONSTRAINT `playlist_cancion_ibfk_1` FOREIGN KEY (`cancion_id`) REFERENCES `cancion` (`cancion_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playlist_cancion_ibfk_2` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`playlist_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
