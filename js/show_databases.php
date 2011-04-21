<?php
    header("Cache-Control: no-cache, must-revalidate");

    /*
     * show_databases.php
     * 
     * @param $dirConfigs
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

        $databases = array();

        $query = 'show databases';

        $results = mysql_query($query,$dbh);

        if ( $results )
        {
            while( $_ = mysql_fetch_object($results) )
            {
                array_push($databases,$_);
            }
        }
        
    // ---

        echo json_encode($databases);
?>
