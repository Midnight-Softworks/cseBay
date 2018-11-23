<?php

// DB table to use
$table = 'cseBay_Listings';

// Table's primary key
$primaryKey = 'listingID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'itemName', 'dt' => 0 ),
    array( 'db' => 'listingID', 'dt' => 1),
    array( 'db' => 'startingBid', 'dt' => 2),
    array( 'db' => 'currentBid', 'dt' => 3),
    array( 'db' => 'numberOfBids', 'dt' => 4),
    array( 'db' => 'endDate', 'dt' => 5)



);
include 'login.php';
// SQL server connection information
$sql_details = array(
    'user' => $un,
    'pass' => $pw,
    'db'   => $db,
    'host' => $hn
);

require( 'ssp.class.php' );

$result = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns);

echo json_encode($result);