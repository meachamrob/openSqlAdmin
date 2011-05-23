<?php
    header("Content-type: text/css");
?>
._a_{
    /*color:#FD6F6B;*/
}

div._delete_table_, div._delete_database_{
    background:url("../pics/trash.gif") no-repeat;
    width:16px;
    height:16px;
    display:inline-block;
    filter:alpha(opacity=70);
    -moz-opacity: 0.70;
    opacity: 0.70;
    vertical-align:top;
}

div._delete_table_:hover, div._delete_database_:hover{
    background:url("../pics/trash.gif") no-repeat;
    width:16px;
    height:16px;
    display:inline-block;
    filter:alpha(opacity=100);
    -moz-opacity: 1.00;
    opacity: 1.00;
    vertical-align:top;
}

button{
    font-size:10px;
    padding:0px;
}

#sql_tableContent .sidebox {
    width-min:100%;
    width:-moz-fit-content; 
}

._selected_{
    border-right:2px solid #000;
}
.row {
    white-space:nowrap;
}
li{
    white-space:nowrap;
}
#col-left{
    float:left;
    width:25%;
}
#col-right{
    float:left;
    width:75%;
}

#sql_databasesNames li{
    cursor:pointer;
    display:block;
}

#sql_databasesNames li:hover{
    background:#f4f4f4;
}

#sql_tablesNames li{
    cursor:pointer;
    display:block;
    margin-bottom:1px;
}

#sql_tablesNames li:hover{
    background:#f4f4f4;
}

#sql_tableColumns{
    list-style:none;
}

#sql_tableContent ul{ list-style:none; }

table{
    border-right:1px solid #f4f4f4;
    border-bottom:1px solid #f4f4f4;
}

tr{
    white-space:normal;
}

td{
    min-width: 25px;
    max-width:120px;
    overflow:hidden;
    border-top:1px solid #f4f4f4;
    border-left:1px solid #f4f4f4;
    padding: 2px 5px;
    text-align: center;
}

.title{
    font-weight:bold;
}
