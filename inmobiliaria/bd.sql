CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('administrator', 'user') NOT NULL
);

INSERT INTO users (username, password, role)
VALUES
    ('admin', 'admin', 'administrator'),
    ('ususario', 'usuario', 'user');
