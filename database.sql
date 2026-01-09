CREATE DATABASE dynamy CHARACTER SET utf8mb4;
USE dynamy;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('image','video','audio','document') NOT NULL,
    filename VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
