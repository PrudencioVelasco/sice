-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 18-02-2020 a las 03:39:05
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbsii`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(120) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `uri`, `description`) VALUES
(66, 'Admin/*', 'Admin'),
(67, 'Tutor/*', 'Tutores'),
(68, 'Alumno/*', 'Alumnos'),
(69, 'Profesor/*', 'Profesores'),
(70, 'Horario/*', 'Horario'),
(71, 'aAdmin/*', 'Alumno Normal'),
(72, 'aAlumno/*', 'Alumno Normal'),
(73, 'pAdmin/*', 'Profesor Normal'),
(74, 'pGrupo/*', 'Profesor Normal'),
(75, 'pProfesor/*', 'Profesor Normal'),
(76, 'User/*', 'Usuario'),
(77, 'Escuela/*', 'Escuela'),
(78, 'Catalogo/*', 'Catalogo'),
(80, 'Permiso/*', 'Permisos'),
(81, 'Rol/*', 'Roles'),
(82, 'Promover/*', 'Promover Alumnos'),
(83, 'EstadoCuenta/*', 'Estado de Cuenta'),
(84, 'CicloEscolar/*', 'Ciclo Escolar'),
(85, 'Grupo/*', 'Grupo Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_rol`
--

CREATE TABLE `permission_rol` (
  `id` int(10) NOT NULL,
  `permission_id` int(10) NOT NULL,
  `rol_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permission_rol`
--

INSERT INTO `permission_rol` (`id`, `permission_id`, `rol_id`) VALUES
(300, 71, 12),
(301, 72, 12),
(302, 73, 10),
(303, 74, 10),
(304, 75, 10),
(312, 66, 14),
(313, 67, 14),
(314, 68, 14),
(315, 69, 14),
(316, 70, 14),
(317, 77, 14),
(318, 78, 14),
(319, 80, 14),
(320, 81, 14),
(321, 66, 13),
(322, 67, 13),
(323, 68, 13),
(324, 69, 13),
(325, 70, 13),
(326, 76, 13),
(327, 77, 13),
(328, 78, 13),
(329, 82, 13),
(330, 83, 13),
(331, 84, 13),
(332, 85, 13),
(333, 84, 14),
(334, 85, 14),
(335, 76, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(10) NOT NULL,
  `rol` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`) VALUES
(10, 'MAESTROS'),
(11, 'TUTOR'),
(12, 'ALUMNOS'),
(13, 'DIRECTOR'),
(14, 'WEBMASTER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblalumno`
--

CREATE TABLE `tblalumno` (
  `idalumno` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `matricula` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellidop` varchar(150) NOT NULL,
  `apellidom` varchar(150) NOT NULL,
  `fechanacimiento` date NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `sexo` tinyint(1) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `password` varchar(150) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblalumno`
--

INSERT INTO `tblalumno` (`idalumno`, `idplantel`, `matricula`, `nombre`, `apellidop`, `apellidom`, `fechanacimiento`, `foto`, `sexo`, `correo`, `password`, `idusuario`, `fecharegistro`) VALUES
(1, 1, '09730200', 'CLARA', 'VELASCO', 'PALACIOS', '2020-02-14', '2020-02-15044732.jpg', 0, 'prudencio.vepa@gmail.com', '$2y$10$NUjftI4gM/nnDs3ycPAyXuqwpucr6UYAwvrS9JlEPFwhzZx0/ifRq', 45, '2020-02-15 10:34:28'),
(2, 1, '09730199', 'PRUDENCIO', 'VELASCO', 'PALACIOS', '2020-02-14', '', 0, 'admin@admin.com', '$2y$10$tJ.SNdFw7CWiUq5DHNSGyep.ddkRL7tOqz0o2lnAm/RWrRM7NhuZO', 45, '2020-02-15 10:35:41'),
(3, 1, '2342', 'SSS', 'SS', 'S', '0000-00-00', '', 1, 'admin@admin.com', '$2y$10$d5MI3DKlGlDEkdn.Eykge.fdqTtAYDtNgCU8mVGgnoVaWIKjJAq1e', 45, '0000-00-00 00:00:00'),
(4, 1, '2342', '1', '1', '1', '0000-00-00', '', 0, 'admin@admin.com', '$2y$10$GOoaWhyXWtMILgGFUrTUFOXi5do11Gdt78w1q4S2gxGOfAOmiax3W', 45, '0000-00-00 00:00:00'),
(5, 1, '3322', '222', '22', 'DASD', '0000-00-00', '', 1, 'admin@admin.com', '$2y$10$siN7n9sEMjB9HIiWssSu4eUc5DB3p3Kwut5S.L4gXlXjZHK/NqKIy', 45, '0000-00-00 00:00:00'),
(6, 1, '23', '233', '23', '23', '1990-04-28', '', 0, 'admin@admin.com', '$2y$10$1y2rkFUnTqSc2omCiHJpAubFmepaFrkuDsPPWRTtsVzlyBMvsXFc.', 45, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblalumno_grupo`
--

CREATE TABLE `tblalumno_grupo` (
  `idalumnogrupo` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblalumno_grupo`
--

INSERT INTO `tblalumno_grupo` (`idalumnogrupo`, `idalumno`, `idperiodo`, `idgrupo`, `activo`) VALUES
(20, 1, 1, 1, 1),
(21, 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblamotizacion`
--

CREATE TABLE `tblamotizacion` (
  `idamortizacion` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `idperiodopago` int(11) NOT NULL,
  `descuento` decimal(8,2) NOT NULL,
  `pagado` tinyint(1) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblamotizacion`
--

INSERT INTO `tblamotizacion` (`idamortizacion`, `idalumno`, `idperiodo`, `idperiodopago`, `descuento`, `pagado`, `idusuario`, `fecharegistro`) VALUES
(1, 1, 1, 1, '500.00', 1, 45, '2020-02-16 00:00:00'),
(2, 1, 1, 2, '500.00', 1, 45, '2020-02-16 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblasistencia`
--

CREATE TABLE `tblasistencia` (
  `idasistencia` int(11) NOT NULL,
  `idhorario` int(11) NOT NULL,
  `idhorariodetalle` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idmotivo` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblasistencia`
--

INSERT INTO `tblasistencia` (`idasistencia`, `idhorario`, `idhorariodetalle`, `idalumno`, `idmotivo`, `fecha`) VALUES
(36, 10, 28, 1, 1, '2020-02-10'),
(37, 10, 28, 2, 1, '2020-02-10'),
(38, 10, 31, 1, 1, '2020-02-10'),
(39, 10, 31, 2, 2, '2020-02-10'),
(40, 10, 33, 1, 1, '2020-02-10'),
(41, 10, 33, 2, 1, '2020-02-10'),
(42, 10, 33, 1, 2, '2020-02-11'),
(43, 10, 33, 2, 4, '2020-02-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcalificacion`
--

CREATE TABLE `tblcalificacion` (
  `idcalificacion` int(11) NOT NULL,
  `idunidad` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `idhorario` int(11) NOT NULL,
  `idhorariodetalle` int(11) NOT NULL,
  `calificacion` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblcalificacion`
--

INSERT INTO `tblcalificacion` (`idcalificacion`, `idunidad`, `idalumno`, `idhorario`, `idhorariodetalle`, `calificacion`) VALUES
(17, 1, 1, 10, 33, '10.00'),
(18, 1, 2, 10, 33, '9.00'),
(19, 2, 1, 10, 33, '9.87'),
(20, 2, 2, 10, 33, '10.00'),
(21, 3, 1, 10, 33, '10.00'),
(22, 3, 2, 10, 33, '7.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldescanzo`
--

CREATE TABLE `tbldescanzo` (
  `iddescanzo` int(11) NOT NULL,
  `titulo` varchar(250) NOT NULL,
  `idhorario` int(11) NOT NULL,
  `horainicial` time NOT NULL,
  `horafinal` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbldescanzo`
--

INSERT INTO `tbldescanzo` (`iddescanzo`, `titulo`, `idhorario`, `horainicial`, `horafinal`) VALUES
(2, 'RECESO', 10, '11:20:00', '11:50:00'),
(3, 'RECESO', 11, '08:50:00', '09:50:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldetalle_pago`
--

CREATE TABLE `tbldetalle_pago` (
  `iddetallepago` int(11) NOT NULL,
  `idestadocuenta` int(11) NOT NULL,
  `idformapago` int(11) NOT NULL,
  `descuento` decimal(8,2) NOT NULL,
  `autorizacion` int(11) NOT NULL,
  `fechapago` datetime NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbldetalle_pago`
--

INSERT INTO `tbldetalle_pago` (`iddetallepago`, `idestadocuenta`, `idformapago`, `descuento`, `autorizacion`, `fechapago`, `idusuario`, `fecharegistro`) VALUES
(1, 8, 1, '500.00', 0, '2020-02-17 11:03:53', 45, '2020-02-17 11:03:53'),
(2, 9, 2, '500.00', 12, '2020-02-17 11:05:04', 45, '2020-02-17 11:05:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbldia`
--

CREATE TABLE `tbldia` (
  `iddia` int(11) NOT NULL,
  `nombredia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbldia`
--

INSERT INTO `tbldia` (`iddia`, `nombredia`) VALUES
(1, 'LUNES'),
(2, 'MARTES'),
(3, 'MIERCOLES'),
(4, 'JUEVES'),
(5, 'VIERNES'),
(6, 'SABADO'),
(7, 'DOMINGO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblestado_cuenta`
--

CREATE TABLE `tblestado_cuenta` (
  `idestadocuenta` int(11) NOT NULL,
  `idamortizacion` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL,
  `descuento` decimal(8,2) NOT NULL,
  `fechapago` datetime NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblestado_cuenta`
--

INSERT INTO `tblestado_cuenta` (`idestadocuenta`, `idamortizacion`, `idperiodo`, `idalumno`, `descuento`, `fechapago`, `idusuario`, `fecharegistro`) VALUES
(8, 1, 1, 1, '500.00', '2020-02-17 11:03:53', 45, '2020-02-17 11:03:53'),
(9, 2, 1, 1, '500.00', '2020-02-17 11:05:04', 45, '2020-02-17 11:05:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblexamen`
--

CREATE TABLE `tblexamen` (
  `idexamen` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblexamen`
--

INSERT INTO `tblexamen` (`idexamen`, `titulo`) VALUES
(1, 'UNIDAD 1'),
(2, 'UNIDAD 2'),
(3, 'UNIDAD 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblgrupo`
--

CREATE TABLE `tblgrupo` (
  `idgrupo` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `idnivelestudio` int(11) NOT NULL,
  `idturno` int(11) NOT NULL,
  `nombregrupo` varchar(150) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblgrupo`
--

INSERT INTO `tblgrupo` (`idgrupo`, `idplantel`, `idnivelestudio`, `idturno`, `nombregrupo`, `idusuario`, `fecharegistro`) VALUES
(1, 1, 1, 1, 'A', 45, '2020-02-17 12:07:22'),
(2, 1, 2, 1, 'A', 45, '0000-00-00 00:00:00'),
(3, 1, 3, 1, 'A', 45, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblhorario`
--

CREATE TABLE `tblhorario` (
  `idhorario` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `idperiodo` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblhorario`
--

INSERT INTO `tblhorario` (`idhorario`, `idplantel`, `idperiodo`, `idgrupo`, `activo`) VALUES
(10, 1, 1, 1, 1),
(11, 1, 1, 2, 1),
(12, 1, 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblhorario_detalle`
--

CREATE TABLE `tblhorario_detalle` (
  `idhorariodetalle` int(11) NOT NULL,
  `idhorario` int(11) NOT NULL,
  `idmateria` int(11) NOT NULL,
  `iddia` int(11) NOT NULL,
  `horainicial` time NOT NULL,
  `horafinal` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblhorario_detalle`
--

INSERT INTO `tblhorario_detalle` (`idhorariodetalle`, `idhorario`, `idmateria`, `iddia`, `horainicial`, `horafinal`) VALUES
(28, 10, 15, 1, '08:00:00', '08:50:00'),
(29, 10, 14, 1, '08:50:00', '09:40:00'),
(30, 10, 13, 1, '09:40:00', '10:30:00'),
(31, 10, 12, 1, '10:30:00', '11:20:00'),
(32, 10, 22, 1, '11:50:00', '12:40:00'),
(33, 10, 16, 1, '12:40:00', '13:30:00'),
(34, 10, 21, 1, '13:30:00', '14:00:00'),
(35, 10, 12, 2, '08:00:00', '08:50:00'),
(36, 10, 17, 2, '08:50:00', '09:40:00'),
(37, 10, 13, 2, '09:40:00', '10:30:00'),
(38, 10, 12, 2, '10:30:00', '11:20:00'),
(39, 10, 18, 2, '11:50:00', '12:40:00'),
(40, 10, 19, 2, '12:30:00', '13:30:00'),
(41, 10, 20, 2, '13:30:00', '14:00:00'),
(42, 10, 14, 3, '08:00:00', '08:50:00'),
(43, 10, 14, 3, '08:50:00', '09:40:00'),
(44, 10, 12, 3, '10:30:00', '11:20:00'),
(45, 10, 22, 3, '11:50:00', '12:40:00'),
(46, 10, 17, 3, '12:40:00', '13:30:00'),
(47, 10, 17, 3, '13:30:00', '14:00:00'),
(48, 10, 22, 4, '08:00:00', '08:50:00'),
(49, 10, 13, 3, '09:40:00', '10:30:00'),
(50, 10, 17, 4, '08:50:00', '09:40:00'),
(51, 10, 13, 4, '09:40:00', '10:30:00'),
(52, 10, 12, 4, '10:30:00', '11:20:00'),
(53, 10, 18, 4, '11:50:00', '12:40:00'),
(54, 10, 20, 4, '12:40:00', '13:30:00'),
(55, 10, 20, 4, '13:30:00', '14:00:00'),
(56, 10, 14, 5, '08:00:00', '08:50:00'),
(57, 10, 14, 5, '08:50:00', '09:40:00'),
(58, 10, 13, 5, '09:40:00', '10:30:00'),
(59, 10, 12, 5, '10:30:00', '12:40:00'),
(60, 10, 22, 5, '11:50:00', '12:40:00'),
(61, 10, 18, 5, '12:40:00', '13:30:00'),
(62, 10, 21, 5, '13:30:00', '14:00:00'),
(63, 11, 12, 1, '08:00:00', '08:50:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblinstitucion`
--

CREATE TABLE `tblinstitucion` (
  `idinstitucion` int(11) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `nombreinstitucion` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `director` varchar(140) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblinstitucion`
--

INSERT INTO `tblinstitucion` (`idinstitucion`, `clave`, `nombreinstitucion`, `direccion`, `director`, `telefono`, `logo`) VALUES
(1, '', 'ESCUELA PRIMARIA PRIVADA', '', '', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblmateria`
--

CREATE TABLE `tblmateria` (
  `idmateria` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `nombreclase` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblmateria`
--

INSERT INTO `tblmateria` (`idmateria`, `idplantel`, `nombreclase`) VALUES
(1, 1, 'MATEMATICA 1'),
(2, 1, 'ESPAÑOL 1'),
(3, 1, 'BIOLOGIA'),
(4, 1, 'GEOGRAFIA DE MEXICO Y EL MUNDO'),
(5, 1, 'ORIENTACION Y TUTORIA 1'),
(6, 1, 'INGLES 1'),
(7, 1, 'ASIGNATURA ESTATAL'),
(8, 1, 'ARTES'),
(9, 1, 'EDUCACION FISICA 1'),
(10, 1, 'TENOLOGIA 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblmes`
--

CREATE TABLE `tblmes` (
  `idmes` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `nombremes` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblmes`
--

INSERT INTO `tblmes` (`idmes`, `numero`, `nombremes`) VALUES
(1, 1, 'ENERO'),
(2, 2, 'FEBRERO'),
(3, 3, 'MARZO'),
(4, 4, 'ABRIL'),
(5, 5, 'MAYO'),
(6, 6, 'JUNIO'),
(7, 7, 'JULIO'),
(8, 8, 'AGOSTO'),
(9, 9, 'SEPTIEMBRE'),
(10, 10, 'OCTUBRE'),
(11, 11, 'NOVIEMBRE'),
(12, 12, 'DICIEMBRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblmotivo_asistencia`
--

CREATE TABLE `tblmotivo_asistencia` (
  `idmotivo` int(11) NOT NULL,
  `nombremotivo` varchar(120) NOT NULL,
  `abreviatura` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblmotivo_asistencia`
--

INSERT INTO `tblmotivo_asistencia` (`idmotivo`, `nombremotivo`, `abreviatura`) VALUES
(1, 'ASISTENCIA', 'A'),
(2, 'RETARDO', 'R'),
(3, 'PERMISO', 'P'),
(4, 'FALTA', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblnivelestudio`
--

CREATE TABLE `tblnivelestudio` (
  `idnivelestudio` int(11) NOT NULL,
  `nombrenivel` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblnivelestudio`
--

INSERT INTO `tblnivelestudio` (`idnivelestudio`, `nombrenivel`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblperiodo`
--

CREATE TABLE `tblperiodo` (
  `idperiodo` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `idmesinicio` int(11) NOT NULL,
  `idyearinicio` int(11) NOT NULL,
  `idmesfin` int(11) NOT NULL,
  `idyearfin` int(11) NOT NULL,
  `activo` tinyint(4) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblperiodo`
--

INSERT INTO `tblperiodo` (`idperiodo`, `idplantel`, `idmesinicio`, `idyearinicio`, `idmesfin`, `idyearfin`, `activo`, `idusuario`, `fecharegistro`) VALUES
(1, 1, 1, 1, 8, 1, 1, 45, '2020-02-16 16:53:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblperiodo_pago`
--

CREATE TABLE `tblperiodo_pago` (
  `idperiodopago` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblperiodo_pago`
--

INSERT INTO `tblperiodo_pago` (`idperiodopago`, `mes`, `year`, `activo`, `idusuario`, `fecharegistro`) VALUES
(1, 1, 2020, 1, 45, '2020-02-16 00:00:00'),
(2, 2, 2020, 1, 45, '2020-02-16 00:00:00'),
(3, 3, 2020, 1, 45, '2020-02-16 00:00:00'),
(4, 4, 2020, 1, 45, '2020-02-16 00:00:00'),
(5, 5, 2020, 1, 45, '2020-02-16 00:00:00'),
(6, 6, 2020, 1, 45, '2020-02-16 00:00:00'),
(7, 7, 2020, 1, 45, '2020-02-16 00:00:00'),
(8, 8, 2020, 1, 45, '2020-02-16 00:00:00'),
(9, 9, 2020, 1, 45, '2020-02-16 00:00:00'),
(10, 10, 2020, 1, 45, '2020-02-16 00:00:00'),
(11, 11, 2020, 1, 45, '2020-02-16 00:00:00'),
(12, 12, 2020, 1, 45, '2020-02-16 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpersonal`
--

CREATE TABLE `tblpersonal` (
  `idpersonal` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `apellidop` varchar(120) NOT NULL,
  `apellidom` varchar(120) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblpersonal`
--

INSERT INTO `tblpersonal` (`idpersonal`, `idplantel`, `nombre`, `apellidop`, `apellidom`, `usuario`, `password`, `activo`, `idusuario`, `fecharegistro`) VALUES
(1, 1, 'PRUDENCIO', 'VELASCO', 'PALACIOS', 'pvelasco', '$2y$10$4u54D/ljj0oKBKhjBIncHOeclBroxucJo58L9Gsq29EI1yINVGDnO', 1, 45, '2020-02-17 22:47:51'),
(2, 2, 'CLARA', 'VELASCO', 'PALACIOS', 'cvelasco', '$2y$10$cw/T50kNelAhx1YXG0WuSe0CJLKMDbTSyEFdtcaP3qa15GFpHOxW6', 1, 45, '2020-02-17 23:55:25'),
(3, 1, 'TEOFILA', 'VELASCO', 'PALACIOS', 'tvelasco', '$2y$10$ZN049Gxw7MjlQUSP9exPW.aDmtHBs8sKpEss7EHJ4wUlzOz1yVg4m', 1, 45, '2020-02-17 22:23:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblplaneacion`
--

CREATE TABLE `tblplaneacion` (
  `idplaneacion` int(11) NOT NULL,
  `idunidad` int(11) NOT NULL,
  `iddetallehorario` int(11) NOT NULL,
  `planeacion` text NOT NULL,
  `lugar` varchar(190) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechafin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblplaneacion`
--

INSERT INTO `tblplaneacion` (`idplaneacion`, `idunidad`, `iddetallehorario`, `planeacion`, `lugar`, `fechainicio`, `fechafin`) VALUES
(2, 1, 28, '<p>TAREASS</p>', 'AULA DE CLASES', '2020-02-10', '2020-02-14'),
(4, 1, 33, '<p>Leer los Libros</p>', 'LABORATORIO', '2020-02-10', '2020-02-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblplantel`
--

CREATE TABLE `tblplantel` (
  `idplantel` int(11) NOT NULL,
  `clave` varchar(30) NOT NULL,
  `nombreplantel` varchar(200) NOT NULL,
  `logoplantel` varchar(100) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `director` varchar(150) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblplantel`
--

INSERT INTO `tblplantel` (`idplantel`, `clave`, `nombreplantel`, `logoplantel`, `direccion`, `telefono`, `director`, `idusuario`, `fecharegistro`) VALUES
(1, '', 'PLANTEL 1', 'LOGO', 'CONOCIDO', '8982343432', '', 45, '0000-00-00 00:00:00'),
(2, '2804WM', 'WEBMASTER', '', 'WEBMASTER', '0000000000', 'WEBMASTER', 45, '2020-02-16 09:28:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblprofesor`
--

CREATE TABLE `tblprofesor` (
  `idprofesor` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `cedula` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellidop` varchar(150) NOT NULL,
  `apellidom` varchar(150) NOT NULL,
  `profesion` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblprofesor`
--

INSERT INTO `tblprofesor` (`idprofesor`, `idplantel`, `cedula`, `nombre`, `apellidop`, `apellidom`, `profesion`, `correo`, `password`, `idusuario`, `fecharegistro`) VALUES
(1, 1, '09899', 'JUAN', 'GUZMAN', 'SANCHEZ', 'lic. en informatica', 'prudencio.vepa@gmail.com', '$2y$10$hK45P0fq/zYpuYFIoiG90O7EmD8euBQtAxDyYSifMPLqGPoideeCy', 45, '2020-02-17 12:14:31'),
(2, 1, '989', 'SARI', 'BAUTISTA', 'RUIZ', 'lic.en informatica', 'admin@admin.com', 'admin', 45, '0000-00-00 00:00:00'),
(3, 1, '09232', 'ERIKA', 'OJEDA', 'PEREZ', 'LIC. EN EDUCACION', 'eojeda@gmail.com', 'admin', 45, '0000-00-00 00:00:00'),
(4, 1, '3324', 'MIGUEL ANGEL', 'PALACIOS', 'VELASCO', 'LIC. EN EDUCACION', 'mpalacios@gmail.com', 'admin', 45, '0000-00-00 00:00:00'),
(5, 1, '898773', 'ARACELY', 'FLORES', 'HERRERA', 'lic. docencia', 'test@admin.com', '$2y$10$sF5XDergTZctvcoKGWl.ju7v4Ga2DUBfmgAFd8QW1CstQTlYG88Q2', 45, '0000-00-00 00:00:00'),
(6, 1, '98923', 'QWE', 'QWE', 'QWE', 'qwe', 'admin@admin.com', '$2y$10$jir.s/ArILGcSXCHL43D4uNBPMFM6NzHy2q3/dtl5.bjXRvokWYLu', 45, '2020-02-15 03:25:04'),
(7, 1, '9893', 'KJH', 'KJH', 'KH', 'j', 'admin@admin.com', '$2y$10$hnLLXa7X5PIEq6QV.3GMqeNKHpO1uX9eTMknHTEWoLHzJi5X9oZlm', 45, '2020-02-15 02:25:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblprofesor_materia`
--

CREATE TABLE `tblprofesor_materia` (
  `idprofesormateria` int(11) NOT NULL,
  `idprofesor` int(11) NOT NULL,
  `idmateria` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblprofesor_materia`
--

INSERT INTO `tblprofesor_materia` (`idprofesormateria`, `idprofesor`, `idmateria`, `idusuario`, `fecharegistro`) VALUES
(12, 1, 9, 45, '2020-02-15 03:23:57'),
(13, 1, 2, 45, '0000-00-00 00:00:00'),
(14, 1, 3, 45, '0000-00-00 00:00:00'),
(15, 1, 5, 45, '0000-00-00 00:00:00'),
(16, 2, 5, 45, '0000-00-00 00:00:00'),
(17, 2, 6, 45, '0000-00-00 00:00:00'),
(18, 2, 7, 45, '0000-00-00 00:00:00'),
(19, 2, 8, 45, '0000-00-00 00:00:00'),
(20, 3, 9, 45, '0000-00-00 00:00:00'),
(21, 3, 10, 45, '0000-00-00 00:00:00'),
(22, 3, 4, 45, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltarea`
--

CREATE TABLE `tbltarea` (
  `idtarea` int(11) NOT NULL,
  `idhorario` int(11) NOT NULL,
  `idhorariodetalle` int(11) NOT NULL,
  `tarea` text NOT NULL,
  `fechaentrega` date NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbltarea`
--

INSERT INTO `tbltarea` (`idtarea`, `idhorario`, `idhorariodetalle`, `tarea`, `fechaentrega`, `fecharegistro`) VALUES
(10, 10, 33, '<p>Leer los libros pendiente</p>', '2020-02-20', '2020-02-10 11:45:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltipousuario`
--

CREATE TABLE `tbltipousuario` (
  `idtipousuario` int(11) NOT NULL,
  `nombretipousuario` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbltipousuario`
--

INSERT INTO `tbltipousuario` (`idtipousuario`, `nombretipousuario`) VALUES
(1, 'DOCENTE'),
(2, 'ADMINISTRATIVO'),
(3, 'ALUMNO'),
(5, 'TUTOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltipo_pago`
--

CREATE TABLE `tbltipo_pago` (
  `idtipopago` int(11) NOT NULL,
  `nombretipopago` varchar(120) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbltipo_pago`
--

INSERT INTO `tbltipo_pago` (`idtipopago`, `nombretipopago`, `activo`) VALUES
(1, 'EFECTIVO', 1),
(2, 'TARJETA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblturno`
--

CREATE TABLE `tblturno` (
  `idturno` int(11) NOT NULL,
  `nombreturno` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblturno`
--

INSERT INTO `tblturno` (`idturno`, `nombreturno`) VALUES
(1, 'MATUTINO'),
(2, 'VESPERTINO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltutor`
--

CREATE TABLE `tbltutor` (
  `idtutor` int(11) NOT NULL,
  `idplantel` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellidop` varchar(150) NOT NULL,
  `apellidom` varchar(150) NOT NULL,
  `fnacimiento` date NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecharegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbltutor`
--

INSERT INTO `tbltutor` (`idtutor`, `idplantel`, `nombre`, `apellidop`, `apellidom`, `fnacimiento`, `direccion`, `telefono`, `correo`, `password`, `idusuario`, `fecharegistro`) VALUES
(1, 1, 'OFELIA', 'FLORES', 'HERRERA', '1990-04-28', 'OAXACA', '9541181986', 'prudencio.vepa@gmail.com', '28duguer', 45, '0000-00-00 00:00:00'),
(2, 1, 'SANDRA', 'GOMEZ', 'GUZMAN', '1990-03-23', 'OAXACA', '6873232123', 'prudencio.vepa@gmail.com', 'admin', 45, '0000-00-00 00:00:00'),
(3, 1, 'S', 'D', '', '2020-02-15', 'DAS', '9541181986', 'admin@admin.com', '$2y$10$7iyp/i9oLHzfR6W6osKIk.22JW8W/0FcScuD/SC0yzShftX5WTT4C', 45, '2020-02-15 08:56:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbltutoralumno`
--

CREATE TABLE `tbltutoralumno` (
  `idtutoralumno` int(11) NOT NULL,
  `idtutor` int(11) NOT NULL,
  `idalumno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbltutoralumno`
--

INSERT INTO `tbltutoralumno` (`idtutoralumno`, `idtutor`, `idalumno`) VALUES
(24, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblunidad`
--

CREATE TABLE `tblunidad` (
  `idunidad` int(11) NOT NULL,
  `nombreunidad` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblunidad`
--

INSERT INTO `tblunidad` (`idunidad`, `nombreunidad`) VALUES
(1, 'UNIDAD 1'),
(2, 'UNIDAD 2'),
(3, 'UNIDAD 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblyear`
--

CREATE TABLE `tblyear` (
  `idyear` int(11) NOT NULL,
  `nombreyear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tblyear`
--

INSERT INTO `tblyear` (`idyear`, `nombreyear`) VALUES
(1, 2020),
(2, 2021);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idtipousuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `idusuario`, `idtipousuario`) VALUES
(41, 1, 3),
(42, 2, 3),
(43, 1, 1),
(44, 2, 1),
(45, 1, 2),
(46, 2, 2),
(47, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_rol`
--

CREATE TABLE `users_rol` (
  `id` int(10) NOT NULL,
  `id_rol` int(10) NOT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users_rol`
--

INSERT INTO `users_rol` (`id`, `id_rol`, `id_user`) VALUES
(39, 12, 41),
(40, 12, 42),
(41, 10, 43),
(42, 10, 44),
(43, 14, 45),
(44, 14, 46),
(45, 13, 47);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vhorarioclases`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vhorarioclases` (
`idhorariodetalle` int(11)
,`idhorario` int(11)
,`iddia` varchar(11)
,`horainicial` time
,`horafinal` time
,`nombredia` varchar(45)
,`nombre` varchar(150)
,`apellidop` varchar(150)
,`apellidom` varchar(150)
,`nombreclase` varchar(250)
,`idmateria` varchar(11)
,`idprofesormateria` varchar(11)
,`opcion` varchar(8)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vhorarioclases`
--
DROP TABLE IF EXISTS `vhorarioclases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vhorarioclases`  AS  select `de`.`idhorariodetalle` AS `idhorariodetalle`,`de`.`idhorario` AS `idhorario`,`d`.`iddia` AS `iddia`,`de`.`horainicial` AS `horainicial`,`de`.`horafinal` AS `horafinal`,`d`.`nombredia` AS `nombredia`,`p`.`nombre` AS `nombre`,`p`.`apellidop` AS `apellidop`,`p`.`apellidom` AS `apellidom`,`m`.`nombreclase` AS `nombreclase`,`m`.`idmateria` AS `idmateria`,`pm`.`idprofesormateria` AS `idprofesormateria`,'Normal' AS `opcion` from ((((`tblhorario_detalle` `de` join `tbldia` `d` on((`de`.`iddia` = `d`.`iddia`))) join `tblprofesor_materia` `pm` on((`pm`.`idprofesormateria` = `de`.`idmateria`))) join `tblmateria` `m` on((`m`.`idmateria` = `pm`.`idmateria`))) join `tblprofesor` `p` on((`p`.`idprofesor` = `pm`.`idprofesor`))) union all select `de`.`iddescanzo` AS `idhorariodetalle`,`de`.`idhorario` AS `idhorario`,'Todos' AS `Todos`,`de`.`horainicial` AS `horainicial`,`de`.`horafinal` AS `horafinal`,'Todos' AS `nombredia`,'Todos' AS `nombre`,'Todos' AS `apellidop`,'Todos' AS `apellidom`,`de`.`titulo` AS `nombreclase`,'0' AS `idmateria`,'0' AS `idprofesormateria`,'Descanso' AS `opcion` from `tbldescanzo` `de` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permission_rol`
--
ALTER TABLE `permission_rol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tblalumno`
--
ALTER TABLE `tblalumno`
  ADD PRIMARY KEY (`idalumno`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tblalumno_grupo`
--
ALTER TABLE `tblalumno_grupo`
  ADD PRIMARY KEY (`idalumnogrupo`),
  ADD KEY `idalumno` (`idalumno`),
  ADD KEY `idgrupo` (`idgrupo`),
  ADD KEY `idperiodo` (`idperiodo`);

--
-- Indices de la tabla `tblamotizacion`
--
ALTER TABLE `tblamotizacion`
  ADD PRIMARY KEY (`idamortizacion`),
  ADD UNIQUE KEY `idperiodopago` (`idperiodopago`),
  ADD KEY `idalumno` (`idalumno`),
  ADD KEY `idperiodo` (`idperiodo`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `tblasistencia`
--
ALTER TABLE `tblasistencia`
  ADD PRIMARY KEY (`idasistencia`),
  ADD KEY `idhorario` (`idhorario`),
  ADD KEY `idalumno` (`idalumno`),
  ADD KEY `idmotivo` (`idmotivo`),
  ADD KEY `idhorariodetalle` (`idhorariodetalle`);

--
-- Indices de la tabla `tblcalificacion`
--
ALTER TABLE `tblcalificacion`
  ADD PRIMARY KEY (`idcalificacion`),
  ADD KEY `idexamen` (`idunidad`),
  ADD KEY `idgrupoalumno` (`idalumno`),
  ADD KEY `idhorario` (`idhorario`),
  ADD KEY `idhorariodetalle` (`idhorariodetalle`);

--
-- Indices de la tabla `tbldescanzo`
--
ALTER TABLE `tbldescanzo`
  ADD PRIMARY KEY (`iddescanzo`),
  ADD KEY `idhorario` (`idhorario`);

--
-- Indices de la tabla `tbldetalle_pago`
--
ALTER TABLE `tbldetalle_pago`
  ADD PRIMARY KEY (`iddetallepago`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idformapago` (`idformapago`),
  ADD KEY `idestadocuenta` (`idestadocuenta`);

--
-- Indices de la tabla `tbldia`
--
ALTER TABLE `tbldia`
  ADD PRIMARY KEY (`iddia`);

--
-- Indices de la tabla `tblestado_cuenta`
--
ALTER TABLE `tblestado_cuenta`
  ADD PRIMARY KEY (`idestadocuenta`),
  ADD KEY `idamortizacion` (`idamortizacion`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idperiodo` (`idperiodo`),
  ADD KEY `idalumno` (`idalumno`);

--
-- Indices de la tabla `tblexamen`
--
ALTER TABLE `tblexamen`
  ADD PRIMARY KEY (`idexamen`);

--
-- Indices de la tabla `tblgrupo`
--
ALTER TABLE `tblgrupo`
  ADD PRIMARY KEY (`idgrupo`),
  ADD KEY `idnivelestudio` (`idnivelestudio`),
  ADD KEY `idturno` (`idturno`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tblhorario`
--
ALTER TABLE `tblhorario`
  ADD PRIMARY KEY (`idhorario`),
  ADD KEY `idgrupo` (`idgrupo`),
  ADD KEY `tblhorario_ibfk_2` (`idperiodo`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tblhorario_detalle`
--
ALTER TABLE `tblhorario_detalle`
  ADD PRIMARY KEY (`idhorariodetalle`),
  ADD KEY `idhorario` (`idhorario`),
  ADD KEY `idmateria` (`idmateria`),
  ADD KEY `iddia` (`iddia`);

--
-- Indices de la tabla `tblinstitucion`
--
ALTER TABLE `tblinstitucion`
  ADD PRIMARY KEY (`idinstitucion`);

--
-- Indices de la tabla `tblmateria`
--
ALTER TABLE `tblmateria`
  ADD PRIMARY KEY (`idmateria`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tblmes`
--
ALTER TABLE `tblmes`
  ADD PRIMARY KEY (`idmes`);

--
-- Indices de la tabla `tblmotivo_asistencia`
--
ALTER TABLE `tblmotivo_asistencia`
  ADD PRIMARY KEY (`idmotivo`);

--
-- Indices de la tabla `tblnivelestudio`
--
ALTER TABLE `tblnivelestudio`
  ADD PRIMARY KEY (`idnivelestudio`);

--
-- Indices de la tabla `tblperiodo`
--
ALTER TABLE `tblperiodo`
  ADD PRIMARY KEY (`idperiodo`),
  ADD UNIQUE KEY `idmesinicio` (`idmesinicio`),
  ADD UNIQUE KEY `idyearinicio` (`idyearinicio`),
  ADD UNIQUE KEY `idmesfin` (`idmesfin`),
  ADD UNIQUE KEY `idyearfin` (`idyearfin`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tblperiodo_pago`
--
ALTER TABLE `tblperiodo_pago`
  ADD PRIMARY KEY (`idperiodopago`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `tblpersonal`
--
ALTER TABLE `tblpersonal`
  ADD PRIMARY KEY (`idpersonal`),
  ADD KEY `idplantel` (`idplantel`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `tblplaneacion`
--
ALTER TABLE `tblplaneacion`
  ADD PRIMARY KEY (`idplaneacion`),
  ADD KEY `idunidad` (`idunidad`),
  ADD KEY `iddetallehorario` (`iddetallehorario`);

--
-- Indices de la tabla `tblplantel`
--
ALTER TABLE `tblplantel`
  ADD PRIMARY KEY (`idplantel`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `tblprofesor`
--
ALTER TABLE `tblprofesor`
  ADD PRIMARY KEY (`idprofesor`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tblprofesor_materia`
--
ALTER TABLE `tblprofesor_materia`
  ADD PRIMARY KEY (`idprofesormateria`),
  ADD KEY `idprofesor` (`idprofesor`),
  ADD KEY `idmateria` (`idmateria`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `tbltarea`
--
ALTER TABLE `tbltarea`
  ADD PRIMARY KEY (`idtarea`),
  ADD KEY `idhorario` (`idhorario`),
  ADD KEY `idhorariodetalle` (`idhorariodetalle`);

--
-- Indices de la tabla `tbltipousuario`
--
ALTER TABLE `tbltipousuario`
  ADD PRIMARY KEY (`idtipousuario`);

--
-- Indices de la tabla `tbltipo_pago`
--
ALTER TABLE `tbltipo_pago`
  ADD PRIMARY KEY (`idtipopago`);

--
-- Indices de la tabla `tblturno`
--
ALTER TABLE `tblturno`
  ADD PRIMARY KEY (`idturno`);

--
-- Indices de la tabla `tbltutor`
--
ALTER TABLE `tbltutor`
  ADD PRIMARY KEY (`idtutor`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idplantel` (`idplantel`);

--
-- Indices de la tabla `tbltutoralumno`
--
ALTER TABLE `tbltutoralumno`
  ADD PRIMARY KEY (`idtutoralumno`),
  ADD KEY `idtutor` (`idtutor`),
  ADD KEY `idalumno` (`idalumno`);

--
-- Indices de la tabla `tblunidad`
--
ALTER TABLE `tblunidad`
  ADD PRIMARY KEY (`idunidad`);

--
-- Indices de la tabla `tblyear`
--
ALTER TABLE `tblyear`
  ADD PRIMARY KEY (`idyear`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idturno` (`idusuario`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idtipousuario` (`idtipousuario`);

--
-- Indices de la tabla `users_rol`
--
ALTER TABLE `users_rol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `permission_rol`
--
ALTER TABLE `permission_rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tblalumno`
--
ALTER TABLE `tblalumno`
  MODIFY `idalumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tblalumno_grupo`
--
ALTER TABLE `tblalumno_grupo`
  MODIFY `idalumnogrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tblamotizacion`
--
ALTER TABLE `tblamotizacion`
  MODIFY `idamortizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tblasistencia`
--
ALTER TABLE `tblasistencia`
  MODIFY `idasistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `tblcalificacion`
--
ALTER TABLE `tblcalificacion`
  MODIFY `idcalificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbldescanzo`
--
ALTER TABLE `tbldescanzo`
  MODIFY `iddescanzo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbldetalle_pago`
--
ALTER TABLE `tbldetalle_pago`
  MODIFY `iddetallepago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbldia`
--
ALTER TABLE `tbldia`
  MODIFY `iddia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tblestado_cuenta`
--
ALTER TABLE `tblestado_cuenta`
  MODIFY `idestadocuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tblexamen`
--
ALTER TABLE `tblexamen`
  MODIFY `idexamen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tblgrupo`
--
ALTER TABLE `tblgrupo`
  MODIFY `idgrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tblhorario`
--
ALTER TABLE `tblhorario`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tblhorario_detalle`
--
ALTER TABLE `tblhorario_detalle`
  MODIFY `idhorariodetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `tblinstitucion`
--
ALTER TABLE `tblinstitucion`
  MODIFY `idinstitucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tblmateria`
--
ALTER TABLE `tblmateria`
  MODIFY `idmateria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tblmes`
--
ALTER TABLE `tblmes`
  MODIFY `idmes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tblmotivo_asistencia`
--
ALTER TABLE `tblmotivo_asistencia`
  MODIFY `idmotivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tblnivelestudio`
--
ALTER TABLE `tblnivelestudio`
  MODIFY `idnivelestudio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tblperiodo`
--
ALTER TABLE `tblperiodo`
  MODIFY `idperiodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tblperiodo_pago`
--
ALTER TABLE `tblperiodo_pago`
  MODIFY `idperiodopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tblpersonal`
--
ALTER TABLE `tblpersonal`
  MODIFY `idpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tblplaneacion`
--
ALTER TABLE `tblplaneacion`
  MODIFY `idplaneacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tblplantel`
--
ALTER TABLE `tblplantel`
  MODIFY `idplantel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tblprofesor`
--
ALTER TABLE `tblprofesor`
  MODIFY `idprofesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tblprofesor_materia`
--
ALTER TABLE `tblprofesor_materia`
  MODIFY `idprofesormateria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tbltarea`
--
ALTER TABLE `tbltarea`
  MODIFY `idtarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbltipousuario`
--
ALTER TABLE `tbltipousuario`
  MODIFY `idtipousuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbltipo_pago`
--
ALTER TABLE `tbltipo_pago`
  MODIFY `idtipopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tblturno`
--
ALTER TABLE `tblturno`
  MODIFY `idturno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbltutor`
--
ALTER TABLE `tbltutor`
  MODIFY `idtutor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbltutoralumno`
--
ALTER TABLE `tbltutoralumno`
  MODIFY `idtutoralumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tblunidad`
--
ALTER TABLE `tblunidad`
  MODIFY `idunidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tblyear`
--
ALTER TABLE `tblyear`
  MODIFY `idyear` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `users_rol`
--
ALTER TABLE `users_rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permission_rol`
--
ALTER TABLE `permission_rol`
  ADD CONSTRAINT `permission_rol_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `permission_rol_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

--
-- Filtros para la tabla `tblalumno`
--
ALTER TABLE `tblalumno`
  ADD CONSTRAINT `tblalumno_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tblalumno_ibfk_2` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`);

--
-- Filtros para la tabla `tblalumno_grupo`
--
ALTER TABLE `tblalumno_grupo`
  ADD CONSTRAINT `tblalumno_grupo_ibfk_1` FOREIGN KEY (`idalumno`) REFERENCES `tblalumno` (`idalumno`),
  ADD CONSTRAINT `tblalumno_grupo_ibfk_2` FOREIGN KEY (`idgrupo`) REFERENCES `tblgrupo` (`idgrupo`),
  ADD CONSTRAINT `tblalumno_grupo_ibfk_3` FOREIGN KEY (`idperiodo`) REFERENCES `tblperiodo` (`idperiodo`);

--
-- Filtros para la tabla `tblamotizacion`
--
ALTER TABLE `tblamotizacion`
  ADD CONSTRAINT `tblamotizacion_ibfk_1` FOREIGN KEY (`idalumno`) REFERENCES `tblalumno` (`idalumno`),
  ADD CONSTRAINT `tblamotizacion_ibfk_2` FOREIGN KEY (`idperiodo`) REFERENCES `tblperiodo` (`idperiodo`),
  ADD CONSTRAINT `tblamotizacion_ibfk_3` FOREIGN KEY (`idperiodopago`) REFERENCES `tblperiodo_pago` (`idperiodopago`),
  ADD CONSTRAINT `tblamotizacion_ibfk_4` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tblasistencia`
--
ALTER TABLE `tblasistencia`
  ADD CONSTRAINT `tblasistencia_ibfk_1` FOREIGN KEY (`idalumno`) REFERENCES `tblalumno` (`idalumno`),
  ADD CONSTRAINT `tblasistencia_ibfk_2` FOREIGN KEY (`idhorario`) REFERENCES `tblhorario` (`idhorario`),
  ADD CONSTRAINT `tblasistencia_ibfk_3` FOREIGN KEY (`idmotivo`) REFERENCES `tblmotivo_asistencia` (`idmotivo`),
  ADD CONSTRAINT `tblasistencia_ibfk_4` FOREIGN KEY (`idhorariodetalle`) REFERENCES `tblhorario_detalle` (`idhorariodetalle`);

--
-- Filtros para la tabla `tblcalificacion`
--
ALTER TABLE `tblcalificacion`
  ADD CONSTRAINT `tblcalificacion_ibfk_1` FOREIGN KEY (`idalumno`) REFERENCES `tblalumno` (`idalumno`),
  ADD CONSTRAINT `tblcalificacion_ibfk_2` FOREIGN KEY (`idhorario`) REFERENCES `tblhorario` (`idhorario`),
  ADD CONSTRAINT `tblcalificacion_ibfk_3` FOREIGN KEY (`idhorariodetalle`) REFERENCES `tblhorario_detalle` (`idhorariodetalle`),
  ADD CONSTRAINT `tblcalificacion_ibfk_4` FOREIGN KEY (`idunidad`) REFERENCES `tblunidad` (`idunidad`);

--
-- Filtros para la tabla `tbldescanzo`
--
ALTER TABLE `tbldescanzo`
  ADD CONSTRAINT `tbldescanzo_ibfk_1` FOREIGN KEY (`idhorario`) REFERENCES `tblhorario` (`idhorario`);

--
-- Filtros para la tabla `tbldetalle_pago`
--
ALTER TABLE `tbldetalle_pago`
  ADD CONSTRAINT `tbldetalle_pago_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tbldetalle_pago_ibfk_2` FOREIGN KEY (`idformapago`) REFERENCES `tbltipo_pago` (`idtipopago`),
  ADD CONSTRAINT `tbldetalle_pago_ibfk_3` FOREIGN KEY (`idestadocuenta`) REFERENCES `tblestado_cuenta` (`idestadocuenta`);

--
-- Filtros para la tabla `tblestado_cuenta`
--
ALTER TABLE `tblestado_cuenta`
  ADD CONSTRAINT `tblestado_cuenta_ibfk_1` FOREIGN KEY (`idamortizacion`) REFERENCES `tblamotizacion` (`idamortizacion`),
  ADD CONSTRAINT `tblestado_cuenta_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tblestado_cuenta_ibfk_3` FOREIGN KEY (`idperiodo`) REFERENCES `tblperiodo` (`idperiodo`),
  ADD CONSTRAINT `tblestado_cuenta_ibfk_4` FOREIGN KEY (`idalumno`) REFERENCES `tblalumno` (`idalumno`);

--
-- Filtros para la tabla `tblgrupo`
--
ALTER TABLE `tblgrupo`
  ADD CONSTRAINT `tblgrupo_ibfk_1` FOREIGN KEY (`idnivelestudio`) REFERENCES `tblnivelestudio` (`idnivelestudio`),
  ADD CONSTRAINT `tblgrupo_ibfk_2` FOREIGN KEY (`idturno`) REFERENCES `tblturno` (`idturno`),
  ADD CONSTRAINT `tblgrupo_ibfk_3` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tblgrupo_ibfk_4` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`);

--
-- Filtros para la tabla `tblhorario`
--
ALTER TABLE `tblhorario`
  ADD CONSTRAINT `tblhorario_ibfk_1` FOREIGN KEY (`idgrupo`) REFERENCES `tblgrupo` (`idgrupo`),
  ADD CONSTRAINT `tblhorario_ibfk_2` FOREIGN KEY (`idperiodo`) REFERENCES `tblperiodo` (`idperiodo`),
  ADD CONSTRAINT `tblhorario_ibfk_3` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`);

--
-- Filtros para la tabla `tblhorario_detalle`
--
ALTER TABLE `tblhorario_detalle`
  ADD CONSTRAINT `tblhorario_detalle_ibfk_1` FOREIGN KEY (`iddia`) REFERENCES `tbldia` (`iddia`),
  ADD CONSTRAINT `tblhorario_detalle_ibfk_2` FOREIGN KEY (`idmateria`) REFERENCES `tblprofesor_materia` (`idprofesormateria`),
  ADD CONSTRAINT `tblhorario_detalle_ibfk_3` FOREIGN KEY (`idhorario`) REFERENCES `tblhorario` (`idhorario`);

--
-- Filtros para la tabla `tblmateria`
--
ALTER TABLE `tblmateria`
  ADD CONSTRAINT `tblmateria_ibfk_1` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`);

--
-- Filtros para la tabla `tblperiodo`
--
ALTER TABLE `tblperiodo`
  ADD CONSTRAINT `tblperiodo_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tblperiodo_ibfk_2` FOREIGN KEY (`idmesinicio`) REFERENCES `tblmes` (`idmes`),
  ADD CONSTRAINT `tblperiodo_ibfk_3` FOREIGN KEY (`idyearinicio`) REFERENCES `tblyear` (`idyear`),
  ADD CONSTRAINT `tblperiodo_ibfk_4` FOREIGN KEY (`idmesfin`) REFERENCES `tblmes` (`idmes`),
  ADD CONSTRAINT `tblperiodo_ibfk_5` FOREIGN KEY (`idyearfin`) REFERENCES `tblyear` (`idyear`),
  ADD CONSTRAINT `tblperiodo_ibfk_6` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`);

--
-- Filtros para la tabla `tblperiodo_pago`
--
ALTER TABLE `tblperiodo_pago`
  ADD CONSTRAINT `tblperiodo_pago_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tblpersonal`
--
ALTER TABLE `tblpersonal`
  ADD CONSTRAINT `tblpersonal_ibfk_1` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`),
  ADD CONSTRAINT `tblpersonal_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tblplaneacion`
--
ALTER TABLE `tblplaneacion`
  ADD CONSTRAINT `tblplaneacion_ibfk_1` FOREIGN KEY (`idunidad`) REFERENCES `tblunidad` (`idunidad`),
  ADD CONSTRAINT `tblplaneacion_ibfk_2` FOREIGN KEY (`iddetallehorario`) REFERENCES `tblhorario_detalle` (`idhorariodetalle`);

--
-- Filtros para la tabla `tblplantel`
--
ALTER TABLE `tblplantel`
  ADD CONSTRAINT `tblplantel_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tblprofesor`
--
ALTER TABLE `tblprofesor`
  ADD CONSTRAINT `tblprofesor_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tblprofesor_materia`
--
ALTER TABLE `tblprofesor_materia`
  ADD CONSTRAINT `tblprofesor_materia_ibfk_1` FOREIGN KEY (`idprofesor`) REFERENCES `tblprofesor` (`idprofesor`),
  ADD CONSTRAINT `tblprofesor_materia_ibfk_2` FOREIGN KEY (`idmateria`) REFERENCES `tblmateria` (`idmateria`),
  ADD CONSTRAINT `tblprofesor_materia_ibfk_3` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tbltarea`
--
ALTER TABLE `tbltarea`
  ADD CONSTRAINT `tbltarea_ibfk_1` FOREIGN KEY (`idhorario`) REFERENCES `tblhorario` (`idhorario`),
  ADD CONSTRAINT `tbltarea_ibfk_2` FOREIGN KEY (`idhorariodetalle`) REFERENCES `tblhorario_detalle` (`idhorariodetalle`);

--
-- Filtros para la tabla `tbltutor`
--
ALTER TABLE `tbltutor`
  ADD CONSTRAINT `tbltutor_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tbltutor_ibfk_2` FOREIGN KEY (`idplantel`) REFERENCES `tblplantel` (`idplantel`);

--
-- Filtros para la tabla `tbltutoralumno`
--
ALTER TABLE `tbltutoralumno`
  ADD CONSTRAINT `tbltutoralumno_ibfk_1` FOREIGN KEY (`idtutor`) REFERENCES `tbltutor` (`idtutor`),
  ADD CONSTRAINT `tbltutoralumno_ibfk_2` FOREIGN KEY (`idalumno`) REFERENCES `tblalumno` (`idalumno`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idtipousuario`) REFERENCES `tbltipousuario` (`idtipousuario`);

--
-- Filtros para la tabla `users_rol`
--
ALTER TABLE `users_rol`
  ADD CONSTRAINT `users_rol_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `users_rol_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
