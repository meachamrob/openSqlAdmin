<?php
    header("Cache-Control: no-cache, must-revalidate");

    /*
     * show_columns.php
     * 
     * @param $dirConfigs
     * @param $database_name
     * @param $table_name
     * 
     * @return JSON String
     * 
     * */

    // Loading configuration file(s) :

        require_once( $dirConfigs . '/db.php' );
        
    // Connexion SQL :
    
        $dbh = mysql_connect($db['HOST'],$db['USER'],$db['PASSWORD']) or die (mysql_error());

        if (!$dbh) exit;

    // ---

        $columns = array();

        $query = 'show columns from `'.$database_name.'`.`'.$table_name.'`';

        $results = mysql_query($query,$dbh);

        if ( $results )
        {
            while( $_ = mysql_fetch_object($results) )
            {
                array_push($columns,$_);
            }
        }
        
    // ---

        echo json_encode($columns);
?>
