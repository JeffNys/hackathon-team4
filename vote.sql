SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE account 
( `id` INT NOT NULL auto_increment PRIMARY KEY,
`email` VARCHAR(255) NOT NULL,
`password` TEXT NOT NULL,
`nom` VARCHAR(255) NOT NULL,
`prenoms` VARCHAR(255) NOT NULL,
`id_verif` INT NULL,
`id_cripte` TEXT NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE pseudo
(
    `id` INT NOT NULL auto_increment PRIMARY KEY,
    `id_cripte` TEXT NOT NULL,
    `id_bulletin` INT NULL,
    `id_loi` INT NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE ballot
(
    `id` INT NOT NULL auto_increment PRIMARY KEY,
    `id_loi` INT NOT NULL,
    `date` DATE NOT NULL,
    `vote` INT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE law
(
    `id` INT NOT NULL auto_increment PRIMARY KEY,
    `url_loi` VARCHAR(255) NOT NULL,
    `titre_principal` TEXT NOT NULL,
    `date_vote` DATE NULL,
    `date_depot` DATE NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;