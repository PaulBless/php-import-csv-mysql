<?php

session_start();
error_reporting(1);


$get_host = $_POST['server_host'];
$get_db_password = $_POST['db_password'];
$get_db_username = $_POST['db_username'];
$get_db_name = $_POST['db_name'];


if(isset($get_host) && isset($get_db_name) && isset($get_db_username)){
	
  // set connection string
  $link = new mysqli($get_host,$get_db_username,$get_db_password);
  if($link->connect_errno > 0){
    echo "conn_error";  // server connection error
    return;
  }else{

  // Create Database if Not Exists on Server
  $db_sql = "CREATE DATABASE IF NOT EXISTS `import_csv_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
  $link->query($db_sql);  // create the database

  mysqli_select_db($link,"import_csv_db"); // select the created database

  // Create Countries Table 
  $country_sql = "CREATE TABLE IF NOT EXISTS `tbl_countries` (
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;";
    $link->query($country_sql);

  // Create Currencies Table
  $currency_sql = "CREATE TABLE IF NOT EXISTS `tbl_currencies` (
  `currency_id` INT(11) NOT NULL AUTO_INCREMENT,
  `iso_code` VARCHAR(5) NOT NULL,
  `iso_numeric_code` VARCHAR(5) NOT NULL,
  `common_name` VARCHAR(255) NOT NULL,
  `official_name` VARCHAR(255) NOT NULL,
  `symbol` VARCHAR(5) NOT NULL,
    PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;";
  $link->query($currency_sql);


    echo "success";
    
  }

}else{
    echo "invalid_settings";

}




?>