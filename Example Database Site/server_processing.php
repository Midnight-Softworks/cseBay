<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

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
    array( 'db' => 'listingID', 'dt' => 1)



);

// SQL server connection information
$sql_details = array(
    'user' => 'sfs111',
    'pass' => 'HVmZz09bl_FkQ_uv',
    'db'   => 'sfs111',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );


$result =  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns);
$out = $result;

echo json_encode($out);