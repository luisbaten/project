-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2023 a las 20:26:01
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tms_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int(30) NOT NULL,
  `firstname` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `lastname` varchar(250) COLLATE utf8mb4_bin DEFAULT NULL,
  `contact` int(15) NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_project_approval`
--

CREATE TABLE `client_project_approval` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `project_list_id` int(11) DEFAULT NULL,
  `donation_amount` decimal(10,2) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deposit_photo` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `deposit_date` date DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `client_project_approval`
--

INSERT INTO `client_project_approval` (`id`, `client_id`, `project_list_id`, `donation_amount`, `is_approved`, `approval_date`, `deposit_photo`, `deposit_date`, `bank_name`) VALUES
(41, 5, 5, '100.00', 0, '2023-11-08 23:23:05', '1699485780_donación 1.png', '2023-09-20', 'G&T'),
(42, 5, 5, '100.00', 0, '2023-11-08 23:42:33', '1699486920_donación 1.png', '2023-09-20', 'G&T'),
(43, 6, 6, '250.00', 1, '2023-11-08 23:49:50', '1699487340_donación2.jpeg', '2023-10-31', 'BANRURAL'),
(44, 6, 5, '800.00', 1, '2023-11-09 01:00:01', '', '0000-00-00', 'BANRURAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `investment_list`
--

CREATE TABLE `investment_list` (
  `id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_bin DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `expense_date` date DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `investment_list`
--

INSERT INTO `investment_list` (`id`, `project_id`, `user_id`, `amount`, `description`, `status`, `date_created`, `expense_date`, `imagen`) VALUES
(5, 5, NULL, '500.00', 'Compra de 5 quintales de cemento', NULL, '2023-11-08 22:36:36', '2023-10-20', '1699483020_casa_mal_cond.png'),
(6, 6, NULL, '800.00', 'Compra material de cosntrucci&oacute;n', NULL, '2023-11-08 23:13:26', '2023-10-25', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_list`
--

CREATE TABLE `project_list` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(30) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) NOT NULL,
  `images` text DEFAULT NULL,
  `total_donations` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`, `date_created`, `price`, `images`, `total_donations`) VALUES
(5, 'La dama xux', 'Construcci&oacute;n de vivienda a la se&ntilde;ora Juana, es una madre soltera con dos hijos y su casa est&aacute; en malas condiciones.', 5, '2023-08-15', '2023-12-15', 0, '7', '2023-11-08 16:14:05', '80000.00', '1699481640_laDamaXux.jpeg', '1000.00'),
(6, 'Cosntrucción de vivenda de Astrid', 'Construcci&oacute;n de una vivienda digna para Astrid.', 3, '2023-10-26', '2024-02-26', 0, '', '2023-11-08 16:16:49', '70000.00', '1699481760_Astrid casa det.png', '250.00'),
(7, 'Darío', '						Dar&iacute;o es un ni&ntilde;o que no puede caminar, y necesita intervenci&oacute;n quir&uacute;rgica para mejorar sus condici&oacute;n y como tambi&eacute;n terapias para darle seguimiento a su caso.					', 0, '2023-11-10', '2024-05-10', 0, '7', '2023-11-08 16:21:42', '50000.00', '1699482180_Darío.png', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `send_project`
--

CREATE TABLE `send_project` (
  `id` int(11) NOT NULL,
  `primerNombre` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `segundoNombre` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `primerApellido` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `segundoApellido` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `dpi` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `telefono` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `fotos` text COLLATE utf8mb4_bin DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `send_project`
--

INSERT INTO `send_project` (`id`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `dpi`, `direccion`, `telefono`, `fotos`, `descripcion`, `status`) VALUES
(15, 'Rodrigo', 'Aníbal', 'Pérez', 'Escalante', '1089564723898', 'Aldea Quiquibaj, Cabricán, Quetzaltenango', '56479383', 'uploads/Darío.png', 'Mi hijo tiene problemas para caminar y nuestra condición económica no es favorable, para realizar una operación para tratar su problema.', 1),
(16, 'Carmen', '', 'Ramírez', 'Vasquez', '1389678934677', 'Aldea Duraznales, Río Blancon, San Marcos', '56479383', '', 'Necesito que apoyen a mi hijo que tiene dificultad de hablar.', 2),
(18, 'María', 'Teresa', 'López', 'Méndez', '3456782345607', 'Cabricán, Quetzaltenango', '45372890', 'uploads/casa_mal_cond.png', 'Mi casa se encuentra en malas condiciones.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Gestion Financiera de Blanco ONG', 'amigosblancong@gmail.com', '46980782', 'Río Blanco, San Marcos', '');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES
(1, 'Administrator', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, 'no-image-available.png', '2022-11-26 10:57:04'),
(7, 'Dallana ', 'Escobar', 'dallana@gmail.com', '83b07e8ed45206817916b4f1f6609e3f', 3, 'no-image-available.png', '2023-11-08 06:56:33');


-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `client_project_approval`
--
ALTER TABLE `client_project_approval`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `project_list_id` (`project_list_id`);

--
-- Indices de la tabla `investment_list`
--
ALTER TABLE `investment_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `send_project`
--
ALTER TABLE `send_project`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `client_project_approval`
--
ALTER TABLE `client_project_approval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `investment_list`
--
ALTER TABLE `investment_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `send_project`
--
ALTER TABLE `send_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `client_project_approval`
--
ALTER TABLE `client_project_approval`
  ADD CONSTRAINT `client_project_approval_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `client_project_approval_ibfk_2` FOREIGN KEY (`project_list_id`) REFERENCES `project_list` (`id`);

--
-- Filtros para la tabla `investment_list`
--
ALTER TABLE `investment_list`
  ADD CONSTRAINT `investment_list_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_list` (`id`),
  ADD CONSTRAINT `investment_list_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
