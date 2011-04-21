<?php
    header("Cache-Control: no-cache, must-revalidate");

    /*
     * create_table.php
     * 
     * @param $_sql_ ( Table definition )
     * 
     * @return String
     * 
     * */

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

                if ( trim($_columns_names[$i]) == '' ) { $_column_name = 'column'.$i.''; }
                else { $_column_name = trim($_columns_names[$i]); }
                
                if ( $i > 0 ) $query .= ', ';

                if ( $_columns_lengths[$i] > 0 ) {
                    $query .= '`' . $_column_name . '` ' . $_columns_types[$i] . '(' . $_columns_lengths[$i] . ') ';
                    $table_definition_params = $_columns_types[$i] . '(' . $_columns_lengths[$i] . ') ';
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
?>
