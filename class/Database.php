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
    
class Database {

    function __construct()
    {
        $this->database_name = '';
        $this->dbh = '';
    }
    
    // ===========================
    // --- FONCTIONS PUBLIQUES ----------
    // ===========================

    function connect($server,$username,$password)
    {
        $dbh = mysql_connect($server.':3306', $username, $password);

        if (!$dbh) {
            return mysql_errno($dbh) . ': ' . mysql_error($dbh). "\n";
        } else {
            $this->dbh = $dbh;
            return $dbh;
        }

    }

    public function select_db($database_name)
    {
        $db_selected = mysql_select_db($database_name, $this->dbh);

        if (!$db_selected) {
            return mysql_errno($this->dbh) . ': ' . mysql_error($this->dbh). "\n";
        } else {
            $this->database_name = $database_name;
        }
    }
    
    public function select($table_name,$select_start,$select_nb)
    {
        $query = 'SELECT * FROM `'.$this->database_name.'`.`'.$table_name.'` LIMIT '.$select_start.','.$select_nb;
        $results = $this->ARO($query);
        
        return $results;
    }
    
    function create_database($database_name)
    {
        if ( trim($database_name) == '' ) return "ERROR : Missing database name.";
        
        $query = 'CREATE DATABASE IF NOT EXISTS `'.$database_name.'`';
        
        if (mysql_query($query,$this->dbh)) {
            return ("Database \"".$database_name."\" created successfully.");
        } else {
            return ("Error in creating database \"".$database_name."\" \"".$query."\" . ". mysql_error ());
        }
    }

    function create_tables($tables_definitions){

        // ==================================
        // --- TABLES DEFINITIONS EXAMPLE ---
        // ==================================
        {
            $tables_definitions_example = array(
                'Table1' => array(
                    'ID'                    => 'TINYINT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(ID)',
                    'Charset'               => 'char(16) NOT NULL',
                    'online'                => 'TINYINT NOT NULL',
                    'Verify'                => 'varchar(255) NOT NULL',
                    'htmlTitle'             => 'varchar(128) NOT NULL',
                    'htmlDescription'       => 'varchar(64) NOT NULL',
                    'addToAny'              => 'TEXT',
                    'quiksilverStore'       => 'TINYINT NOT NULL',
                    'quiksilverStoreURL'    => 'varchar(255) NOT NULL', 
                    'xtn2'                  => 'TINYINT NOT NULL'
                ),
                'Table2' => array(
                    'ID'                    => 'TINYINT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(ID)',
                    'Base'                  => 'varchar(255) NOT NULL',
                    'Code'                  => 'char(2) NOT NULL'
                )
            );
        }
        // =================================
        // --- CREATE OR UPDATE TABLE(S) ---
        // =================================

            foreach( $tables_definitions as $table => $columns )
            {
                if ($this->_requireUpgrade($table,$tables_definitions))
                {
                    $this->_upgradeTable($table,$tables_definitions);
                }
            }

        // ---
    }
    
    public function drop_table($table_name)
    {
        $query = 'DROP TABLE IF EXISTS `'.$this->database_name.'`.`'.$table_name.'`';
        $results = mysql_query($query,$this->dbh);
        
        return $results;
    }
    
    public function drop_database($database_name)
    {
        $query = 'DROP DATABASE IF EXISTS `'.$database_name.'`';
        $results = mysql_query($query,$this->dbh);
        
        return $query;
    }

    public function ARO($query)
    {
        $results = mysql_query($query,$this->dbh);

        if ( $results )
        {
            $_results = array();
            
            while( $_ = mysql_fetch_object($results) )
            {
                array_push($_results,$_);
            }

            return $_results;
        }

        return array();
    }
    
    public function execute($query)
    {
        $results = mysql_query($query,$this->dbh);
        
        return $results;
    }

    // =========================
    // --- PRIVATE FUNCTIONS ---
    // =========================

    private function _getTables(){
        # Function : Return an array with tables list.
        
        if ( $this->database_name == '' ) return array();
        
        $tables = array();

        $query = 'show tables from `' . $this->database_name . '`';
        
        $results = $this->ARO($query);
       
        foreach ( $results as $result )
        {
            $_table = $result->{'Tables_in_'.$this->database_name};
            array_push($tables,$_table);
        }
        
        return $tables;
    }

    private function _existTable($table_name){
        # Function : Check if the table exist.
        
        $tables = $this->_getTables();
        
        foreach ($tables as $_)
        {
            if ( $_ == $table_name ) return 1;
        }

        return 0;
    }

    public function show_columns($table_name)
    {
        if (($this->database_name == '') || (!$this->_existTable($table_name))) return array();
        
        $query = 'show columns from `'.$this->database_name.'`.`'.$table_name.'`';

        return $this->ARO($query);
    }
    
    private function _existColumn($table_name,$column_name){
        # Function : Check if the column exist. Return a number >=0 if exist else return -1.

        $results = $this->show_columns($table_name);

        $i = 0;
        
        foreach ( $results as $_ )
        {
            if ( $_->Field == $column_name ) return $i;
            $i++;
        }

        return -1;
    }
    
