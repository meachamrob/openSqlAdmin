<script type="text/javascript">

    var DatabaseModel = new DatabaseModel();                                    // Custom event "setDatabasesOK"
    
    var _COLUMNS_ = "";
    
    var select_start    = 0;
    var select_nb       = 100;

    var _box_tables = '';

    _box_tables += '<div class="sidebox">';
    _box_tables += '  <div class="boxhead"><h2><div class="show_titre"><div id="sql_databaseName"></div><div id="sql_tablesNames_loading"></div></h2></div>';
    _box_tables += '  <div class="boxbody">';
    _box_tables += '    <p><ul></ul></p>';
    _box_tables += '  </div>';
    _box_tables += '  <div class="boxfooter"><h2></h2></div>';
    _box_tables += '</div>';
    
    var _box_tableContent = '';

    _box_tableContent += '<div class="sidebox">';
    _box_tableContent += '  <div class="boxhead"><h2><div class="show_titre"><?=_SQL_TABLE_CONTENT?></div></h2></div>';
    _box_tableContent += '  <div class="boxbody">';
    _box_tableContent += '    <div id="tableContentButtonRefresh"></div>';
    _box_tableContent += '    <p><ul></ul>&nbsp;</p>';
    _box_tableContent += '  </div>';
    _box_tableContent += '  <div class="boxfooter"><h2></h2></div>';
    _box_tableContent += '</div>';
        
    $(document).ready(function() 
    {
        DatabaseModel.setDatabases();                                           // Custom event "setDatabasesOK"
    });
    
    /* ===================== */
    /* --- Custom Events --- */
    /* ===================== */

    $('body').live("setDatabaseNameOK", function(e, data) { DatabaseModel.setTables(); dspFormCreateTable();    });
    $('body').live("setDatabasesOK",    function(e, data) { dspDatabases();                                     });
    $('body').live("setTablesOK",       function(e, data) { dspTables();                                        });
    $('body').live("dropDatabaseOK",    function(e, data) { DatabaseModel.setDatabases();                       });
    $('body').live("createDatabaseOK",  function(e, data) { DatabaseModel.setDatabases();                       });
    $('body').live("dropTableOK",       function(e, data) { DatabaseModel.setTables();                          });
    $('body').live("createTableOK",     function(e, data) { DatabaseModel.setTables();                          });
    $('body').live("deleteRowOK",       function(e, data) { dspTableContent(select_start,select_nb);            });

    /* ================================================ */
    /* --- DATABASES NAMES : Click on database name --- */
    /* ================================================ */

    $("#sql_databasesNames li span._database_name_ ").live("click", function()
    {
        var _index          = $("#sql_databasesNames li span._database_name_").index(this);
        var _database_name  = $(this).html();
        
        $('#sql_tablesNames').html(_box_tables);
        $('#sql_tableContent').html('');
        $('#sql_databaseName').html(_database_name);
        
        DatabaseModel.setDatabaseName(_database_name);                          // Custom event "setDatabaseNameOK"
    });

    /* ================================================== */
    /* --- DATABASES NAMES : Click on button [delete] --- */
    /* ================================================== */

    $("#sql_databasesNames li div._delete_database_").live("click", function()
    {
        var _index          = $("#sql_databasesNames li div._delete_database_").index(this);
        var _database_name  = $("#sql_databasesNames li span:eq("+_index+")._database_name_").html();
        
        $('#sql_tablesNames').html('');
        $('#sql_formCreateTable').html('');
        $('#sql_tableContent').html('');

        if (confirm("Delete selected database \""+_database_name+"\" ?"))
        {
            DatabaseModel.dropDatabase(_database_name);                         // Custom event "dropDatabaseOK"
        }
    });
    
    /* ============================================================================= */
    /* --- CREATE DATABASE : If the user change the database name in the "input" --- */
    /* ============================================================================= */

    $('#sql_databaseName_new').live("change", function()
    {
        var _value = $('#sql_databaseName_new').val();
    
        $('#sql_tablesNames').html('');
        $('#sql_formCreateTable').html('');
        $('#sql_tableContent').html('');

        if (confirm("Create database \""+_value+"\" ?"))
        {
            DatabaseModel.createDatabase(_value);                               // Custom event "createDatabaseOK"
        }
    });

    /* ========================================== */
    /* --- TABLES NAMES : Click on table name --- */
    /* ========================================== */

    $("#sql_tablesNames ul li span._table_name_").live("click", function()
    {
        var _database_name  = DatabaseModel.getDatabaseName();
        var _index          = $("#sql_tablesNames ul li span._table_name_").index(this);
        var _value          = $(this).html();

        $('#sql_tableContent').html(_box_tableContent);
        $('#sql_tableColumns').html('');
        $('#sql_tableName_new').val(_value);
        
        // Highlight the selected table :
        
        $("#sql_tablesNames ul li").removeClass("_selected_");
        $("#sql_tablesNames ul li:eq("+_index+")").addClass("_selected_");

        // ---
        
        var _html  = $('#sql_tableColumns').html();
        var _value = $('#sql_tableName_new').val();

        $('#sql_tableName_loading').html('<img src="pics/ajax-loader.gif" alt="..." title="..." >');
        
        $.ajax({
            type: "POST",
            url: "ajax/show_columns.php",
            data: "dirConfigs=<?=_DIR_CONFIGS?>&database_name="+_database_name+"&table_name="+_value,
            success: function(msg,text){
                //alert(msg);
                
                DatabaseModel.setTableName(_value);                             // Custom event "setTableNameOK"
                
                var results = eval(msg);
                $('#sql_tableName_loading').html('');
                
                if ( results.length > 0 )
                {
                    _COLUMNS_ = results;
                    dspColumns(results);
                    dspTableContent(select_start,select_nb);
                }
                
            }
        });

    });
    
    /* =============================================== */
    /* --- TABLES NAMES : Click on button [delete] --- */
    /* =============================================== */

    $("#sql_tablesNames ul li div._delete_table_").live("click", function()
    {
        var _index          = $("#sql_tablesNames ul li div._delete_table_").index(this);
        var _table_name     = $("#sql_tablesNames ul li span:eq("+_index+")._table_name_").html();

        if (confirm("Delete selected table \""+_table_name+"\" ?"))
        {
            DatabaseModel.dropTable(_table_name);                               // Custom event "dropTableOK"
        }

    });

    /* =============================================== */
    /* --- CREATE TABLE : Click on button [delete] --- */
    /* =============================================== */

    $("#sql_createTable button._delete_").live("click", function()
    {
        var _index  = $("#sql_createTable button._delete_").index(this);

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
            $("#sql_createTable span.sql_columnParams:eq("+_index+")").html( _hiddenLength(_value) + _hiddenEnum("") + _unsigned(0,0) + _autoIncrement(0,0) );
        }
        
        else if (_value.match(/(CHAR)/)) 
        {
            $("#sql_createTable span.sql_columnParams:eq("+_index+")").html( _selectLength(255) + _hiddenEnum("") + _unsigned(0,0) + _autoIncrement(0,0) );
        }
        
        else if (_value.match(/(ENUM)/)) 
        {
            $("#sql_createTable span.sql_columnParams:eq("+_index+")").html( _hiddenLength(_value) + _inputNewEnum("") + _unsigned(0,0) + _autoIncrement(0,0) );
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
        
        var _database_name  = DatabaseModel.getDatabaseName();
        var _html           = $('#sql_tableColumns').html();
        var _value          = $('#sql_tableName_new').val();

        $('#sql_tableName_loading').html('<img src="pics/ajax-loader.gif" alt="..." title="..." >');
        
        $.ajax({
            type: "POST",
            url: "ajax/show_columns.php",
            data: "dirConfigs=<?=_DIR_CONFIGS?>&database_name="+_database_name+"&table_name="+_value,
            success: function(msg,text){
                //alert(msg);
                var results = eval(msg);
                $('#sql_tableName_loading').html('');

                if ( results.length > 0 )
                {
                    DatabaseModel.setTableName(_value);                         // Custom event "setTableNameOK"
                    _COLUMNS_ = results;
                    dspColumns(results);
                    dspTableContent(select_start,select_end);
                }
                
                else
                {
                    $('#sql_tableColumns').append(_addColumn('','','','','','','',''));
                }
                
            }
        });
        
    });

    /* =============================================== */
    /* --- CREATE TABLE : Click on button [submit] --- */
    /* =============================================== */

    $("#sql_createTable").live("submit", function(event)
    {
        var _database_name = DatabaseModel.getDatabaseName();

        // stop form from submitting normally

        event.preventDefault(); 

        // get values from elements on the form:

        var _url  = $(this).attr( 'action' );
        var _data = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "ajax/create_table.php",
            data: _data,
            success: function(msg,text)
            {
                //alert(msg);
                $('#sql_tableName_loading').html('');
                $('body').trigger('createTableOK','');                          // Custom event "createTableOK"
            }
        });

    });

    /* ================= */
    /* --- DATABASES --- */
    /* ================= */

    function dspDatabases()
    {
        var _databases = DatabaseModel.getDatabases();
        _dspDatabases(_databases);
    }

    function _dspDatabases(databases)
    {
        var _databases = "";
        
        for ( var i = 0 ; i < databases.length ; i++ )
        {
            _databases += "<li><div class=\"_a_ _delete_database_\"><?=_SQL_DELETE_DATABASE?> </div> <span class=\"_a_ _database_name_\">" + databases[i].Database + "</span></li>";
        }
        
        $('#sql_databasesNames').html(_databases);
    }

    /* ============== */
    /* --- TABLES --- */
    /* ============== */

    function dspTables()
    {
        var _database_name = DatabaseModel.getDatabaseName();
        var _tables = DatabaseModel.getTables();
        
        _dspTables(_database_name,_tables);
    }

    function _dspTables(database_name,tables)
    {
        var _tables = "";
        
        for ( var i = 0 ; i < tables.length ; i++ )
        {
            _tables += "<li><div class=\"_a_ _delete_table_\"><?=_SQL_DELETE_TABLE?> </div> <span class=\"_a_ _table_name_\">" + tables[i]['Tables_in_'+database_name] + "</span></li>";
        }
        
        $('#sql_tablesNames ul').html(_tables);
    }
    
    /* ============= */
    /* --- TABLE --- */
    /* ============= */
    
    function dspTableContent(select_start,select_nb)
    {
        var database_name   = DatabaseModel.getDatabaseName();
        var table_name      = DatabaseModel.getTableName();
        
        $.ajax({
            type: "POST",
            url: "ajax/select.php",
            data: "dirConfigs=<?=_DIR_CONFIGS?>&database_name="+database_name+"&table_name="+table_name+"&select_start="+select_start+"&select_nb="+select_nb,
            success: function(msg,text){
                var _results = eval(msg);
                _dspTableContent(_results);
                
                $('#tableContent').dataTable(
                    {"sPaginationType": "full_numbers"}
                );

                $('#tableContentButtonRefresh').html("<button class=\"_a_\" type=\"button\" onclick=\"dspTableContent('"+select_start+"','"+select_nb+"');\" ><?=_SQL_BUTTON_REFRESH_CONTENT?></button>");
                
            }
        });
    }
    
    function _dspTableContent(rows)
    {
        var _content = "";

        /* Header : Columns names */
        
            _content += "<thead><tr><th></th>";
            
            var i = 0;
            
            for ( _key in rows[0] ) 
            {
                var _column_title = _key;
                
                if ( _COLUMNS_[i].Key ) { _column_title += " <div class=\"_key_\"></div>"; }
                
                _content += "<th class=\"sorting\">" + _column_title + "</div></th>";
                
                i++;
            }
            
            _content += "<th></th></tr></thead>";
        
        /* Content */

            _content += "<tbody>";
            
            for ( var i = 0 ; i < rows.length ; i++ )
            {
                var _where = new Array();
                
                var _line_number = sprintf("%03s", i.toString() );
                
                _content += "<tr class=\"row\"><td><div class=\"count\">"+_line_number+"</div></td>";
                
                var j = 0;
                    
                for ( _key in rows[i] ) 
                {
                    // _where : Tableau associatif des colonnes clées avec les valeurs ( Pour chaque ligne )
                    
                    if ( _COLUMNS_[j].Key ) { _where[_COLUMNS_[j].Field] = rows[i][_key]; }
                    
                    // ---
                    
                   _content += "<td class=\"cell\">" + rows[i][_key] + "</td>";
                   
                   j++;
                }
                
                //console.log(_where);
                
                // =========================
                // --- Actions Button(s) ---
                // =========================
                
                _content += "<td>";
                
                // Array to JSON Object
                
                    var _json = "{";
                    
                    var j = 0;
                    
                    for ( _key in _where ) 
                    {
                        if ( j > 0 ) { _json += ",";}
                        _json += "'" + _key + "':'" + _where[_key] + "'";
                        
                        j++;
                    }
                    
                    _json += "}";
                
                // Button [delete]

                    _content += "<span class=\"_a_\" alt=\""+_json+"\" title=\""+_json+"\" onclick=\"javascript:deleteRow("+_json+");\"><?=_SQL_DELETE_ROW?></span>";

                // ---
                
                _content += "</td></tr>";
            }
            
            _content += "</tbody>";
        
        /* Footer : Columns names */
        
            _content += "<tfoot><tr><th></th>";
            
            for ( _key in rows[0] ) 
            {
                _content += "<th>" + _key + "</th>";
            }
            
            _content += "<th></th></tr></tfoot>";
        
        /* Output */
        
            $('#sql_tableContent ul').html('<table id="tableContent" class="display">'+_content+'</table>');
    }
    
    /* ========================== */
    /* --- TABLE : Delete Row --- */
    /* ========================== */

    function deleteRow(_where_json)
    {
        // console.log(_where_json);
        
        // Where JSON to Where SQL :
    
            var _where_sql = "WHERE ";
            
            var j = 0;
            
            for ( _key in _where_json ) 
            {
                if ( j > 0 ) { _where_sql += " AND ";}
                _where_sql += "`" +_key + "`=\"" + _where_json[_key] + "\"";

                j++;
            }
            
        // ---

        if (confirm("Delete selected row ?"))
        {
            DatabaseModel.deleteRow(_where_sql);                                // Custom event "deleteRowOK"
        }
    }

    /* ============================================= */
    /* --- Display columns for an existing table --- */
    /* ============================================= */

    function dspFormCreateTable()
    {
        var _database_name = DatabaseModel.getDatabaseName();
        var _html = "";
        
        _html += '<form id="sql_createTable" method="post" action="">';

        _html += '  <input type="hidden" name="dirConfigs"  value="<?=_DIR_CONFIGS?>" />';
        _html += '  <input type="hidden" name="_sql_[database][name]" id="_sql_[database][name]" value="'+_database_name+'" />';

        _html += '  <div class="sidebox">';
        _html += '  <div class="boxhead"><h2><div class="edit_titre"><?=_SQL_CREATE_OR_UPDATE_TABLE?></div><div id="sql_tableName_loading"></div></h2></div>';
        _html += '      <div class="boxbody">';
        _html += '          <?=_SQL_TABLE_NAME?> <input type="text" maxsize="32" id="sql_tableName_new" name="_sql_[table][name]" alt="<?=_SQL_CREATE_TABLE_INPUT?>" title="<?=_SQL_CREATE_TABLE_INPUT?>" />';
        _html += '          <ul id="sql_tableColumns"></ul>';
        _html += '          <p>';
        _html += '              <span class="_a_ _button_" onclick="$(\'#sql_tableColumns\').append(_addColumn(\'\',\'\',\'\',\'\',\'\',\'\',\'\',\'\'));"><?=_SQL_ADD_COLUMN?></span>';
        _html += '              <button class="_a_" type="submit" ><?=_SQL_CREATE_TABLE_SUBMIT?></button>';
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
            
            // Enum :
            
                var _enumerations = _length;

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
            
            // Add column :
            
                _newColumns += _addColumn( columns[i].Field , columns[i].Type , columns[i].Key, columns[i].Default ,_length , _enumerations, _auto_increment , _unsigned );

            // ---
        }

        $('#sql_tableColumns').html(_newColumns);
    }

    /* ============================== */
    /* --- Html code for 1 column --- */
    /* ============================== */

    function _addColumn(name,type,_key,_default,_length,_enumerations,_auto_increment,unsigned)
    {
        /* --- Select Type --- */
        
            var _selectDefinition = { 
                NUMERIC: {
                    "TINYINT"   : "-127 to 128 or 0 to 255",
                    "SMALLINT"  : "-32768 to 32767 or 0 to 65536",
                    "MEDIUMINT" : "-2^23 to 2^23 or 0 to 2^24",
                    "BIGINT"    : "-2^63 to 2^63 or 0 to 2^64",
                    "INT"       : "-2^31 to 2^31 or 0 to 2^32",
                    "FLOAT"     : "Precision simple",
                    "DOUBLE"    : "Precision double",
                    "DECIMAL"   : "String form"
                },
                STRING: {
                    "VARCHAR"   : "1 to 255",
                    "CHAR"      : "1 to 255",
                    "TINYTEXT"  : "1 to 255",
                    "TEXT"      : "1 to 65536",
                    "MEDIUMTEXT": "1 to 16 777 216",
                    "LONGTEXT"  : "1 to 2^32",
                    "TINYBLOB"  : "1 to 255",
                    "MEDIUMBLOB": "1 to 16 777 216",
                    "LONGBLOB"  : "1 to 2^32",
                    "BLOB"      : "1 to 65536",
                    "ENUM"      : "---"
                },
                "DATE AND TIME": {
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
                selectType += "<optgroup label=\"" + _optGroup + "\">";
                
                for ( var _typeValue in _select[_optGroup] )
                {
                    var _indexOf = type.indexOf("(");
                    
                    if ( _indexOf > 0 ) {
                        var _tmp  = type.substring(0,_indexOf);
                        var _type = _tmp.toUpperCase();
                    } else {
                         var _type = type.toUpperCase();
                    }

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
                _params = _hiddenLength(_type) + _hiddenEnum(_enumerations) + _unsigned(unsigned,1) + _autoIncrement(_auto_increment,1);
            }

            else if (_type.match(/(FLOAT|DOUBLE|DECIMAL|BLOB|TEXT|DATE|TIME|YEAR)/)) 
            {
                _params = _hiddenLength(_type) + _hiddenEnum(_enumerations) + _unsigned(0,0) + _autoIncrement(0,0);
            }
            
            else if (_type.match(/(CHAR)/)) 
            {
                _params = _selectLength(_length) + _hiddenEnum(_enumerations) + _unsigned(0,0) + _autoIncrement(0,0);
            }
            
            else if (_type.match(/(ENUM)/)) 
            {
                _params = _hiddenLength(_type) + _selectEnum(_enumerations,_default) + _unsigned(0,0) + _autoIncrement(0,0);
            }
        
        /* --- Key --- */
        
        if ( _key ) { var _key_class = "_key_"; } else { var _key_class = "_nokey_"; }

        /* --- ---*/
    
        newColumn  = "<li class=\"_li_\">";
        newColumn += "<button type=\"button\" class=\"_a_ _delete_\"><?=_SQL_DELETE_COLUMN?> </button>";
        newColumn += "<span class=\"_a_ _drag_\"> [drag] </span>";
        newColumn += "<?=_SQL_COLUMN_NAME?> <input type=\"text\" size=\"8\" maxsize=\"32\" name=\"_sql_[table][column][name][]\" alt=\""+name+"\" title=\""+name+"\" value=\""+name+"\" />";
        newColumn += selectType ;
        newColumn += "<div class=\""+_key_class+"\">"+_key+"</div>";
        newColumn += "<span class=\"sql_columnParams\">"+_params+"</span>";
        newColumn += "</li>";

        return newColumn;
    }
    
    function _selectEnum(_enumerations,_default){
        var _out = "<select name=\"_sql_[table][column][enum][]\" value=\"\" >";
        var _regex = new RegExp("[,]+", "g");
        var _enums = _enumerations.split(_regex);
        
        for ( var i = 0 ; i < _enums.length ; i++ )
        {
            var _end   = _enums[i].length - 1;
            var _value = _enums[i].substring(1,_end);
            
            var _selected = "";
            
            if ( _value == _default ) { _selected = " selected=\"selected\" "; }
            
            _out += "<option value=\"" + _value + "\" " + _selected + " >" + _value + "</option>";
        }
        
        _out += "</select>";
        _out += "<input type=\"hidden\" name=\"_sql_[table][column][enum_new][]\" value=\"\" />";
        _out += "<input type=\"hidden\" name=\"_sql_[table][column][enum_old][]\" value=\""+_enumerations+"\" />";
        
        return _out;
    }
    
    function _hiddenEnum(_enumerations){
        var _out = "";
        
        _out += "<input type=\"hidden\" name=\"_sql_[table][column][enum][]\" value=\"\" />";
        _out += "<input type=\"hidden\" name=\"_sql_[table][column][enum_new][]\" value=\"\" />";
        _out += "<input type=\"hidden\" name=\"_sql_[table][column][enum_old][]\" value=\""+_enumerations+"\" />";
        
        return _out;
    }
    
    function _inputNewEnum(_enumerations){
        var _out = "";
        
        _out += "<input type = \"hidden\" name = \"_sql_[table][column][enum][]\" value = \"\" />";
        _out += "<?=_SQL_ENUMERATIONS?> <input type = \"text\" name = \"_sql_[table][column][enum_new][]\" value = \"\" />";
        _out += "<input type=\"hidden\" name=\"_sql_[table][column][enum_old][]\" value=\""+_enumerations+"\" />";
        
        return _out;
    }

    function _hiddenLength(_type){

        _length = 8;
        
             if (_type.match(/(BIGINT)/))               { _length = 8; }
        else if (_type.match(/(MEDIUMINT)/))            { _length = 3; }
        else if (_type.match(/(SMALLINT)/))             { _length = 2; }
        else if (_type.match(/(TINYINT)/))              { _length = 1; }
        else if (_type.match(/(INT)/))                  { _length = 4; }
        else if (_type.match(/(LONGTEXT|LONGBLOB)/))    { _length = 0; }
        else if (_type.match(/(MEDIUMTEXT|MEDIUMBLOB)/)){ _length = 0; }
        else if (_type.match(/(TINYTEXT|TINYBLOB)/))    { _length = 0; }
        else if (_type.match(/(TEXT|BLOB)/))            { _length = 0; }
        else if (_type.match(/(DATE|TIME|YEAR)/))       { _length = 0; }
        else if (_type.match(/(ENUM)/))                 { _length = 0; }
        
        return "<input type=\"hidden\" name = \"_sql_[table][column][length][]\" value = \"" + _length + "\" />";
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
