-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-09-2026 a las 23:35:39
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
-- Base de datos: `hospital_documentos_practica2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `nombre`) VALUES
(1, 'Cardiología'),
(5, 'Cuidados posteriores'),
(3, 'Imagenología'),
(2, 'Nefrología'),
(4, 'Prevención');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `documento_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `archivo_url` varchar(255) NOT NULL,
  `estado` enum('borrador','publicado','archivado') NOT NULL DEFAULT 'borrador',
  `fecha_creacion` date NOT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `administrativo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`documento_id`, `titulo`, `descripcion`, `archivo_url`, `estado`, `fecha_creacion`, `fecha_publicacion`, `categoria_id`, `administrativo_id`) VALUES
(1, 'Preparación para ecocardiograma', 'Indicaciones previas para realizar el estudio.', '/documentos/ecocardiograma.pdf', 'publicado', '2026-07-01', '2026-07-03', 1, 1),
(2, 'Cuidados luego de una prostatectomía', 'Recomendaciones para el período posterior al alta.', '/documentos/prostatectomia.pdf', 'publicado', '2026-07-04', '2026-07-06', 5, 2),
(3, 'Preparación para tomografía', 'Información sobre ayuno y medicación previa.', '/documentos/tomografia.pdf', 'publicado', '2026-07-08', '2026-07-10', 3, 1),
(4, 'Prevención de infecciones', 'Medidas generales para reducir el riesgo de infecciones.', '/documentos/prevencion_infecciones.pdf', 'publicado', '2026-07-11', '2026-07-12', 4, 2),
(5, 'Ingreso al centro de nefrología', 'Documentación y estudios necesarios para el ingreso.', '/documentos/ingreso_nefrologia.pdf', 'borrador', '2026-07-15', NULL, 2, 1),
(6, 'Tratamiento con warfarina', 'Indicaciones para pacientes que reciben anticoagulantes.', '/documentos/warfarina.pdf', 'archivado', '2026-06-10', '2026-06-12', 1, 2),
(7, 'Plan de alta de enfermería', 'Cuidados y controles posteriores al alta.', '/documentos/plan_alta.pdf', 'publicado', '2026-07-18', '2026-07-20', 2, 1),
(8, 'Cuidados para pacientes ostomizados', 'Pautas básicas de higiene y seguimiento.', '/documentos/ostomizados.pdf', 'borrador', '2026-07-22', NULL, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `encuesta_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `es_anonima` tinyint(1) NOT NULL DEFAULT 1,
  `estado` enum('borrador','publicada','cerrada') NOT NULL DEFAULT 'borrador',
  `fecha_creacion` date NOT NULL,
  `administrativo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`encuesta_id`, `titulo`, `descripcion`, `es_anonima`, `estado`, `fecha_creacion`, `administrativo_id`) VALUES
(1, 'Satisfacción general', 'Encuesta sobre la atención recibida.', 1, 'publicada', '2026-07-05', 1),
(2, 'Acceso a documentación digital', 'Evaluación del acceso mediante código QR.', 1, 'publicada', '2026-07-09', 2),
(3, 'Seguimiento de pacientes', 'Encuesta identificada para controles posteriores.', 0, 'publicada', '2026-07-12', 1),
(4, 'Evaluación de nuevos contenidos', 'Formulario todavía en preparación.', 1, 'borrador', '2026-07-21', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `pregunta_id` int(11) NOT NULL,
  `encuesta_id` int(11) NOT NULL,
  `texto` varchar(250) NOT NULL,
  `tipo` enum('texto','escala','si_no') NOT NULL,
  `orden_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`pregunta_id`, `encuesta_id`, `texto`, `tipo`, `orden_pregunta`) VALUES
