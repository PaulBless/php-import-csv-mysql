<?php
session_start();

require_once('../core/DBConnection.php');
require_once('../core/CountryController.php');

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
            $isoCode = mysqli_real_escape_string($db->connection,$getData[0]);
            $isoNumericCode = mysqli_real_escape_string($db->connection,$getData[1]);
            $commonName = mysqli_real_escape_string($db->connection,$getData[2]);
            $officialName = mysqli_real_escape_string($db->connection,$getData[3]);
            $symbol = mysqli_real_escape_string($db->connection,$getData[4]);

            // check if currency record already exist in db
            $check_if_country_exist = $db->connection->query("SELECT * FROM `tbl_currencies` WHERE `common_name` = '{$getData[2]}'");
            if($check_if_country_exist->num_rows > 0){
                echo "Currency '".$commonName."' Already Exists"; return;
            } 
            
            // add country to db
            $sql = "INSERT INTO `tbl_currencies` (`iso_code`, `iso_numeric_code`, `common_name`, `official_name`, `symbol`) VALUES (?,?,?,?,?)";

            // prepare sql query statement
            $statement = $db->connection->prepare($sql);
            $statement->bind_param("sssss", $isoCode, $isoNumericCode, $commonName, $officialName, $symbol);

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