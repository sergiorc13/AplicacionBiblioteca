-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2023 a las 19:21:45
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `ID` int(11) NOT NULL,
  `ISBN` varchar(255) DEFAULT NULL,
  `Titulo` varchar(255) DEFAULT NULL,
  `Autor` varchar(255) DEFAULT NULL,
  `Editorial` varchar(255) DEFAULT NULL,
  `SINOPSIS` varchar(1000) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `Borrado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ID`, `ISBN`, `Titulo`, `Autor`, `Editorial`, `SINOPSIS`, `URL`, `Borrado`) VALUES
(3, '978-8466324799', 'Cien anos de soledad', 'Gabriel Garcia Marquez', 'Editorial Sudamericana', 'Una saga multigeneracional que narra la historia de la familia Buendia en el ficticio pueblo de Macondo, explorando temas como la soledad, el amor y la busqueda de identidad.', 'One_Hundred_Years_of_Solitude.jpg', 0),
(4, '978-0141983479', '1984', 'George Orwell', 'Signet Classic', 'Una distopia que presenta un mundo totalitario gobernado por el Partido y su lider, Big Brother. Explora la manipulacion de la verdad, la vigilancia extrema y la resistencia individual.', '1984.jpg', 0),
(6, '978-0457295878', 'El Hobbit', 'J.R.R. Tolkien', 'Minotauro', 'Una novela de fantasia que sigue las aventuras del hobbit Bilbo Bolson mientras se embarca en una mision epica para recuperar un tesoro guardado por el dragon Smaug.', 'El_hobbit.jpg', 0),
(7, '978-0143105959', 'Orgullo y prejuicio', 'Jane Austen', 'Penguin Classics', 'Una historia de amor y clase social que sigue la relacion entre Elizabeth Bennet y el senor Darcy en la Inglaterra del siglo XIX, explorando temas de orgullo, prejuicio y cambio social.', 'pride-and-prejudice.jpg', 0),
(8, '978-0061120080', 'Matar un ruisenor', 'Harper Lee', 'Vintage Espanol', 'Ambientada en el sur de Estados Unidos durante la Gran Depresion, aborda temas de injusticia racial a traves de la historia de un abogado que defiende a un hombre negro acusado de violar a una mujer blanca.', 'To_Kill_a_Mockingbird.jpg', 0),
(14, '978-0307941700', 'Crimen y castigo', 'Fiodor Dostoievski', 'Vintage Espanol', 'Una obra maestra de la literatura rusa que sigue la vida de Rodion Raskolnikov, un estudiante que comete un asesinato y enfrenta las consecuencias psicologicas y morales.', 'crime-and-punishment.jpg', 0),
(22, '978-0553382563', 'El Gran Gatsby', 'F. Scott Fitzgerald', 'Vintage', 'Ambientada en la decada de 1920, explora la decadencia del sueno americano a traves de la historia del enigmatico Jay Gatsby y su obsesion con la adinerada Daisy Buchanan.', 'The_Great_Gatsby.jpg', 0),
(23, '978-0061122411', 'El guardian entre el centeno', 'J.D. Salinger', 'Little, Brown and Company', 'Narrada por el adolescente Holden Caulfield, aborda temas de alienacion y desilusion mientras explora la transicion a la adultez en la sociedad estadounidense.\r\n\r\n', 'The_Catcher_in_the_Rye.jpg', 0),
(24, '978-0307279721', 'El camino', 'Cormac McCarthy', 'Vintage', 'Una novela que sigue a un padre y su hijo mientras atraviesan un paisaje postapocaliptico, explorando la lucha por la supervivencia y la preservacion de la humanidad.', 'the_road.jpg', 0),
(25, '978-0345803504', 'Los hombres que no amaban a las mujeres', 'Stieg Larsson', 'Vintage', 'Primer libro de la trilogia \"Millennium\", es un thriller que sigue a un periodista y a una hacker mientras investigan la desaparicion de una joven, revelando oscuros secretos familiares y corrupcion.\r\n\r\n\r\n\r\n\r\n', 'Los_hombres_que_no_amaban_mujeres.jpg', 0),
(33, 'zzzzzzzzzzz', 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz', 'zzzzzzzzzzzzz', 'zzzzzzzzzzz', 'zzzzzzzzzzzzzz', 'biblioteca3.jpg', 0),
(34, 'ass', 'ssssda', 'dddddddddddddddd', 'ddd', 'dddddddddddddddddd', '4.jpg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `ID` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Libro` int(11) DEFAULT NULL,
  `Inicio_Prestamo` datetime DEFAULT NULL,
  `Fin_Prestamo` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`ID`, `ID_Usuario`, `ID_Libro`, `Inicio_Prestamo`, `Fin_Prestamo`) VALUES
(37, 19, 14, '2023-11-16 14:03:54', '2023-12-16 14:03:54'),
(38, 19, 22, '2023-11-17 10:33:45', '2023-12-17 10:33:45'),
(39, 22, 22, '2023-11-19 12:15:06', '2023-12-19 12:15:06'),
(40, 22, 24, '2023-11-19 12:15:10', '2023-12-19 12:15:10'),
(42, 22, 6, '2023-11-19 12:15:17', '2023-12-19 12:15:17'),
(43, 19, 8, '2023-11-19 12:35:29', '2023-12-19 12:35:29'),
(47, 19, 24, '2023-11-19 12:41:01', '2023-12-19 12:41:01'),
(48, 19, 3, '2023-11-19 12:52:17', '2023-11-20 12:52:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Apellido2` varchar(255) DEFAULT NULL,
  `Nombre_Usuario` varchar(255) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `Correo_Electronico` varchar(255) DEFAULT NULL,
  `Rol` enum('ADMIN','LECTOR') DEFAULT 'LECTOR',
  `Borrado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Apellido`, `Apellido2`, `Nombre_Usuario`, `Contrasena`, `Correo_Electronico`, `Rol`, `Borrado`) VALUES
(19, 'Sergio', 'Rodriguez', 'Costa', 'Sergio', '$2y$10$a9UD3MiPoQgzhRzBnLJNYuqaQvjgz2DCd9agEsIQjJi1AkmccN06u', 'sergiorodriguezcosta10@gmail.com', 'ADMIN', 0),
(20, 'dario', 'quinde', 'quinonez', 'dario', '$2y$10$NcKO3G2ht5J4AMEhYwPiJOPJgBbW/F5AnTQdG.N06kutZ5.ACRCjq', 'dario2003@gmail.com', 'LECTOR', 0),
(21, 'Loco', 'Loctron', 'Locotrin', 'Loco2002', '$2y$10$gAvaQTCqy8M/woFQSZ6l9uRYt6zcUlbveBtsIk0o7cE1cR4mYC/s2', 'loco@gmail.com', 'LECTOR', 0),
(22, 'Gonzalo', 'Amo', 'Martinez', 'gonzalo2004', '$2y$10$WaMQfaXj1PuzLTsnyfQkqe5y5uMswkJGXo3JnKvTCcfbSx9Ph9BK6', 'gonzalo04@gmail.com', 'LECTOR', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Libro` (`ID_Libro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`),
  ADD UNIQUE KEY `Correo_Electronico` (`Correo_Electronico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `Prestamo_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `Prestamo_ibfk_2` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