    private function _requireUpgrade($table_name,$tables_definitions){
        # Fonction : Retourne 0 ou 1 pour dire si cette table necessite une mise à niveau.
        
        $colonnes_definition = $tables_definitions[$table_name];
        $colonnes_sql        = $this->show_columns($table_name);
        
        # Si "TABLE" et "__TABLE__" existent un upgrade a été interrompu. (DEV)
        # Un nouvel upgrade est nécessaire.
        
            if (    $this->_existTable($table_name)
                and $this->_existTable('__'.$table_name.'__'))
            {
                return 1;
            }
        
        # Colonnes non ordonnées de la même façon ?
        
            $def['names'] = array();
            
            foreach( $colonnes_definition as $key => $value )
            {
                array_push($def['names'],$key);
            }
            
            $sql['names'] = array();

            foreach( $colonnes_sql as $key => $value )
            {
                array_push($sql['names'],$value->Field);
            }
            
            $result = array_diff_assoc($def['names'], $sql['names']);
            
            if ( count($result) > 0 ) return 1;
        
        # Le nombre de colonnes définies dans "$colonnes_definition" est différent
        # du nombre de colonnes trouvées dans la base de données pour cette table.

            if ( count($colonnes_definition) <> count($colonnes_sql) ) return 1;
            
        # ---
        
        return 0;
    }
    
    private function _upgradeTable($table_name,$tables_definition){

        define('EXECUTE',true);
        
        $colonnes_definition = $tables_definition[$table_name];
        
        # (0) Si les 2 tables "TABLE" et "__TABLE__" existent
        
            if (    $this->_existTable($table_name)
                and $this->_existTable('__'.$table_name.'__'))
            {
                $colonnes_sql = $this->show_columns('__'.$table_name.'__');
            }
            
            else
            {
                $colonnes_sql = $this->show_columns($table_name);
            }
        
        # (1) Si "TABLE" existe et "__TABLE__" n'existe pas, on renomme "TABLE" en "__TABLE__"
        
            $query = 'ALTER TABLE `' . $this->database_name . '`.`' . $table_name . '` RENAME `' . $this->database_name . '`.`__' . $table_name . '__`';
            
            if (     $this->_existTable($table_name)
                and !$this->_existTable('__'.$table_name.'__'))
            {
                if (EXECUTE) mysql_query($query,$this->dbh);
            }
        
        # (2) Si "TABLE" existe on la supprime
        
            $query = 'DROP TABLE IF EXISTS `'.$this->database_name.'`.`'.$table_name.'`';
            
            if (EXECUTE) mysql_query($query,$this->dbh);

        # (3) On créee la nouvelle "TABLE" à partir de sa définition.
            
            foreach( $colonnes_definition as $colonne => $type )
            {
                if( !$this->_existTable($table_name) )
                {
                    $query = 'CREATE TABLE `' . $this->database_name . '`.`' . $table_name . '` (' . $colonne.' ' . $type . ') CHARACTER SET utf8' ;

                    if (EXECUTE) mysql_query($query,$this->dbh);
                }

                else if( $this->_existColumn($table_name,$colonne) == -1 ) 
                {
                    $query = 'ALTER TABLE `' . $this->database_name . '`.`' . $table_name . '` ADD COLUMN `' . $colonne . '` ' . $type ;

                    if (EXECUTE) mysql_query($query,$this->dbh);
                }
            }
        
        # (4) On remplie "TABLE" avec le contenu de "__TABLE__" si les 2 tables existent
        
            if (    $this->_existTable($table_name)
                and $this->_existTable('__'.$table_name.'__'))
            {
                // Récupération des colonnes communes entre les 2 tables "TABLE" et "__TABLE__"
                {
                    $def['names'] = array();
                    
                    foreach( $colonnes_definition as $key => $value )
                    {
                        array_push($def['names'],$key);
                    }
                    
                    $sql['names'] = array();
                    
                    foreach( $colonnes_sql as $key => $value )
                    {
                        array_push($sql['names'],$value->Field);
                    }
                    
                    $colonnes_communes = array_intersect((array)$def['names'], (array)$sql['names']);
                    
                    //var_dump($sql['names']);
                    //var_dump($def['names']);
                    //print_r($colonnes_communes);
                }
                // Copy of the data
                {
                    $colonnes_liste_1 = '';
                    $colonnes_liste_2 = '';
                    
                    $query = '
                        insert into 
                            `'.$this->database_name.'`.`'.$table_name.'`
                            (
                                {{colonnes_liste_1}} 
                            )
                        select 
                            {{colonnes_liste_2}} 
                        from 
                            `'.$this->database_name.'`.`__'.$table_name.'__`
                    ';
                    
                    $i = 0;
                    
                    foreach($colonnes_communes as $colonne_commune)
                    {
                        if ($i > 0) 
                        { 
                            $colonnes_liste_1 .= ',';
                            $colonnes_liste_2 .= ',';
                        }
                        
                        $colonnes_liste_1 .= '`'.$colonne_commune.'`';
                        $colonnes_liste_2 .= '`'.$colonne_commune.'`';
                        
                        $i++;
                    }

                    if ($i > 0)
                    {
                        $query = preg_replace('/\{\{colonnes_liste_1\}\}/',$colonnes_liste_1,$query);
                        $query = preg_replace('/\{\{colonnes_liste_2\}\}/',$colonnes_liste_2,$query);
                        
                        if (EXECUTE) mysql_query($query,$this->dbh);
                    }
                }
                // ---
            }
            
        # (5) Si "TABLE" et "__TABLE__" existent, on supprime "__TABLE__"
        
            $query = 'DROP TABLE IF EXISTS `' . $this->database_name . '`.`__' . $table_name . '__`';
            
            if (    $this->_existTable($table_name)
                and $this->_existTable('__'.$table_name.'__'))
            {
                if (EXECUTE) mysql_query($query,$this->dbh);
            }
            
        # ---
        
    }

}
?>