(1, 1, '¿Cómo califica la atención recibida?', 'escala', 1),
(2, 1, '¿Recomendaría el servicio?', 'si_no', 2),
(3, 1, 'Escriba una sugerencia de mejora.', 'texto', 3),
(4, 2, '¿Pudo abrir el documento desde el código QR?', 'si_no', 1),
(5, 2, '¿La información fue fácil de comprender?', 'escala', 2),
(6, 2, '¿Qué dificultad encontró?', 'texto', 3),
(7, 3, '¿Cumplió las indicaciones entregadas?', 'si_no', 1),
(8, 3, '¿Necesita que el hospital se comunique con usted?', 'si_no', 2),
(9, 4, '¿Qué nuevo documento le resultaría útil?', 'texto', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_encuesta`
--

CREATE TABLE `respuesta_encuesta` (
  `respuesta_id` int(11) NOT NULL,
  `encuesta_id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `valor_respuesta` varchar(250) NOT NULL,
  `fecha_respuesta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `respuesta_encuesta`
--

INSERT INTO `respuesta_encuesta` (`respuesta_id`, `encuesta_id`, `pregunta_id`, `paciente_id`, `valor_respuesta`, `fecha_respuesta`) VALUES
(1, 1, 1, NULL, '5', '2026-07-15 10:15:00'),
(2, 1, 2, NULL, 'Sí', '2026-07-15 10:16:00'),
(3, 1, 3, NULL, 'Agregar más cartelería.', '2026-07-15 10:17:00'),
(4, 1, 1, NULL, '4', '2026-07-16 11:20:00'),
(5, 1, 2, NULL, 'Sí', '2026-07-16 11:21:00'),
(6, 1, 3, NULL, 'La atención fue correcta.', '2026-07-16 11:22:00'),
(7, 2, 4, NULL, 'Sí', '2026-07-18 09:10:00'),
(8, 2, 5, NULL, '5', '2026-07-18 09:11:00'),
(9, 2, 6, NULL, 'Ninguna', '2026-07-18 09:12:00'),
(10, 2, 4, NULL, 'No', '2026-07-19 14:40:00'),
(11, 2, 5, NULL, '3', '2026-07-19 14:41:00'),
(12, 2, 6, NULL, 'El código QR estaba borroso.', '2026-07-19 14:42:00'),
(13, 3, 7, 3, 'Sí', '2026-07-20 12:00:00'),
(14, 3, 8, 3, 'No', '2026-07-20 12:01:00'),
(15, 3, 7, 4, 'No', '2026-07-21 16:30:00'),
(16, 3, 8, 4, 'Sí', '2026-07-21 16:31:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `rol` enum('administrativo','paciente') NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombre`, `email`, `rol`, `password_hash`) VALUES
(1, 'Ana Rodríguez', 'ana.rodriguez@hospital.uy', 'administrativo', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(2, 'Martín Silva', 'martin.silva@hospital.uy', 'administrativo', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(3, 'Laura Pereira', 'laura.pereira@email.com', 'paciente', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(4, 'Diego Fernández', 'diego.fernandez@email.com', 'paciente', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(5, 'Sofía Gómez', 'sofia.gomez@email.com', 'paciente', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(6, 'Carlos Méndez', 'carlos.mendez@email.com', 'paciente', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(12, 'Ezequiel', 'eze@quiel.com', 'administrativo', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(13, '                        camila        ', 'camila.martinez@iti.example', 'administrativo', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(15, '                        jose                ', 'jose@jose.com', 'paciente', '$2y$10$ur7uSBK8OU0hMhlCw2MWOukQuZbUxTHvyD4E.7czU/SLM7/V3fYOu'),
(19, 'lucas', 'lucas@lucas.com', 'paciente', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`documento_id`),
  ADD KEY `fk_documento_categoria` (`categoria_id`),
  ADD KEY `fk_documento_administrativo` (`administrativo_id`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`encuesta_id`),
  ADD KEY `fk_encuesta_administrativo` (`administrativo_id`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`pregunta_id`),
  ADD UNIQUE KEY `uq_pregunta_orden` (`encuesta_id`,`orden_pregunta`);

--
-- Indices de la tabla `respuesta_encuesta`
--
ALTER TABLE `respuesta_encuesta`
  ADD PRIMARY KEY (`respuesta_id`),
  ADD KEY `fk_respuesta_encuesta` (`encuesta_id`),
  ADD KEY `fk_respuesta_pregunta` (`pregunta_id`),
  ADD KEY `fk_respuesta_paciente` (`paciente_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `documento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `encuesta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `respuesta_encuesta`
--
ALTER TABLE `respuesta_encuesta`
  MODIFY `respuesta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `fk_documento_administrativo` FOREIGN KEY (`administrativo_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `fk_documento_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`);

--
-- Filtros para la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD CONSTRAINT `fk_encuesta_administrativo` FOREIGN KEY (`administrativo_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `fk_pregunta_encuesta` FOREIGN KEY (`encuesta_id`) REFERENCES `encuesta` (`encuesta_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuesta_encuesta`
--
ALTER TABLE `respuesta_encuesta`
  ADD CONSTRAINT `fk_respuesta_encuesta` FOREIGN KEY (`encuesta_id`) REFERENCES `encuesta` (`encuesta_id`),
  ADD CONSTRAINT `fk_respuesta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `fk_respuesta_pregunta` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`pregunta_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
