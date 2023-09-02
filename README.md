# Aooty


## MySQL database creation:

create database aooty;

create table users(
    -> id INT AUTO_INCREMENT PRIMARY KEY,
    -> name VARCHAR(200) NOT NULL,
    -> surname VARCHAR(200) NOT NULL,
    -> email VARCHAR(200) NOT NULL UNIQUE,
    -> password VARCHAR(200) NOT NULL,
    -> token VARCHAR(200) NOT NULL,
    -> status BOOLEAN DEFAULT 0) ENGINE = InnoDB;
