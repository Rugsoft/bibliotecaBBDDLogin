-- Script de creación de la base de datos y tablas de la biblioteca
CREATE DATABASE IF NOT EXISTS `biblioteca-profe`;
USE `biblioteca-profe`;

-- Eliminar tablas en orden para evitar fallos de clave foránea
DROP TABLE IF EXISTS prestamos;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS libros;

-- 1. Tabla Libros
CREATE TABLE libros (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL UNIQUE,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    año INT NOT NULL,
    genero VARCHAR(80) NOT NULL,
    paginas INT NOT NULL
);

-- 2. Tabla Usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    apellidos VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    fecha_alta DATE NOT NULL
);

-- 3. Tabla Préstamos
CREATE TABLE prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_libro INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE,
    devuelto TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_libro) REFERENCES libros(id_libro)
);

-- Insertar libros de ejemplo
INSERT INTO libros (isbn, titulo, autor, año, genero, paginas)
VALUES
('978-84-376-0494-7', 'El Quijote', 'Miguel de Cervantes', 1605, 'Novela', 863),
('978-0-452-28423-4', '1984', 'George Orwell', 1949, 'Ciencia ficción', 328),
('978-0-13-235088-4', 'Clean Code', 'Robert C. Martin', 2008, 'Programación', 464),
('978-84-376-0495-4', 'Rayuela', 'Julio Cortázar', 1963, 'Novela', 736),
('978-84-415-4512-3', 'Aprendiendo PHP', 'Ana López', 2022, 'Programación', 290),
('978-84-206-6428-3', 'Breve historia del tiempo', 'Stephen Hawking', 1988, 'Ciencia', 256);

-- Insertar usuarios de ejemplo
INSERT INTO usuarios (nombre, apellidos, email, telefono, fecha_alta)
VALUES
('Laura', 'Martínez Ruiz', 'laura.martinez@email.com', '600111222', '2026-01-10'),
('Carlos', 'Gómez Pérez', 'carlos.gomez@email.com', '600333444', '2026-01-15'),
('Marta', 'Sánchez López', 'marta.sanchez@email.com', '600555666', '2026-02-01'),
('David', 'Navarro Gil', 'david.navarro@email.com', '600777888', '2026-02-20');

-- Insertar préstamos de ejemplo
INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion, devuelto)
VALUES
(1, 2, '2026-03-01', '2026-03-15', 1),
(2, 3, '2026-03-05', NULL, 0),
(3, 5, '2026-03-10', NULL, 0),
(1, 1, '2026-03-12', '2026-03-25', 1);

-- 4. Tabla de Administradores
CREATE TABLE IF NOT EXISTS administradores (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nombre VARCHAR(80) NOT NULL,
    apellidos VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Administrador por defecto (Usuario: admin, Contraseña: admin123)
INSERT INTO administradores (username, password_hash, nombre, apellidos, email)
VALUES ('admin', '$2y$10$Cn8XOEt695xBDEPXpquUre/t/qJtmzgsUn.i9ARVeCP2prIPcEgiK', 'Administrador', 'Biblioteca', 'admin@biblioteca.com')
ON DUPLICATE KEY UPDATE id_admin=id_admin;
