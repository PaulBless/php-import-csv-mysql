<?php 

## Add Database File
require_once('../core/DBConnection.php');
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
   iso_code like'%".$searchValue."%') ";
}

## Total number of records without filtering
$sel = $db->connection->query("select count(*) as allcount from `tbl_currencies` ");
$records = $sel->fetch_assoc();
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = $db->connection->query("select count(*) as allcount from `tbl_currencies` WHERE 1 ".$searchQuery);
$records = $sel->fetch_assoc();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from `tbl_currencies` WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$currencyRecords = $db->connection->query($empQuery);
$data = array();

    while ($row = $currencyRecords->fetch_assoc()) {
     
        $data[] = array( 
            "iso_code"=>$row['iso_code'],
            "iso_numeric_code"=>$row['iso_numeric_code'],
           "common_name"=>$row['common_name'],
           "official_name"=>$row['official_name'],
           "symbol"=>$row['symbol']
          
        );
     }


## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
                                      