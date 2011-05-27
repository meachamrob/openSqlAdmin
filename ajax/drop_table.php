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
     * drop_table.php
     *
     * @param $dirConfigs
     * @param $database_name
     * @param $table_name
     * @param $where_sql
     * 
     * @return String
     * 
     * */
     
        $dirConfigs     = $_POST['dirConfigs'];
        $database_name  = trim($_POST['database_name']);
        $table_name     = trim($_POST['table_name']);

    // Loading configuration file(s) :

        require_once( $dirConfigs . '/db.php' );
        require_once( '../class/Database.php' );
    
    // Connexion SQL :
    
        $database = new Database();
        $dbh = $database->connect($db['HOST'],$db['USER'],$db['PASSWORD']);
        
        if (!$dbh) exit;
    
    // Select DB :
    
        $database->select_db($database_name);
        
    // Drop table :
        
        $result = $database->drop_table($table_name);
        
        echo $result;
?>
