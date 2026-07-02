-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2026 a las 12:32:20
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
-- Base de datos: `biblioteca-profe`
--
CREATE DATABASE IF NOT EXISTS `biblioteca-profe` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `biblioteca-profe`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `username`, `password_hash`, `nombre`, `apellidos`, `email`, `rol`, `fecha_alta`) VALUES
(1, 'admin', '$2y$10$Cn8XOEt695xBDEPXpquUre/t/qJtmzgsUn.i9ARVeCP2prIPcEgiK', 'Administrador', 'Biblioteca', 'admin@biblioteca.com', 'Administrador', '2026-07-01 11:54:33'),
(2, 'Rugsoft', '$2y$10$rbU0Nz1MaFvo6aMcYAjitO80GN7qHy2BU3PlymkKlw981iNSinUqm', 'César', 'Casas Insa', 'futuroelectronico@gmail.com', 'Bibliotecario', '2026-07-01 12:03:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id_libro` int(11) NOT NULL,
  `isbn` varchar(35) NOT NULL,
  `titulo` varchar(75) NOT NULL,
  `autor` varchar(75) NOT NULL,
  `año` int(4) NOT NULL,
  `genero` varchar(30) NOT NULL,
  `paginas` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id_libro`, `isbn`, `titulo`, `autor`, `año`, `genero`, `paginas`) VALUES
(1, 'ES54789614', 'El Quijote', 'Miguel de Cervantes', 1605, 'Novela', 863),
(2, 'ES39218405', '1984', 'George Orwell', 1949, 'Ciencia ficción', 328),
(3, 'ES81047562', 'Clean Code', 'Robert C. Martin', 2008, 'Programación', 464),
(4, 'ES27593148', 'Rayuela', 'Julio Cortázar', 1963, 'Novela', 736),
(5, 'ES64108293', 'Aprendiendo PHP', 'Ana López', 2022, 'Programación', 290),
(6, 'ES48392015', 'Breve historia del tiempo', 'Stephen Hawking', 1988, 'Ciencia', 256),
(7, 'ES19582634', 'El imperio final', 'Brandon Sanderson', 2006, 'Fantasia', 603),
(8, 'ES73049185', 'El Señor de los Anillos', 'J.R.R. Tolkien', 1954, 'Fantasía', 1178),
(9, 'ES52617490', 'Cien años de soledad', 'Gabriel García Márquez', 1967, 'Novela', 471),
(10, 'ES90483127', 'El programador pragmático', 'Andrew Hunt', 1999, 'Programación', 358),
(11, 'ES31852964', 'Un mundo feliz', 'Aldous Huxley', 1932, 'Ciencia ficción', 256),
(12, 'ES67205419', 'Crónica de una muerte anunciada', 'Gabriel García Márquez', 1981, 'Novela', 128),
(13, 'ES84931076', 'JavaScript: The Good Parts', 'Douglas Crockford', 2008, 'Programación', 185),
(14, 'ES42168530', 'Fahrenheit 451', 'Ray Bradbury', 1953, 'Ciencia ficción', 192),
(16, 'ES79304251', 'Sapiens', 'Yuval Noah Harari', 2011, 'Historia', 496),
(17, 'ES26851739', 'Design Patterns', 'Erich Gamma', 1994, 'Programación', 416),
(18, 'ES25478523', 'Donde los árboles cantan', 'Laura Gallego', 2025, 'Drama', 478),
(19, 'ES12354789', 'Mi mamá me mima', 'Don Pipon', 1978, 'Infantil', 125),
(20, 'ES14785632', 'El despertar de los Heroes', 'Robert Jordan', 1998, 'Fantasia', 785),
(21, 'ES25478963', 'La maja desnuda', 'Aitor Tilla', 1758, 'Comedia', 75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id_prestamo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `devuelto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id_prestamo`, `id_usuario`, `id_libro`, `fecha_prestamo`, `fecha_devolucion`, `devuelto`) VALUES
(1, 1, 5, '2026-03-01', '2026-03-15', 1),
(2, 2, 8, '2026-03-05', '2026-06-29', 1),
(3, 3, 2, '2026-03-10', '2026-06-30', 1),
(4, 1, 10, '2026-03-12', '2026-03-25', 1),
(5, 5, 12, '2026-06-29', '2026-06-30', 1),
(6, 5, 8, '2026-06-29', NULL, 0),
(7, 7, 19, '2026-06-30', NULL, 0),
(8, 7, 21, '2026-06-30', '2026-07-01', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(55) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_alta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `password_hash`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_alta`) VALUES
(1, NULL, '', 'Laura', 'Martínez Ruiz', 'laura.martinez@email.com', '633212121', '2026-01-10'),
(2, NULL, '', 'Carlos', 'Gómez Pérez', 'carlos.gomez@email.com', '600333444', '2026-01-15'),
(3, NULL, '', 'Marta', 'Sánchez López', 'marta.sanchez@email.com', '600555666', '2026-02-01'),
(4, NULL, '', 'David', 'Navarro Gil', 'david.navarro@email.com', '600777888', '2026-02-20'),
(5, NULL, '', 'César', 'Casas Insa', 'futuroelectronico@gmail.com', '655234785', '2026-06-29'),
(7, NULL, '', 'David', 'Cerbello Español', 'david@email.com', '699452123', '2026-06-30'),
(8, NULL, '', 'Jorge', 'Casas Moya', 'jorge@gmail.com', '633147632', '2026-06-30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
