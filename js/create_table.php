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
     * create_table.php
     *
     * @param $dirConfigs
     * @param $_sql_ ( Table definition )
     * 
     * @return String
     * 
     * */
     
        $dirConfigs = $_POST['dirConfigs'];
        $_sql_      = $_POST['_sql_'];

    // Loading configuration file(s) :

        require_once( $dirConfigs . '/db.php' );
        require_once( '../class/Database.php' );

    // ---

        $table_name = trim($_sql_['table']['name']);

        if ( $table_name != '' )
        {
            $tables_definitions[$table_name] = array();
            
            $query = 'CREATE TABLE IF NOT EXISTS `'.$_sql_['database']['name'].'`.`'.$table_name.'` (';

            $i = 0;
            
            foreach( $_sql_['table']['column']['name'] as $_ )
            {
                $_columns_names             = $_sql_['table']['column']['name'];
                $_columns_types             = $_sql_['table']['column']['type'];
                $_columns_lengths           = $_sql_['table']['column']['length'];
                $_columns_unsigned          = $_sql_['table']['column']['unsigned'];
                $_columns_auto_increment    = $_sql_['table']['column']['auto_increment'];
                $_columns_enums             = $_sql_['table']['column']['enum'];
                $_columns_enums_new         = $_sql_['table']['column']['enum_new'];
                $_columns_enums_old         = $_sql_['table']['column']['enum_old'];

                if ( trim($_columns_names[$i]) == '' ) { $_column_name = 'column'.$i.''; }
                else { $_column_name = trim($_columns_names[$i]); }
                
                if ( $i > 0 ) $query .= ', ';

                if ( $_columns_lengths[$i] > 0 ) {
                    $query .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . $_columns_lengths[$i] . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . $_columns_lengths[$i] . ') ';
                } else if ( $_columns_enums_new[$i] <> "" ) {
                    $query .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_new[$i]) . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_new[$i]) . ') ';
                } else if ( $_columns_enums[$i] <> "" ) {
                    $query .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_old[$i]) . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_old[$i]) . ') ';
                } else {
                    $query .= '`' . $_column_name . '` ' . $_columns_types[$i] . ' ';
                    $table_definition_params = $_columns_types[$i] . ' ';
                }

                // Params column

                if ( $_columns_unsigned[$i] )
                {
                    $query .= 'UNSIGNED ';
                    $table_definition_params .= 'UNSIGNED ';
                }
                
                if ( $_columns_auto_increment[$i] )
                {
                    $query .= 'AUTO_INCREMENT , PRIMARY KEY('.$_column_name.')';
                    $table_definition_params .= 'AUTO_INCREMENT , PRIMARY KEY('.$_column_name.')';
                }
                
                // ---

                $tables_definitions[$table_name][$_column_name] = $table_definition_params;
                
                $i++;
            }

            $query .= ') CHARACTER SET utf8;';

            $database = new Database();
            $database->connect($db['HOST'],$db['USER'],$db['PASSWORD']);
            $database->select_db($_sql_['database']['name']);
            $database->create_tables($tables_definitions);

            //print_r($tables_definitions);
            //echo $query;
            echo "Create/update table ended";
        }

        else
        {
            echo 'ERROR : Missing table name';
        }
        
        function _reformatEnumerations($_enumerations){
            $_enums = preg_split("/[\s,]+/", $_enumerations);
            
            $_out = "";
            
            foreach( $_enums as $_enum )
            {
                $_enum = preg_replace('/\'/','',$_enum);
                if ( $i > 0 ) $_out .= ",";
                $_out .= "'".$_enum."'";
                $i ++;
            }
            
            return $_out;
        }
        
?>
