CREATE DATABASE `instagram`;

USE `instagram`;

CREATE TABLE `usuarios`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `nome` VARCHAR(255),
    `email` VARCHAR(255),
    `username` VARCHAR(20),
    `password` VARCHAR(128),
    `facebook_id` VARCHAR(255)
);

CREATE TABLE `posts`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `autor` INT NOT NULL,
    `foto` VARCHAR(255),
    `descricao` LONGTEXT,
    `data` DATETIME    
);

CREATE TABLE `comentarios`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `post` INT,
    `autor` INT,
    `descricao` LONGTEXT,
    `data` DATETIME
);

CREATE TABLE `curtidas`(
    `post` INT NOT NULL,
    `usuario` INT NOT NULL,
    `data` DATETIME,
    PRIMARY KEY(`post`,`usuario`)
);

CREATE TABLE `assinaturas`(
    `seguidor` INT NOT NULL,
    `lider` INT NOT NULL,
    `data` DATETIME,
    PRIMARY KEY(`seguidor`,`lider`)
);