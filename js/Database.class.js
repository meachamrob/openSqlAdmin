<script type="text/javascript">

/* =========================== */
/* --- DatabaseModel Class --- */
/* =========================== */

var DatabaseModel = function () {

    this._database_name = "";
    this._databases     = "";
    this._dirConfigs    = "<?=_DIR_CONFIGS?>";
    
    this.setDatabases();
};
 
DatabaseModel.prototype = {
 
    getDatabaseName : function ()
    {
        return this._database_name;
    },
    
    setDatabase : function (database_name)
    {
        this._database_name = database_name;
    },
 
    setDatabases : function ()
    {
        
        $.ajax({
            type: "POST",
            url: "ajax/show_databases.php",
            data: "dirConfigs=" + this._dirConfigs,
            success: function(msg,text)
            {
                this._databases = eval(msg);
                $('body').trigger('setDatabasesOK',this._databases);
                $('body').trigger("setDatabasesOK2", [ 'bar', 'bam' ]);
            }
        });
        
    }
 
};

/* ============================================= */
/* --- Instantiate and configure the classes --- */
/* ============================================= */

    $(document).ready(function() 
    {
        var databaseModel = new DatabaseModel();
        $('body').live("setDatabasesOK", function(e, data)
        {
            alert('ooo '+data);
        });
        $('body').live("setDatabasesOK2", function(e, param1, param2)
        {
            alert('ooo2'+param1+" " +param2);
        });
    });
    
</script>