<?php
    
    // * Check if Required Database for the Application is Installed on Server
    $link = mysqli_connect('localhost', 'root', '');
    
    if (!$link) {
        die('Server Not Connected, MySQL Not Installed: '. mysqli_connect_error($link));
        echo "<script>alert('Sorry, MySQL Server Not Found...' );</script>";
    }else{
        
        // select database
        $db_selected = mysqli_select_db($link, 'import_csv_db');
        if (!$db_selected) {
            echo "<script>alert('Required database for application not found.. Click OK to install now!'); window.location.href='install.php';</script>";
        }
    }

    require_once('core/DBConnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import CSV Project</title>

    <!-- Import Frontend Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Import DataTables from CDN-->
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- Import Sweet-alert cdn -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind Css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
        theme: {
            extend: {
            colors: {
                clifford: '#da373d',
            }
            }
        }
        }
    </script>

</head>

<body>
    
    <h1 class="text-3xl font-bold text-center underline bg-gray-100 text-clifford p-4" >
        Import CSV to Database
    </h1>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">Countries Table</div>
                    
                    <div class="col-md-3">
                        <button class="btn btn-info country-btn mt-3 mb-3 ml-4 mr-4" data-toggle="modal" data-target="#importCountryModal">Import Countries CSV</button>
                    </div>
                  
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover table-bordered m-0 table-centered table-responsive nowrap w-100 " id="countries-table" >
                            <thead class='bg-light'>
                                <th>Continent Code</th>
                                <th>Currency Code</th>
                                <th>ISO Code 2</th>
                                <th>ISO Code 3</th>
                                <th>ISO Numeric Code</th>
                                <th>Fips Code</th>
                                <th>Calling Code</th>
                                <th>Common Name</th>
                                <th>Official Name</th>
                                <th>Endonym</th>
                                <th>Demonym</th>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                        </div>
                        <!-- table end -->
                    </div>

                </div>
            </div>
        </div>
        
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">Currencies Table</div>
                   
                    <div class="col-md-3">
                        <a class='btn btn-warning mt-3 mb-3 ml-4 mr-4' href="#importCurrencyModal" data-toggle="modal">Import Currencies CSV</a>
                    </div>
                    
                    
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover table-responsive" id="currencies-table" >
                            <thead class="bg-light">
                                <th>ISO Code 2</th>
                                <th>ISO Numeric Code</th>
                                <th>Common Name</th>
                                <th>Official Name</th>
                                <th>Symbol</th>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                        </div>
                        <!-- table end -->
                    </div>

                </div>
            </div>
        </div>

    <!-- Country Modal Dialog  -->
     <div class="modal fade" id="importCountryModal" tabindex="-1" role="dialog" aria-labelledby="conveyanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h6 class="modal-title text-white font-weight-bold" id="conveyanceModalLabel">Choose Country CSV</h6>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="forms-sample" method="POST" id="upload_country_form" enctype="multipart/form-data">
                  
                    <div class="form-group">
                        <label>Select File </label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls, .csv" required/>
                    </div>
                            
                </div>
                <div class="modal-footer">
                  <button type="submit" name="upload" class="btn btn-success mr-3" style="background-color:#28a745!important">Upload File</button>
                  <button type="button" class="btn btn-secondary bg-secondary " data-dismiss="modal">Close</button>
              </form> </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Currency Upload Modal -->
    <div class="modal fade" id="importCurrencyModal" tabindex="-1" role="dialog" aria-labelledby="conveyanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h6 class="modal-title text-white font-weight-bold" id="conveyanceModalLabel">Choose Currency CSV</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="forms-sample" method="POST" id="upload_currency_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Select File </label>
                        <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls, .csv" required/>
                    </div>
                            
                </div>
                <div class="modal-footer">
                  <button type="submit" name="upload" class="btn btn-success mr-3" style="background-color:#28a745!important">Upload File</button>
                  <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
              </form>
            </div>
          </div>
        </div>
    </div>
    <!-- end -->

    </div>
   
    <script type="text/javascript">
        
        // fetch the list of countries
        function getCountries() {
            
            $('#countries-table').dataTable({
            paging: true,
            searching: true,
            "bDestroy": true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
            'url': 'ajax_calls/fetch_countries.php'
                },
            'columns': [
                {
                    data: 'continent_code'
                },
                {
                    data: 'currency_code'
                },
                {
                    data: 'iso2_code'
                },
                {
                    data: 'iso3_code'
                },
                {
                    data: 'iso_numeric_code'
                },
                {
                    data: 'fips_code'
                },
                {
                    data: 'calling_code'
                },
                {
                    data: 'common_name'
                }, 
                {
                    data: 'official_name'
                },  
                {
                    data: 'endonym'
                },
                {
                    data: 'demonym'
                }
                ]
            });
        }
        
        // fetch list of currencies
        function getCurrencies() {
            // hide the upload file modal
            $('#importCurrencyModal').trigger('reset');
            $('#importCurrencyModal').modal('hide');

            $('#currencies-table').dataTable({
            paging: true,
            searching: true,
            "bDestroy": true,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
            'url': 'ajax_calls/fetch_currencies.php'
                },
            'columns': [
                {
                    data: 'iso_code'
                },
                {
                    data: 'iso_numeric_code'
                },
                {
                    data: 'common_name'
                }, 
                {
                    data: 'official_name'
                },  
                {
                    data: 'symbol'
                }
                ]
            });
        }

        $(document).ready(function(e){

            getCountries(); // load countries record
            getCurrencies(); // load currencies record

            $(document).on('click','.country-btn', function(event) {
                // $('#importCountryModal').modal('show');
            });

            // trigger upload country csv
            $('#upload_country_form').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'ajax_calls/upload_countries.php',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('.btn-success').attr("disabled","disabled");
                        $('.btn-success').text("uploading..");
                        $('#upload_country_form').css("opacity",".5");
                    },
                    success: function(response) { 
                        console.log(response);
                        if(response =='invalid_file')  
                         {  
                            swal.fire('INVALID FILE', 'The Uploaded File is an Invalid CSV Format', 'error'); 
                         }  
                         else if(response == "empty_file")  
                         {  
                            swal.fire("ERROR!","Please Select CSV File","warning");  
                            $('#upload_country_form').css("opacity","");
                            $(".btn-success").removeAttr("disabled"); 
                         }                           
                         else if(response == "successful")  
                         {  
                            //   alert("CSV File Data has been Imported Successfully");
                            swal.fire(
                            'BRAVO!!', 
                            'CSV File Data has been Imported Successfully..<br><b>Notice</b> Click OK button to reload the page!', 'success').then(function() {
                                getCountries();  
                                window.location.href = 'index.php';
                            }); 
                         }  
                         else  
                         {  
                             // do nothing  
                         }  

                        //reset form state
                        $('#upload_country_form').css("opacity","");
                        $(".btn-success").removeAttr("disabled");
                        $(".btn-success").text("Upload FIle");
                    }
                });
            });

            // trigger submit function of upload currency csv
            $('#upload_currency_form').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'ajax_calls/upload_currencies.php',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                        $('.btn-success').attr("disabled","disabled");
                        $('.btn-success').text("uploading..");
                        $('#upload_currency_form').css("opacity",".5");
                    },
                    success: function(response) { 
                        console.log(response);
                        if(response =='invalid_file')  
                         {  
                            swal.fire('INVALID FILE', 'The Uploaded File is an Invalid CSV Format', 'error'); 
                         }  
                         else if(response == "empty_file")  
                         {  
                            swal.fire("ERROR!","Please Select CSV File","warning");  
                            $('#upload_currency_form').css("opacity","");
                            $(".btn-success").removeAttr("disabled"); 
                         }                           
                         else if(response == "successful")  
                         {  
                            //   alert("CSV File Data has been Imported Successfully");
                            swal.fire(
                            'BRAVO!!', 
                            'CSV File Data has been Imported Successfully..<br><b>Notice</b> Click OK button to reload the page!', 'success').then(function() {
                                getCurrencies();  
                                window.location.href='index.php';
                            }); 
                            
                         }  
                         else  
                         {  
                             // do nothing  
                         }  

                        //reset form state
                        $('#upload_currency_form').css("opacity","");
                        $(".btn-success").removeAttr("disabled");
                        $(".btn-success").text("Upload FIle");
                    }
                });
            });


        });
    </script>
</body>
</html>