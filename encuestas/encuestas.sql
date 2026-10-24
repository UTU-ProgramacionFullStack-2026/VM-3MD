-- Base de datos del sistema de encuestas
-- Borra todo y lo crea de nuevo.

DROP DATABASE IF EXISTS hospital_encuestas;
CREATE DATABASE hospital_encuestas;
USE hospital_encuestas;

CREATE TABLE encuesta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT
);

-- La columna "tipo" dice qué subclase de Respuesta usa la pregunta
CREATE TABLE pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    encuesta_id INT NOT NULL,
    texto TEXT NOT NULL,
    tipo ENUM('binaria', 'escala', 'texto') NOT NULL,
    FOREIGN KEY (encuesta_id) REFERENCES encuesta(id) ON DELETE CASCADE
);

-- Cada vez que alguien responde, se guarda una fila por pregunta.
-- "valor" puede ser 'si'/'no', un número del 1 al 10, o un texto.
CREATE TABLE respuesta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NOT NULL,
    valor TEXT,
    FOREIGN KEY (pregunta_id) REFERENCES pregunta(id) ON DELETE CASCADE
);

-- Quién respondió cada encuesta. Un email no puede repetir la misma encuesta.
CREATE TABLE participacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    encuesta_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    UNIQUE (encuesta_id, email),
    FOREIGN KEY (encuesta_id) REFERENCES encuesta(id) ON DELETE CASCADE
);
