DROP DATABASE IF EXISTS inmobiliaria;
CREATE DATABASE inmobiliaria;
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user'
);

INSERT INTO users (username, password, role) VALUES
  ('usuario1', 'password1', 'user'),
  ('usuario2', 'password2', 'user'),
  ('admin', 'adminpassword', 'admin');


CREATE TABLE clientes (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  apellido VARCHAR(255) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  correo VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Crear la tabla de propiedades
CREATE TABLE propiedades (
  id INT(11) NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10, 2) NOT NULL,
  direccion VARCHAR(255) NOT NULL,
  ciudad VARCHAR(255) NOT NULL,
  estado VARCHAR(255) NOT NULL,
  codigo_postal VARCHAR(10) NOT NULL,
  imagen VARCHAR(255),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Crear la tabla de transacciones
CREATE TABLE transacciones (
  id INT(11) NOT NULL AUTO_INCREMENT,
  id_cliente INT(11) NOT NULL,
  id_propiedad INT(11) NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  tipo_transaccion VARCHAR(10) NOT NULL,
  monto DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_cliente) REFERENCES clientes(id),
  FOREIGN KEY (id_propiedad) REFERENCES propiedades(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE imagenes (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  ruta VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE paginas (
  id INT(11) NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(255) NOT NULL,
  contenido TEXT NOT NULL,
  imagen_ruta VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE paginas ADD imagen_ruta VARCHAR(255) DEFAULT NULL;
