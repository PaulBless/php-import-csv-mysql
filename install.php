 
<?php 

    // * Check if Application Database Exists on Server
    $link = mysqli_connect('localhost', 'root', '');

    // if (!$link) {
    //     echo "<script>alert('Sorry, MySQL Server Not Found...' ); </script>";
    //     die('ERROR: ' . mysqli_connect_error($link));
    // }else{
    //     // set the current db_file name
    //     $db_selected = mysqli_select_db($link, 'import_csv_db');
    //     if ($db_selected) {
    //         echo "<script>window.location.href='index.php';</script>";
    //     }
    // }

    // Get Post Data
    $server = "localhost";
    $database_name = "import_csv_db";
    $database_username = "root";
    $database_password = "";
    

?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
    <title>Import CSV | Install DB </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="how to import csv file into database using php/mysql" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- App css -->
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



    <style type="text/css">

            /* page loading style */
            #preloader{
                position:fixed;top:0;left:0;right:0;bottom:0;background-color:#fff;z-index:9999;
            }
            #status{
                width:40px;height:40px;position:absolute;left:50%;top:50%;margin:-20px 0 0 -20px;
            }
            .spinner{
                margin:0 auto;font-size:10px;position:relative;text-indent:-9999em;border-top:5px solid #dee2e6;border-right:5px solid #dee2e6;border-bottom:5px solid #dee2e6;border-left:5px solid #5089de;-webkit-transform:translateZ(0);transform:translateZ(0);-webkit-animation:SpinnerAnimation 1.1s infinite linear;animation:SpinnerAnimation 1.1s infinite linear;
            }
            .spinner,.spinner:after{
                border-radius:50%;width:40px;height:40px;
            }
            @-webkit-keyframes SpinnerAnimation{0%{-webkit-transform:rotate(0); transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}
            }
            @keyframes SpinnerAnimation{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}

    </style>


</head>

    <body class="page-bg">
          

        <div class="account-pages mt-4 mb-4">
            <div class="container">
                <div class="row justify-content-center ">
                    <div class="col-md-8 col-lg-6 col-xl-5 ">
                        <div class="card " >

                            <div class="card-body p-4 ">
                                
                                <h5 class="text-3xl font-bold text-center underline bg-blue-100 text-clifford p-4 m-3" > Install Database </h5> 

                                <form id="install_form" method="POST" name="installfrm" >

                                    <div class="form-group mb-1">
                                        <label for="server">Server Host</label>
                                        <input type="text" class="form-control form-control-md border-left-1 text-dark" id="server" name="server_host" value="<?php echo $server; ?>" readonly>                        
                                    </div>
                                    
                                    <div class="form-group mb-1">
                                        <label for="db_username"> Database Username:</label>
                                        <input type="text" class="form-control form-control-md border-left-1 text-dark" id="db_username" name="db_username" value="<?php echo $database_username; ?>" readonly>                        
                                    </div> 
                                    
                                    <div class="form-group mb-1">
                                        <label for="db_password">Database Password: </label>
                                        <input type="text" class="form-control form-control-md border-left-1 text-dark" id="db_password" name="db_password" value="<?php echo $database_password; ?>" readonly>                        
                                    </div>

                                    <div class="form-group mb-3 pass">
                                        <label for="db_name">Database Name:</label>
                                        <input type="text" class="form-control form-control-md border-left-1 text-dark" id="db_name" name="db_name" value="<?php echo $database_name; ?>" readonly>                        
                                    </div>

                                    <div class="form-group mb-0 text-center" >
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" type="submit" id="submit_button" data-style="slide-up"> Install DB </button>
                                    </div>

                                </form><!-- end form -->

                            </div> <!-- end card body -->
                        </div>
                        <!-- end card -->

                        
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


       

        

        <script>
            $(document).ready(function(e) {


                 $("#install_form").submit(function(e) {                    

                    e.preventDefault();
                    var formdata = $(this).serialize();

                    $('#submit_button').text("processing..");

                    $.ajax({
                        url: 'ajax_calls/install_db.php',
                        type: 'POST',
                        data: formdata,
                        success: function(res) {
                            console.log(res);

                            if (res === "success") {
                                Swal.fire('Success','Database Installed Successfully... Click OK to Continue', 'success').then(function(){
                                    window.location.href = 'index.php';
                                });
                                
                            } else if (res === "invalid_settings") {
                                Swal.fire(
                                    'Installation Error', 
                                    'Database Could not be Installed, Invalid Settings, Try Again!', 
                                    'error'
                                );
                            }else if(res === 'conn_error') {
                                swal.fire('Error','Database Connection Failed!','error')
                            }

                        },
                        error: function(res) {
                            console.log(res);
                        }

                    });

                });

            });
            
        </script>


    </body>
</html>

