<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>cseBay</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.js"></script>
    <link rel="icon" href="logo.png"/>




</head>

<body>
<?php include 'header.php' ?>




    <table class="table table-striped table-hover" id="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>ID</th>
            <th>Starting Bid</th>
            <th>End</th>
        </tr>
        </thead>




    </table>

    <script>
        $(document).ready(function() {
            // DataTable
            var table = $('#table').DataTable({
                "serverSide": true,
                "select": true,
                "ajax":{
                    "url": 'server_processing.php'
                },


                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": {"className": "dt-center", "targets": "_all"}

            } );
            table
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = table.rows( indexes ).data().toArray();
                    window.location = "editListing.php?&listingID="+rowData[0][1];
                } );




        } );

    </script>


</body>