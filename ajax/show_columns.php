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
     * show_columns.php
     * 
     * @param $dirConfigs
     * @param $database_name
     * @param $table_name
     * 
     * @return JSON String
     * 
     * */
     
     $dirConfigs    = $_POST['dirConfigs'];
     $database_name = $_POST['database_name'];
     $table_name    = $_POST['table_name'];

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
