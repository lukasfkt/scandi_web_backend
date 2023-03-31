/* Create database */
CREATE DATABASE scandiweb_assignment;

/* Use database */
USE scandiweb_assignment;

/* Create a table called products */
CREATE TABLE products 
(id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 sku VARCHAR(255) NOT NULL, 
 name VARCHAR(255) NOT NULL, 
 price DECIMAL(20,2) NOT NULL,
 weight DECIMAL(20,2) NULL, 
 size INT(20) NULL, 
 dimensions VARCHAR(255) NULL);
