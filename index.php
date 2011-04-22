<?php
    /*
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
    
    require_once('configs/db.php');
    require_once('configs/constants.php');
    require_once('languages/en.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>openSqlAdmin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF8" />

        <link rel="icon" type="image/png" href="pics/favicon.png" />

        <link rel="stylesheet" type="text/css" href="./css/defaut.css.php?PREFIX_URL_CSS=./" />
        <link rel="stylesheet" type="text/css" href="./css/dropdown.css.php?PREFIX_URL_CSS=./" />
        <link rel="stylesheet" type="text/css" href="./css/lucid.css.php?PREFIX_URL_CSS=./" />
        <link rel="stylesheet" type="text/css" href="./css/admin.css.php?PREFIX_URL_CSS=./" />

        <script type="text/javascript" src="./js/jquery.min.js"></script>
        <script type="text/javascript" src="./js/jquery-ui.min.js"></script>
        
        <script type="text/javascript" src="./js/dropdown.js"></script>
        
    </head>
    <body>

        <div id="col-left">

            <div class="sidebox">
                <div class="boxhead"><h2><div class="show_titre"><?=_SQL_DATABASES_NAMES?></div><div id="sql_databaseName_loading"></div></h2></div>
                <div class="boxbody">
                    <dl class="dropdown">
                        <dt><a href="#"><span>Select database</span></a></dt>
                        <dd>
                            <ul id="sql_databasesNames"></ul>
                        </dd>
                    </dl>
                    <!-- 
                    <?=_SQL_NEW_DATABASE_NAME?><input type="text" maxsize="32" id="sql_databaseName_new" name="_sql_[database][name]" />
                    -->
                </div>
                <div class="boxfooter"><h2></h2></div>
            </div>

            <div id="sql_tablesNames"></div>
            
        </div>

        <div id="col-right">
            <div id="sql_formCreateTable"</div>
        </div>

        <script type="text/javascript">

            $(document).ready(function() {
                dspDatabases();
            });

            /* ================================================ */
            /* --- DATABASES NAMES : Click on database name --- */
            /* ================================================ */

            $("#sql_databasesNames li").live("click", function()
            {
                var _index  = $("#sql_databasesNames li").index(this);
                var _value  = $(this).html();

                var _html = '';

                _html += '<div class="sidebox">';
                _html += '  <div class="boxhead"><h2><div class="show_titre"><div id="sql_databaseName"></div><div id="sql_tablesNames_loading"></div></h2></div>';
                _html += '  <div class="boxbody">';
                _html += '    <ul></ul>';
                _html += '  </div>';
                _html += '  <div class="boxfooter"><h2></h2></div>';
                _html += '</div>';

                $('#sql_tablesNames').html(_html);
                
                $('#sql_databaseName').html(_value);
                dspTables(_value);
                dspFormCreateTable(_value);

            });

            /* ========================================== */
            /* --- TABLES NAMES : Click on table name --- */
            /* ========================================== */

            $("#sql_tablesNames ul li").live("click", function()
            {                
                var _database_name = $("#sql_databaseName").html(); // @todo : !!! SALE !!!
                
                var _index  = $("#sql_tablesNames ul li").index(this);
                var _value  = $(this).html();

                // On met en surbrillance la table sélectionnée dans la liste des tables :
                $("#sql_tablesNames ul li").removeClass("_selected_");
                $("#sql_tablesNames ul li:eq("+_index+")").addClass("_selected_");

                // ---
                $('#sql_tableColumns').html('');
                $('#sql_tableName_new').val(_value);

                // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                // !!! Le code ci-dessous est a mutualiser avec la possibilité !!!
                // !!! de changer le nom de la table depuis le champs input    !!!
                // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                
                var _html  = $('#sql_tableColumns').html();
                var _value = $('#sql_tableName_new').val();

                $('#sql_tableName_loading').html('<img src="pics/ajax-loader.gif" alt="..." title="..." />');
                
                $.ajax({
                    type: "POST",
                    url: "js/show_columns.php",
                    data: "dirConfigs=<?=_DIR_CONFIGS?>&database_name="+_database_name+"&table_name="+_value,
                    success: function(msg,text){
                        //alert(msg);
                        var results = eval(msg);
                        $('#sql_tableName_loading').html('');
                        
                        if ( results.length > 0 )
                        {
                            dspColumns(results);
                        }
                        
                    }
                });

            });

            /* =============================================== */
            /* --- CREATE TABLE : Click on button [delete] --- */
            /* =============================================== */

            $("#sql_createTable span._delete_").live("click", function()
            {
                var _index  = $("#sql_createTable span._delete_").index(this);

                if (confirm("Delete selected column ?"))
                {
                    $("#sql_createTable li:eq("+_index+")").remove();
                }

            });

            /* =========================================== */
            /* --- CREATE TABLE : Select a column type --- */
            /* =========================================== */

            $("#sql_createTable select").live("change", function()
            {
                var _index  = $("#sql_createTable select.sql_type").index(this);
                var _value  = this.value;

                if (_value.match(/(INT)/)) 
                {
                    $("#sql_createTable span.sql_columnParams:eq("+_index+")").html( _hiddenLength(_value) + _unsigned(0,1) + _autoIncrement(0,1) );
                }

                else if (_value.match(/(FLOAT|DOUBLE|DECIMAL|BLOB|TEXT|DATE|TIME|YEAR)/)) 
                {
                    $("#sql_createTable span.sql_columnParams:eq("+_index+")").html( _hiddenLength(_value) + _unsigned(0,0) + _autoIncrement(0,0) );
                }
                
                else if (_value.match(/(CHAR)/)) 
                {
                    $("#sql_createTable span.sql_columnParams:eq("+_index+")").html( _selectLength(255) + _unsigned(0,0) + _autoIncrement(0,0) );
                }

                else
                {
                    $("#sql_createTable span.sql_columnParams:eq("+_index+")").html("");
                }

                /* --- --- */
                
            } );

            /* ======================================================================= */
            /* --- CREATE TABLE : If the user change the table name in the "input" --- */
            /* ======================================================================= */
            // When the name is changed, it's possible to display an existing table.
            
            $('#sql_tableName_new').live("change", function()
            {
                $('#sql_tableColumns').html('');
                
                var _database_name = $("#sql_databaseName").html(); // @todo : !!! SALE !!!
                
                var _html  = $('#sql_tableColumns').html();
                var _value = $('#sql_tableName_new').val();

                $('#sql_tableName_loading').html('<img src="pics/ajax-loader.gif" alt="..." title="..." />');
                
                $.ajax({
                    type: "POST",
                    url: "js/show_columns.php",
                    data: "dirConfigs=<?=_DIR_CONFIGS?>&database_name="+_database_name+"&table_name="+_value,
                    success: function(msg,text){
                        //alert(msg);
                        var results = eval(msg);
                        $('#sql_tableName_loading').html('');
                        
                        if ( results.length > 0 )
                        {
                            dspColumns(results);
                        }
                        
                    }
                });
                
            });

            /* =============================================== */
            /* --- CREATE TABLE : Click on button [submit] --- */
            /* =============================================== */

            $("#sql_createTable").live("submit", function(event)
            {
                var _database_name = $("#sql_databaseName").html(); // @todo : !!! SALE !!!

                // stop form from submitting normally

                event.preventDefault(); 

                // get values from elements on the form:

                var _url  = $(this).attr( 'action' );
                var _data = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "js/create_table.php",
                    data: _data,
                    success: function(msg,text){
                        $('#sql_tableName_loading').html('');
                        dspTables(_database_name);
                        alert(msg);
                    }
                });

            });

            /* ================= */
            /* --- DATABASES --- */
            /* ================= */

            function dspDatabases()
            {
                $.ajax({
                    type: "POST",
                    url: "js/show_databases.php",
                    data: "dirConfigs=<?=_DIR_CONFIGS?>",
                    success: function(msg,text){
                        var _results = eval(msg);
                        _dspDatabases(_results);
                    }
                });
            }

            function _dspDatabases(databases)
            {
                var _databases = "";
                
                for ( var i = 0 ; i < databases.length ; i++ )
                {
                    _databases += "<li class='_a_'>" + databases[i].Database + "</li>";
                }
                
                $('#sql_databasesNames').html(_databases);
            }

            /* ============== */
            /* --- TABLES --- */
            /* ============== */

            function dspTables(database_name)
            {            
                $.ajax({
                    type: "POST",
                    url: "js/show_tables.php",
                    data: "dirConfigs=<?=_DIR_CONFIGS?>&database_name="+database_name,
                    success: function(msg,text){
                        var _results = eval(msg);
                        _dspTables(database_name,_results);
                    }
                });
            }

            function _dspTables(database_name,tables)
            {
                var _tables = "";
                
                for ( var i = 0 ; i < tables.length ; i++ )
                {
                    _tables += "<li class=\"_a_\">" + tables[i]['Tables_in_'+database_name] + "</li>";
                }
                
                $('#sql_tablesNames ul').html(_tables);
            }

            /* ==================================================== */
            /* --- Afficher les colonnes d\'une table existante --- */
            /* ==================================================== */

            function dspFormCreateTable(_database_name)
            {
                var _html = "";
                
                _html += '<form id="sql_createTable" method="post" action="">';

                _html += '  <input type="hidden" name="dirConfigs"  value="<?=_DIR_CONFIGS?>" />';
                _html += '  <input type="hidden" name="_sql_[database][name]" id="_sql_[database][name]" value="'+_database_name+'" />';

                _html += '  <div class="sidebox">';
                _html += '  <div class="boxhead"><h2><div class="edit_titre"><input type="text" maxsize="32" id="sql_tableName_new" name="_sql_[table][name]" /></div><div id="sql_tableName_loading"></div></h2></div>';
                _html += '      <div class="boxbody">';
                _html += '          <ul id="sql_tableColumns"></ul>';
                _html += '          <p>';
                _html += '              <span class="_a_ _button_" onclick="$(\'#sql_tableColumns\').append(_addColumn(\'\',\'\',\'\',\'\',\'\'));"><?=_SQL_ADD_COLUMN?></span>';
                _html += '              <input type="submit" value="<?=_SQL_EXECUTE?>" />';
                _html += '          </p>';
                _html += '      </div>';
                _html += '      <div class="boxfooter"><h2></h2></div>';
                _html += '  </div>';
                    
                _html += '</form>';

                $('#sql_formCreateTable').html(_html);

                $( "#sql_tableColumns" ).sortable({revert:true});
            
                $( "ul, li" ).disableSelection();
            }

            function dspColumns(columns)
            {
                var _newColumns = '';
                
                for ( var i = 0 ; i < columns.length ; i++ )
                {
                    // Longueur de la colonne :
                    
                        var _start = columns[i].Type.indexOf("(") + 1;
                        var _end   = columns[i].Type.indexOf(")");

                        var _length = columns[i].Type.substring(_start,_end);

                    // Autoincrement :

                        var _auto_increment = 0;
                        
                        if (columns[i].Extra.match(/(auto_increment)/))
                        {
                            _auto_increment = 1;
                        }

                    // Unsigned :

                        var _unsigned = 0;

                        if (columns[i].Type.match(/(unsigned)/))
                        {
                            _unsigned = 1;
                        }
                    
                    // Ajout de la colonne :
                    
                        _newColumns += _addColumn( columns[i].Field , columns[i].Type , _length , _auto_increment , _unsigned );

                    // ---
                }

                $('#sql_tableColumns').html(_newColumns);
            }

            /* ============================== */
            /* --- Html code for 1 column --- */
            /* ============================== */

            function _addColumn(name,type,_length,_auto_increment,unsigned)
            {
                /* --- Select Type --- */
                
                    var _selectDefinition = { 
                        NUMERIC: {
                            ""          :   "",
                            "TINYINT"   : "-127 to 128 or 0 to 255",
                            "SMALLINT"  : "-32768 to 32767 or 0 to 65536",
                            "MEDIUMINT" : "-2^23 to 2^23 or 0 to 2^24",
                            "INT"       : "-2^31 to 2^31 or 0 to 2^32",
                            "BIGINT"    : "-2^63 to 2^63 or 0 to 2^64",
                            "FLOAT"     : "Point décimal de précision simple",
                            "DOUBLE"    : "Point décimal de précision double",
                            "DECIMAL"   : "Point décimal, représenté sous forme de chaine"
                        },
                        STRING: {
                            ""          : "",
                            "VARCHAR"   : "1 to 255",
                            "CHAR"      : "1 to 255",
                            "TINYTEXT"  : "1 to 255",
                            "TEXT"      : "1 to 65536",
                            "MEDIUMTEXT": "1 to 16 777 216",
                            "LONGTEXT"  : "1 to 2^32",
                            "TINYBLOB"  : "1 to 255",
                            "BLOB"      : "1 to 65536",
                            "MEDIUMBLOB": "1 to 16 777 216",
                            "LONGBLOB"  : "1 to 2^32"
                        },
                        "DATE AND TIME": {
                            ""          : "",
                            "DATE"      : "YYYY-MM-DD",
                            "TIME"      : "hh:mm:ss",
                            "DATETIME"  : "YYYY-MM-DD hh:mm:ss",
                            "TIMESTAMP" : "YYYYMMDDhhmmss",
                            "YEAR"      : "YYYY"
                        }
                    }

                    var _select = eval('_selectDefinition');

                    var selectType = "";
                    selectType += "<select class=\"sql_type\" name=\"_sql_[table][column][type][]\">";
                    selectType += "  <option value=\"\">---</option>";

                    for ( var _optGroup in _select )
                    {
                        selectType += "<optgroup label=\"" + _optGroup + "\"";
                        
                        for ( var _typeValue in _select[_optGroup] )
                        {
                            var _tmp  = type.substring(0,type.indexOf("("));
                            var _type = _tmp.toUpperCase();

                            var _selected = "";
                            if ( _type == _typeValue ) { _selected = "selected = \"selected\""; }
                            
                            selectType += "  <option value=\""+_typeValue+"\" "+_selected+" >"+_typeValue+" : "+_select[_optGroup][_typeValue]+"</option>";
                        }
                        
                        selectType += "</optgroup>";
                    }
                    
                    selectType += "</select>";

                /* --- PARAMS : AUTO INCREMENT & UNSIGNED | SELECT LENGTH --- */

                    var _params = "";
                    
                    if (_type.match(/(INT)/)) 
                    {
                        _params = _hiddenLength(_type) + _unsigned(unsigned,1) + _autoIncrement(_auto_increment,1);
                    }

                    else if (_type.match(/(FLOAT|DOUBLE|DECIMAL|BLOB|TEXT|DATE|TIME|YEAR)/)) 
                    {
                        _params = _hiddenLength(_type) + _unsigned(0,0) + _autoIncrement(0,0);
                    }
                    
                    else if (_type.match(/(CHAR)/)) 
                    {
                        _params = _selectLength(_length) + _unsigned(0,0) + _autoIncrement(0,0);
                    }

                /* --- ---*/
            
                newColumn  = "<li class=\"_li_\" style=\"white-space:nowrap\">";
                newColumn += "<span class=\"_a_ _delete_\">[delete] </span>";
                newColumn += "<span class=\"_a_ _drag_\"> [drag] </span>";
                newColumn += "<?=_SQL_COLUMN_NAME?> <input type=\"text\" size=\"8\" maxsize=\"32\" name=\"_sql_[table][column][name][]\" value=\""+name+"\" />";
                newColumn += selectType ;
                newColumn += "<span class=\"sql_columnParams\">"+_params+"</span>";
                newColumn += "</li>";

                return newColumn;
            }

            function _hiddenLength(_type){

                _length = 8;
                
                     if (_type.match(/(BIGINT)/))               { _length = 8;          }
                else if (_type.match(/(MEDIUMINT)/))            { _length = 3;          }
                else if (_type.match(/(SMALLINT)/))             { _length = 2;          }
                else if (_type.match(/(TINYINT)/))              { _length = 1;          }
                else if (_type.match(/(INT)/))                  { _length = 4;          }
                else if (_type.match(/(LONGTEXT|LONGBLOB)/))    { _length = 4294967295; }
                else if (_type.match(/(MEDIUMTEXT|MEDIUMBLOB)/)){ _length = 16777215;   }
                else if (_type.match(/(TINYTEXT|TINYBLOB)/))    { _length = 255;        }
                else if (_type.match(/(TEXT|BLOB)/))            { _length = 65535;      }
                else if (_type.match(/(DATE|TIME|YEAR)/))       { _length = 0;          }
                
                return "Length(" + _length + ") <input type=\"hidden\" name = \"_sql_[table][column][length][]\" value = \"" + _length + "\" />";
            }
        
            function _selectLength(_length){

                var _selectDefinition = {
                    "<?=_SQL_COLUMN_LENGTH?>": {
                        "1"     : "1",
                        "2"     : "2",
                        "3"     : "3",
                        "4"     : "4",
                        "8"     : "8",
                        "16"    : "16",
                        "32"    : "32",
                        "64"    : "64",
                        "128"   : "128",
                        "255"   : "255"
                    }
                }

                var _select = eval('_selectDefinition');

                var selectLength = "";
                selectLength += "<select class=\"sql_length\" name=\"_sql_[table][column][length][]\">";
                selectLength += "  <option value=\"255\">---</option>";

                for ( var _optGroup in _select )
                {
                    selectLength += "<optgroup label=\"" + _optGroup + "\"";
                    
                    for ( var _lengthValue in _select[_optGroup] )
                    {
                        var _selected = "";
                        if ( _length == _lengthValue ) { _selected = "selected = \"selected\""; }
                        
                        selectLength += "  <option value=\""+_lengthValue+"\" "+_selected+" >"+_select[_optGroup][_lengthValue]+"</option>";
                    }
                    
                    selectLength += "</optgroup>";
                }
                
                selectLength += "</select>";

                return selectLength;
            }

            function _autoIncrement(isChecked,editable)
            {
                var _autoIncrement = "";

                if ( editable == 1 )
                {
                    var _checked = "";
                    
                    if ( isChecked == 1 ) { _checked = " checked=\"checked\""; }
                    
                    _autoIncrement += "<?=_SQL_AUTO_INCREMENT?> <input type=\"radio\" name=\"_sql_[table][column][auto_increment][]\" "+_checked+"/>";
                }

                else
                {
                    _autoIncrement += "<input type=\"hidden\" name=\"_sql_[table][column][auto_increment][]\" value = \"\" />";
                }
                
                return _autoIncrement;
            }

            function _unsigned(isChecked,editable)
            {
                var _unsigned = "";

                if ( editable == 1 )
                {
                    var _checked = "";

                    if ( isChecked == 1 ) { _checked = " checked=\"checked\""; }
                    
                    _unsigned += "<?=_SQL_UNSIGNED?> <input type=\"checkbox\" name=\"_sql_[table][column][unsigned][]\" value=\"1\" "+_checked+" />";
                }

                else
                {
                    _unsigned += "<input type=\"hidden\" name=\"_sql_[table][column][unsigned][]\" value=\"0\" />";
                }

                return _unsigned;
            }
            
        </script>
