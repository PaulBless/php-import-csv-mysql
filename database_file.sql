-- AUTHOR DETAILS
-- Name: Paul Eshun
-- Role:  Software Developer
-- Email: eshunbless1@gmail.com
-- Linkedin Profile: https://linkedin.com/in/paul-eshun

-- Description: Countries & Currencies Database Script


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
-- ---------------------------


-- Create Database
CREATE DATABASE IF NOT EXISTS `import_csv_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Select Database
USE `import_csv_db`;


-- Table Structure for Countries
CREATE TABLE IF NOT EXISTS `tbl_countries` (
  `country_id` INT(11) NOT NULL AUTO_INCREMENT,
  `continent_code` VARCHAR(5) NOT NULL,
  `currency_code` VARCHAR(5) NOT NULL,
  `iso2_code` VARCHAR(5) NOT NULL,
  `iso3_code` VARCHAR(5) NOT NULL,
  `iso_numeric_code` VARCHAR(5) NOT NULL,
  `fips_code` VARCHAR(5) NOT NULL,
  `calling_code` VARCHAR(5) NOT NULL,
  `common_name` VARCHAR(255) NOT NULL,
  `official_name` VARCHAR(255) NOT NULL,
  `endonym` VARCHAR(255) NOT NULL,
  `demonym` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;


-- Table Structure for Currencies
CREATE TABLE IF NOT EXISTS `tbl_currencies` (
  `currency_id` INT(11) NOT NULL AUTO_INCREMENT,
  `iso_code` VARCHAR(5) NOT NULL,
  `iso_numeric_code` VARCHAR(5) NOT NULL,
  `common_name` VARCHAR(255) NOT NULL,
  `official_name` VARCHAR(255) NOT NULL,
  `symbol` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

