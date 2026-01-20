CREATE DATABASE gestion_stock DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestion_stock;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE clients (
  id int(30) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  address text NOT NULL,
  cperson varchar(255) DEFAULT NULL,
  contact varchar(100) DEFAULT NULL,
  status tinyint(1) NOT NULL DEFAULT 1,
  date_created datetime NOT NULL DEFAULT current_timestamp(),
  date_updated datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE produits (
  id int(30) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  description text DEFAULT NULL,
  supplier_id int(30) NOT NULL,
  cost decimal(10,2) NOT NULL DEFAULT 0.00,
  status tinyint(1) NOT NULL DEFAULT 1,
  date_created datetime NOT NULL DEFAULT current_timestamp(),
  date_updated datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY supplier_id (supplier_id),
  KEY status (status),
  CONSTRAINT produits_ibfk_1 FOREIGN KEY (supplier_id) REFERENCES clients (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE stock_list (
  id int(30) NOT NULL AUTO_INCREMENT,
  item_id int(30) NOT NULL,
  quantity int(30) NOT NULL DEFAULT 0,
  unit varchar(50) DEFAULT 'pcs',
  price decimal(10,2) NOT NULL DEFAULT 0.00,
  total decimal(10,2) NOT NULL DEFAULT 0.00,
  type tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Entrée, 2=Sortie',
  date_created datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  KEY item_id (item_id),
  KEY type (type),
  CONSTRAINT stock_list_ibfk_1 FOREIGN KEY (item_id) REFERENCES produits (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE commandes (
  id int(30) NOT NULL AUTO_INCREMENT,
  sales_code varchar(50) NOT NULL,
  client varchar(255) NOT NULL,
  amount decimal(10,2) NOT NULL DEFAULT 0.00,
  remarks text DEFAULT NULL,
  stock_ids text DEFAULT NULL,
  date_created datetime NOT NULL DEFAULT current_timestamp(),
  date_updated datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  UNIQUE KEY sales_code (sales_code),
  KEY client (client(100)),
  KEY date_created (date_created)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE utilisateurs (
  id int(30) NOT NULL AUTO_INCREMENT,
  firstname varchar(100) NOT NULL,
  lastname varchar(100) NOT NULL,
  username varchar(100) NOT NULL,
  password varchar(32) NOT NULL,
  type tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=Commercial',
  date_created datetime NOT NULL DEFAULT current_timestamp(),
  date_updated datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  KEY type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO utilisateurs (firstname, lastname, username, password, type)
VALUES ('Admin', 'Système', 'admin', MD5('admin123'), 1);