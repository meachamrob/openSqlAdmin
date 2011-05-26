<script type="text/javascript">

/* =========================== */
/* --- DatabaseModel Class --- */
/* =========================== */

var DatabaseModel = function () {

    this._database_name = "";
    this._databases     = "";
    this._table_name    = "";
    this._tables        = "";
    this._dirConfigs    = "<?=_DIR_CONFIGS?>";
    
    _this = this;
};
 
DatabaseModel.prototype = {
    
    setDatabaseName : function (database_name)
    {
        _this._database_name = database_name;
        $('body').trigger('setDatabaseNameOK','');                              // Custom event "setDatabaseNameOK"
    },
    
    getDatabaseName : function ()
    {
        return _this._database_name;
    },
    
    setTableName : function (table_name)
    {
        _this._table_name = table_name;
    },
    
    getTableName : function ()
    {
        return _this._table_name;
    },
 
    setDatabases : function ()
    {
        $.ajax({
            type: "POST",
            url: "ajax/show_databases.php",
            data: "dirConfigs=" + this._dirConfigs,
            success: function(msg,text)
            {
                _this._databases = eval(msg);
                $('body').trigger('setDatabasesOK',_this._databases);
            }
        });
        
    },
    
    getDatabases : function ()
    {
        return _this._databases;
    },
    
    setTables : function ()
    {
        $.ajax({
            type: "POST",
            url: "ajax/show_tables.php",
            data: "dirConfigs=" + _this._dirConfigs + "&database_name=" + _this._database_name,
            success: function(msg,text)
            {
                _this._tables = eval(msg);
                $('body').trigger('setTablesOK',_this._tables);
            }
        });
    },
    
    getTables : function ()
    {
        return _this._tables;
    },
    
    dropDatabase : function (database_name)
    {
        $.ajax({
            type: "POST",
            url: "ajax/drop_database.php",
            data: "dirConfigs=" + _this._dirConfigs + "&database_name=" + database_name,
            success: function(msg,text)
            {
                if ( database_name == _this._database_name )
                {
                    _this._database_name = "";
                }
                $('body').trigger('dropDatabaseOK',_this);
            }
        });
    },
    
    createDatabase : function (database_name)
    {
        $.ajax({
            type: "POST",
            url: "ajax/create_database.php",
            data: "dirConfigs=" + _this._dirConfigs + "&database_name=" + database_name,
            success: function(msg,text)
            {
                $('body').trigger('createDatabaseOK',_this);                    // Custom event "createDatabaseOK"
            }
        });
    },
    
    dropTable : function (table_name)
    {
        $.ajax({
            type: "POST",
            url: "ajax/drop_table.php",
            data: "dirConfigs=" + _this._dirConfigs + "&database_name=" + _this._database_name + "&table_name="+table_name,
            success: function(msg,text)
            {
                $('body').trigger('dropTableOK','');                            // Custom event "dropTableOK"
            }
        });
    }
};
    
</script>