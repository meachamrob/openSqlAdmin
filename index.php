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
        <!-- script type="text/javascript" src="./js/jquery.php_serial-0.2.js"></script -->
        <script type="text/javascript" src="./js/sprintf.js/src/sprintf.js"></script>
        
        <script type="text/javascript" src="./js/dropdown.js"></script>
        
        <style type="text/css" title="currentStyle">
            @import "./js/DataTables-1.7.6/media/css/demo_page.css";
            @import "./js/DataTables-1.7.6/media/css/demo_table.css";
        </style>
        <script type="text/javascript" language="javascript" src="./js/DataTables-1.7.6/media/js/jquery.dataTables.js"></script>
        
    </head>
    <body>

        <div id="col-left">

            <div class="sidebox">
                <div class="boxhead"><h2><div class="show_titre"><?=_SQL_DATABASES_NAMES?></div><div id="sql_databaseName_loading"></div></h2></div>
                <div class="boxbody">
                    <p>
                        <div class="row">
                            <?=_SQL_CREATE_DATABASE?> <input type="text" maxsize="32" id="sql_databaseName_new" name="_sql_[database][name]" />
                        </div>
                    </p>
                    <dl class="dropdown">
                        <dt><a href="#"><span><?=_SQL_SELECT_DATABASE?></span></a></dt>
                        <dd>
                            <ul id="sql_databasesNames"></ul>
                        </dd>
                    </dl>
                </div>
                <div class="boxfooter"><h2></h2></div>
            </div>

            <div id="sql_tablesNames"></div>
            
        </div>

        <div id="col-right">
            <div id="sql_formCreateTable"></div>
            <div id="sql_tableContent"></div>
        </div>
        
        <?php include_once("./js/openSqlAdmin.js"); ?>
        
    </body>
</html>

