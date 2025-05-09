-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2025 a las 16:54:37
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
-- Base de datos: `bookswap`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intercambios`
--

CREATE TABLE `intercambios` (
  `idintercambio` int(11) NOT NULL,
  `id_libro_ofrecido` int(11) DEFAULT NULL,
  `id_libro_solicitado` int(11) NOT NULL,
  `id_solicitante` int(11) NOT NULL,
  `id_propietario` int(11) NOT NULL,
  `estado` enum('pendiente','aceptado','rechazado','completado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha_intercambio` date DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `idlibro` int(11) NOT NULL,
  `titulo` varchar(256) NOT NULL,
  `autor` varchar(256) NOT NULL,
  `genero` varchar(256) NOT NULL,
  `editorial` varchar(256) NOT NULL,
  `idioma` varchar(256) NOT NULL,
  `estado` enum('nuevo','bueno','aceptable','deteriorado') NOT NULL DEFAULT 'bueno',
  `descripcion` text NOT NULL,
  `imagen` varchar(256) NOT NULL,
  `idpropietario` int(11) NOT NULL,
  `disponible` tinyint(4) NOT NULL DEFAULT 1,
  `fecha_publicacion` date NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `correo` varchar(256) NOT NULL,
  `contraseña` varchar(256) NOT NULL,
  `imagen` varchar(256) default NULL,
  `tipo` enum('admin','normal') NOT NULL DEFAULT 'normal'
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE eventos (
    idevento INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    lugar VARCHAR(255) NOT NULL,
    genero VARCHAR(100)
);


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `intercambios`
--
ALTER TABLE `intercambios`
  ADD PRIMARY KEY (`idintercambio`),
  ADD KEY `intercambios_ibfk_1` (`id_libro_ofrecido`),
  ADD KEY `intercambios_ibfk_2` (`id_libro_solicitado`),
  ADD KEY `intercambios_ibfk_3` (`id_solicitante`),
  ADD KEY `intercambios_ibfk_4` (`id_propietario`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`idlibro`),
  ADD KEY `libros_ibfk_1` (`idpropietario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `intercambios`
--
ALTER TABLE `intercambios`
  MODIFY `idintercambio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `idlibro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `intercambios`
--
ALTER TABLE `intercambios`
  ADD CONSTRAINT `intercambios_ibfk_1` FOREIGN KEY (`id_libro_ofrecido`) REFERENCES `libros` (`idlibro`),
  ADD CONSTRAINT `intercambios_ibfk_2` FOREIGN KEY (`id_libro_solicitado`) REFERENCES `libros` (`idlibro`),
  ADD CONSTRAINT `intercambios_ibfk_3` FOREIGN KEY (`id_solicitante`) REFERENCES `usuarios` (`idusuario`),
  ADD CONSTRAINT `intercambios_ibfk_4` FOREIGN KEY (`id_propietario`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`idpropietario`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
