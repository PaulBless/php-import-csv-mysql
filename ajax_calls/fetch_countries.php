<?php 

// invoke database connection class
require_once('../core/DBConnection.php');

// make new instance of database
$db = new DatabaseConnection;

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (common_name like '%".$searchValue."%' or 
   official_name like '%".$searchValue."%' or 
   endonym like '%".$searchValue."%' or 
   demonym like '%".$searchValue."%' or 
   currency_code like '%".$searchValue."%' or 
   continent_code like'%".$searchValue."%') ";
}

## Total number of records without filtering
$sel = $db->connection->query("select count(*) as allcount from `tbl_countries` ");
$records = $sel->fetch_assoc();
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = $db->connection->query("select count(*) as allcount from `tbl_countries` WHERE 1 ".$searchQuery);
$records = $sel->fetch_assoc();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$countryQuery = "select * from `tbl_countries` WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$countryRecords = $db->connection->query($countryQuery);
$data = array();

    if($countryRecords) {
        while ($row = $countryRecords->fetch_assoc()) {
     
            $data[] = array( 
            "continent_code"=>$row['continent_code'],
            "currency_code"=>$row['currency_code'],
            "iso2_code"=>$row['iso2_code'],
            "iso3_code"=>$row['iso3_code'],
            "iso_numeric_code"=>$row['iso_numeric_code'],
            "fips_code"=>$row['fips_code'],
            "calling_code"=>$row['calling_code'],
            "common_name"=>$row['common_name'],
            "official_name"=>$row['official_name'],
            "endonym"=>$row['endonym'],
            "demonym"=>$row['demonym']
            
            );
        }
     }

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
                                      