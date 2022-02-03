-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-06-2021 a las 18:04:20
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ab_model`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `Usuario` varchar(20) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `Correo` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `ApellidoP` varchar(50) NOT NULL,
  `ApellidoM` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

DROP TABLE IF EXISTS `historial`;
CREATE TABLE IF NOT EXISTS `historial` (
  `CorreoCliente` varchar(50) NOT NULL,
  `Fecha` date NOT NULL,
  `HoraEntrada` time NOT NULL,
  `HoraSalida` time NOT NULL,
  KEY `CorreoCliente` (`CorreoCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

DROP TABLE IF EXISTS `mesa`;
CREATE TABLE IF NOT EXISTS `mesa` (
  `NumMesa` int(11) NOT NULL,
  `Clave` varchar(20) NOT NULL,
  `OcupacionCliente` varchar(50) DEFAULT NULL,
  `AtencionMesero` varchar(50) NOT NULL,
  PRIMARY KEY (`NumMesa`),
  UNIQUE KEY `Clave` (`Clave`),
  KEY `OcupacionCliente` (`OcupacionCliente`),
  KEY `AtencionMesero` (`AtencionMesero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesero`
--

DROP TABLE IF EXISTS `mesero`;
CREATE TABLE IF NOT EXISTS `mesero` (
  `Correo` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `ApellidoP` varchar(50) NOT NULL,
  `ApellidoM` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Correo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `ID` int(11) NOT NULL,
  `Cliente` varchar(50) NOT NULL,
  `Mesa` int(11) NOT NULL,
  `Platillo` varchar(20) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  KEY `Mesa` (`Mesa`),
  KEY `Platillo` (`Platillo`),
  KEY `Cliente` (`Cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillo`
--

DROP TABLE IF EXISTS `platillo`;
CREATE TABLE IF NOT EXISTS `platillo` (
  `ID_platillo` varchar(10) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` text NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Existencia` int(11) NOT NULL,
  `ImagenPlatillo` varchar(20) NOT NULL,
  PRIMARY KEY (`ID_platillo`),
  UNIQUE KEY `ImagenPlatillo` (`ImagenPlatillo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `platillo`
--

INSERT INTO `platillo` (`ID_platillo`, `Nombre`, `Descripcion`, `Precio`, `Existencia`, `ImagenPlatillo`) VALUES
('1', 'Hamburguesa sencilla de res', 'Hamburguesa sencilla de res', '45', 10, 'hamsencilla.jpg'),
('11', 'Hamburguesa doble carne de res', 'Hamburguesa doble carne de res', '65', 10, 'hamdoble.jpg'),
('111', 'Papas a la Fancesa con queso ', 'Papas a la Fancesa con queso ', '30', 10, 'papasqueso.jpg'),
('112', 'Papas a la Fancesa con queso y carne', 'Papas a la Fancesa con queso y carne', '45', 10, 'papasquesoycarne.jpg'),
('12', 'Hamburguesa sencilla de pollo', 'Hamburguesa sencilla de pollo', '40', 10, 'hampollo.jpg'),
('14', 'Pizza tamaño familiar de peperoni', 'Pizza tamaño familiar de peperoni', '99', 10, 'pizza peperoni.jpg'),
('15', 'Pizza tamaño familiar de carnes', 'Pizza tamaño familiar de carnes', '120', 10, 'pizza carnes.jpg'),
('16', 'Pizza tamaño familiar Hawaiana', 'Pizza tamaño familiar Hawaiana', '99', 10, 'pizzahawai.jpg'),
('17', 'Hot Dog Sencillo', 'Hot Dog Sencillo', '20', 10, 'hotdog.jpg'),
('18', 'Hot Dog Supremo', 'Hot Dog Supremo', '30', 10, 'hotsupremo.jpg'),
('19', 'Papas a la Fancesa sencillas', 'Papas a la Fancesa sencillas', '20', 10, 'papas.jpg'),
('2', 'Coca Cola', 'Coca Cola 350ml', '20', 30, 'coca.png'),
('21', 'Sprite', 'Sprite 350ml', '20', 20, 'sprite.jpg'),
('22', 'Manzanita', 'Manzanita Mundet 350ml ', '20', 10, 'mundet.jpg'),
('23', 'Agua de Jamaica', 'Agua de Jamaica 500ml', '20', 20, 'aguadejamaica.jpg'),
('24', 'Limonada Natural 500ml', 'Limonada Natural 500ml', '25', 20, 'limonada.jpg'),
('25', 'Cerveza Corona 355ml', 'Cerveza Corona 355ml', '30', 20, 'cervcorona.jpg'),
('26', 'Cerveza Modelo 355ml', 'Cerveza Modelo 355ml', '30', 20, 'cervmodelo.jpg'),
('27', 'Cerveza Ultra 355ml', 'Cerveza Ultra 355ml', '30', 20, 'cervultra.jpg'),
('3', 'Helado de chocolate', 'Helado de chocolate', '30', 10, 'helado.jpg'),
('31', 'Volcan de chocolate', 'Volcan de chocolate', '35', 10, 'volcan.jpg'),
('33', 'Rebanada de tarta de frutos rojos', 'Rebanada de tarta de frutos rojos', '35', 20, 'tarta.jpg');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`CorreoCliente`) REFERENCES `cliente` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`OcupacionCliente`) REFERENCES `cliente` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mesa_ibfk_2` FOREIGN KEY (`AtencionMesero`) REFERENCES `mesero` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`Mesa`) REFERENCES `mesa` (`NumMesa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`Platillo`) REFERENCES `platillo` (`ID_platillo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`Cliente`) REFERENCES `cliente` (`Correo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
