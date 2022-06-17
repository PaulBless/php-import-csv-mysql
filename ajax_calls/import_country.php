<?php
session_start();

require_once('../core/DBConnection.php');
// require_once('../core/CountryController.php');

$db = new DatabaseConnection;
    
    $filename = $_FILES["file"]["tmp_name"];    
    if($_FILES["file"]["size"] > 0) {
                
        $file = fopen($filename, "r"); fgetcsv($file);
        if(($file)){
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

            // validate csv data
            $continentCode = mysqli_real_escape_string($db->connection,$getData[0]);
            $currencyCode = mysqli_real_escape_string($db->connection,$getData[1]);
            $isoCode2 = mysqli_real_escape_string($db->connection,$getData[2]);
            $isoCode3 = mysqli_real_escape_string($db->connection,$getData[3]);
            $isoNumericCode = mysqli_real_escape_string($db->connection,$getData[4]);
            $fipsCode = mysqli_real_escape_string($db->connection,$getData[5]);
            $callingCode = mysqli_real_escape_string($db->connection,$getData[6]);
            $commonName = mysqli_real_escape_string($db->connection,$getData[7]);
            $officialName = mysqli_real_escape_string($db->connection,$getData[8]);
            $endonym = mysqli_real_escape_string($db->connection,$getData[9]);
            $demonym = mysqli_real_escape_string($db->connection,$getData[10]);

            // check if country record already exist
            $check_if_country_exist = $db->connection->query("SELECT * FROM tbl_countries WHERE `common_name` = '{$getData[7]}'");
            if($check_if_country_exist->num_rows > 0){
                echo "country_exists"; return;
            }
            
            $sql = "INSERT INTO `tbl_countries` (`continent_code`, `currency_code`, `iso2_code`, `iso3_code`, `iso_numeric_code`, `fips_code`, `calling_code`, `common_name`, `official_name`, `endonym`, `demonym`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";


            // prepare sql query statement
            $statement = $db->connection->prepare($sql);
            $statement->bind_param("sssssssssss", $continentCode, $currencyCode, $isoCode2, $isoCode3, $isoNumericCode, $fipsCode, $callingCode, $commonName, $officialName, $endonym, $demonym);

            // execute query
            if($statement->execute()) {
                echo "upload_success"; return;
            } else { 
                echo "error"; return;
            }
                   
        }
        }

        fclose($file); // close the file reader object

    } else {
        echo "invalid_csv";
    }


?>