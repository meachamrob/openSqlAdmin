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

    // SQL connexion
    
        $database = new Database();
        $database->connect($db['HOST'],$db['USER'],$db['PASSWORD']);
        $database->select_db($_sql_['database']['name']);
            
    // ---

        $table_name = trim($_sql_['table']['name']);

        if ( $table_name != '' )
        {
            $tables_definitions[$table_name] = array();
            
            $_nbPrimaryKeys = count($database->ARO('SHOW INDEX FROM `'.$table_name.'` where Key_name="PRIMARY"'));
            $_nbPrimaryKeys > 0 ? 
                $_DROP_PRIMARY_KEY = 'DROP PRIMARY KEY ,'   :
                $_DROP_PRIMARY_KEY = ''                     ;
            
            $query['unique_keys']   = array();
            $query['primary_keys']  = 'alter table `'.$table_name.'` '.$_DROP_PRIMARY_KEY.' ADD PRIMARY KEY (';
            $query['create_table']  = 'CREATE TABLE IF NOT EXISTS `'.$_sql_['database']['name'].'`.`'.$table_name.'` (';

            $i = 0;
            
            foreach( $_sql_['table']['column']['name'] as $_ )
            {
                $_columns_names             = $_sql_['table']['column']['name'];
                $_columns_types             = $_sql_['table']['column']['type'];
                $_columns_lengths           = $_sql_['table']['column']['length'];
                $_columns_unsigned          = $_sql_['table']['column']['unsigned'];
                $_columns_auto_increment    = $_sql_['table']['column']['auto_increment'];
                $_columns_primary_key       = $_sql_['table']['column']['primary_key'];
                $_columns_enums             = $_sql_['table']['column']['enum'];
                $_columns_enums_new         = $_sql_['table']['column']['enum_new'];
                $_columns_enums_old         = $_sql_['table']['column']['enum_old'];
                
                $database->drop_indexs($table_name,$_columns_names[$i]);

                if ( trim($_columns_names[$i]) == '' ) { $_column_name = 'column'.$i.''; }
                else { $_column_name = trim($_columns_names[$i]); }
                
                if ( $i > 0 ) $query['create_table'] .= ', ';

                if ( $_columns_lengths[$i] > 0 ) {
                    $query['create_table'] .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . $_columns_lengths[$i] . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . $_columns_lengths[$i] . ') ';
                } else if ( $_columns_enums_new[$i] <> "" ) {
                    $query['create_table'] .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_new[$i]) . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_new[$i]) . ') ';
                } else if ( $_columns_enums[$i] <> "" ) {
                    $query['create_table'] .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_old[$i]) . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . _reformatEnumerations($_columns_enums_old[$i]) . ') ';
                } else {
                    $query['create_table'] .= '`' . $_column_name . '` ' . $_columns_types[$i] . ' ';
                    $table_definition_params = $_columns_types[$i] . ' ';
                }

                // Params column

                if ( $_columns_unsigned[$i] )
                {
                    $query['create_table'] .= 'UNSIGNED ';
                    $table_definition_params .= 'UNSIGNED ';
                }
                
                if ( $_columns_auto_increment[$i] )
                {
                    $query['create_table'] .= 'AUTO_INCREMENT , PRIMARY KEY('.$_column_name.')';
                    $table_definition_params .= 'AUTO_INCREMENT , PRIMARY KEY('.$_column_name.')';
                }

                if ( $_columns_primary_key[$i] == 'PRI' )
                {
                    ($_nbPri == 0) ? 
                        $query['primary_keys'] .= $_columns_names[$i]       :
                        $query['primary_keys'] .= ','.$_columns_names[$i]   ;
                    
                    $_nbPri++;
                } 
                
                else if ( $_columns_primary_key[$i] == 'UNI' )
                {
                    array_push($query['unique_keys'], 'alter table `'.$table_name.'` ADD UNIQUE('.$_columns_names[$i].')');
                }
                
                // ---

                $tables_definitions[$table_name][$_column_name] = $table_definition_params;
                
                $i++;
            }

            $query['create_table']  .= ') CHARACTER SET utf8 engine=MyISAM;';
            $query['primary_keys']  .= ')';

            $database->create_tables($tables_definitions);
            
            foreach ( $query['unique_keys'] as $_query )
            {
                $database->execute($_query);
            }
            
            $database->execute($query['primary_keys']);

            print_r($tables_definitions);
            echo $query['create_table'];
            echo $query['primary_keys'];
            print_r($query['unique_keys']);
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
