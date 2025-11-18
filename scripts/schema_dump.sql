-- SQL schema dump for framword
-- This schema is a clean subset of docker/mysql-init/init.sql with only DDL statements

CREATE DATABASE IF NOT EXISTS framworddb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE framworddb;

-- Tabla sexo
CREATE TABLE IF NOT EXISTS sexo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

-- Tabla estadocivil
CREATE TABLE IF NOT EXISTS estadocivil (
  idestadocivil INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

-- Tabla persona
CREATE TABLE IF NOT EXISTS persona (
  idpersona INT AUTO_INCREMENT PRIMARY KEY,
  nombres VARCHAR(255) NOT NULL,
  apellidos VARCHAR(255) NOT NULL,
  fechanacimiento DATE NULL,
  rol VARCHAR(20) NOT NULL DEFAULT 'estudiante',
  detalle TEXT NULL,
  idsexo INT NULL,
  idestadocivil INT NULL,
  FOREIGN KEY (idsexo) REFERENCES sexo(id) ON DELETE SET NULL,
  FOREIGN KEY (idestadocivil) REFERENCES estadocivil(idestadocivil) ON DELETE SET NULL
);

-- Tabla direccion
CREATE TABLE IF NOT EXISTS direccion (
  iddireccion INT AUTO_INCREMENT PRIMARY KEY,
  idpersona INT NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  FOREIGN KEY (idpersona) REFERENCES persona(idpersona) ON DELETE CASCADE
);

-- Tabla telefono
CREATE TABLE IF NOT EXISTS telefono (
  idtelefono INT AUTO_INCREMENT PRIMARY KEY,
  idpersona INT NOT NULL,
  numero VARCHAR(50) NOT NULL,
  FOREIGN KEY (idpersona) REFERENCES persona(idpersona) ON DELETE CASCADE
);

-- Tabla users (autenticación básica)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') DEFAULT 'user',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS universidades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  clave VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS estudiantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  matricula VARCHAR(100) NOT NULL,
  universidad_id INT NULL,
  FOREIGN KEY (universidad_id) REFERENCES universidades(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS profesores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  rfc VARCHAR(50) NOT NULL,
  universidad_id INT NULL,
  FOREIGN KEY (universidad_id) REFERENCES universidades(id) ON DELETE SET NULL
);
