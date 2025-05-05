-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: vm007.db.swarm.test
-- Tiempo de generación: 07-04-2025 a las 10:25:19
-- Versión del servidor: 10.4.28-MariaDB-1:10.4.28+maria~ubu2004
-- Versión de PHP: 8.2.27

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
) 

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

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`idlibro`, `titulo`, `autor`, `genero`, `editorial`, `idioma`, `estado`, `descripcion`, `imagen`, `idpropietario`, `disponible`, `fecha_publicacion`) VALUES
(2, 'ERIK VOGLER 2: Muerte en el balneario', 'Beatriz Osés', 'Misterio y suspenso', 'Edebé', 'Español', 'bueno', 'Erik Vogler viaja a un balneario para relajarse, pero las vacaciones se complican cuando empiezan a ocurrir misteriosas muertes y él debe resolver el caso antes de que sea demasiado tarde.', 'img/erik-vogler-2.jpg', 1, 1, '2025-03-07'),
(3, 'Soldados de Salamina', 'Javier Cercas', 'Histórica', 'Tusquets Editores', 'Español', 'nuevo', 'Hacia el final de la guerra civil se produjo, cerca de la frontera con Francia, un fusilamiento de prisioneros franquistas. Uno de ellos escapó con vida, gracias a un joven soldado republicano, y se pudo refugiar en el bosque. Se trataba de Rafael Sánchez Mazas, poeta, fundador de Falange y futuro ministro de Franco.', 'img/soldados-de-salamina.png', 2, 1, '2025-03-07'),
(4, 'La sombra del viento', 'Carlos Ruíz Zafón', 'Filosofía', 'Planeta', 'Español', 'bueno', 'La trama se desenvuelve en una embrujada Barcelona donde, junto a su nuevo amigo Fermín, intentará descubrir la verdad que envuelve a un enigmático ser que a toda costa intenta enterrar el pasado de Julián Carax. ​ Una novela de suspenso que intenta mezclar lo real con la fantasía, el misterio con el amor.', 'img/la-sombra-del-viento.jpeg', 2, 1, '2025-03-07'),
(5, 'La isla de la mujer dormida', 'Arturo Pérez-Reverte', 'Histórica', 'Alfaguara', 'Español', 'bueno', 'En plena Guerra Civil Española, un marino se embarca en una peligrosa misión en el mar Egeo, donde el amor y la traición acechan entre las olas.', 'img/la-isla-de-la-mujer-dormida.jpg', 1, 1, '2025-03-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `correo` varchar(256) NOT NULL,
  `contraseña` varchar(256) NOT NULL,
  `tipo` enum('admin','normal') NOT NULL DEFAULT 'normal'
) ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `correo`, `contraseña`, `tipo`) VALUES
(1, 'Usuario1', 'carlocle@ucm.es', '$2y$10$rg/LXwGMYo2Bxvp.9s9/o.MOCjqT483tVzQTsGSBC4H00X0Kk.fDG', 'normal'),
(2, 'Usuario2', 'ismaluca@ucm.es', '$2y$10$4LetN37hfEKv0ZE50/2DIukCE09sf.v.g9nmVQmhuxmHMkoldeh..', 'normal'),
(3, 'Admin1', 'alvamo14@ucm.es', '$2y$10$sG2si0rMtkXHFHWR5NSXh.hsdklqSNwNsuJWwXExKxMdkKxgzGN8q', 'admin');

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
  MODIFY `idlibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
