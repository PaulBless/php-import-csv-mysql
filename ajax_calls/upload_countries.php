<?php
session_start();

## Add DatabaseConnection File
require_once('../core/DBConnection.php');

// new instance of db class
$db = new DatabaseConnection;
    
if(!empty($_FILES["file"]["name"]))
{
     // Allowed mime types
    $allowedFileTypes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );

    // Validate whether selected file is a CSV file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $allowedFileTypes))
    {
 
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
            {
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

            /** check if country record already exist in table */ 
            // $check_if_country_exist = $db->connection->query("SELECT * FROM tbl_countries WHERE `common_name` = '{$commonName}'");
            // if($check_if_country_exist->num_rows > 0){
            //     echo "country_exists"; return;
            // } 
            
            // add country to db
            $sql = "INSERT INTO `tbl_countries` (`continent_code`, `currency_code`, `iso2_code`, `iso3_code`, `iso_numeric_code`, `fips_code`, `calling_code`, `common_name`, `official_name`, `endonym`, `demonym`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

            // prepare sql query statement
            $statement = $db->connection->prepare($sql);
            $statement->bind_param("sssssssssss", $continentCode, $currencyCode, $isoCode2, $isoCode3, $isoNumericCode, $fipsCode, $callingCode, $commonName, $officialName, $endonym, $demonym);

            // execute query
            $statement->execute();
                   
        }

        fclose($csvFile);
        echo "successful";
        
    } else {
        echo "invalid_file";
    }

} else { echo "empty_file"; }

?>