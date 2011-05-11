<?php
    /*
    Copyright 2011 Thierry BUGEAT
    This file is part of openSqlAdmin.

    openSqlAdmin is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    openSqlAdmin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with openSqlAdmin.  If not, see <http://www.gnu.org/licenses/>.
    */
    
    header("Cache-Control: no-cache, must-revalidate");
    
    /*
     * show_databases.php
     * 
     * @param $dirConfigs
     * 
     * @return JSON String
     * 
     * */
     
     $dirConfigs = $_POST['dirConfigs'];

    // Loading configuration file(s) :

        if ( file_exists($dirConfigs . '/db.php') ) 
        {
            require_once( $dirConfigs . '/db.php' );
        } 
        
        else 
        {
            echo '[{"Database":"ERROR loading configuration file \"configs/db.php\". Please check the constant \"_DIR_CONFIGS\" in the file \"configs/constants.php\""}]';
            exit;
        }
        
    // Connexion SQL :

        $dbh = mysql_connect($db['HOST'],$db['USER'],$db['PASSWORD']);

        if (!$dbh) {
            echo '[{"Database":"ERROR MySQL connection. Please check your MySQL configuration in file \"configs/db.php\""}]';
            exit;
        }

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

        if ( function_exists('json_encode') ) {
            echo json_encode($databases);
        } else {
            echo '[{"Database":"ERROR Function \"json_encode\" do not exist."}]';
        }
?>
