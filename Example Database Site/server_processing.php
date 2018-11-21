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
$table = '((gamesdb.game LEFT JOIN gamesdb.has_tag ON game.GameID = has_tag.Game_ID) LEFT JOIN gamesdb.tag ON has_tag.Tag_ID = tag.TagID)';

// Table's primary key
$primaryKey = 'GameID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'Game_Name', 'dt' => 0 ),
    array( 'db' => 'Console',  'dt' => 1 ),
    array( 'db' => 'Players',   'dt' => 2 ),
    array( 'db' => 'GameID', 'dt' => 3),
    array( 'db' => 'Tag_Name', 'dt' => 5)


);

// SQL server connection information
$sql_details = array(
    'user' => 'gameDbBot',
    'pass' => 'I!n2V#',
    'db'   => 'gamesdb',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );


$result =  SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns);
$out = $result;
$out['data'] = array();
$distinctCount = 0;
$seen = [];
$tagCount = 0;
foreach($result['data'] as $data){
    if(!in_array($data['3'], $seen)){
        $seen[] = $data['3'];
        $out['data'][] = $data;
        $out['data'][count($seen) - 1]['4'] = "";
        $out['data'][count($seen) - 1]['5'] = "";
        $tagCount = 0;
        $distinctCount++;
    }
    if($tagCount < 3) {
        if(!$tagCount == 0) {
            $out['data'][count($seen) - 1]['4'] .= ", " . $data['5'];
        }
        else{
            $out['data'][count($seen) - 1]['4'] .= $data['5'];
        }

    }
    if(!$tagCount == 0) {
        $out['data'][count($seen) - 1]['5'] .= ", " . $data['5'];
    }
    else{
        $out['data'][count($seen) - 1]['5'] .= $data['5'];
    }
    $tagCount++;
    if($distinctCount > 10) break;
}
echo json_encode($out);