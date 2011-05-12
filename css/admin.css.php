<?php
    header("Content-type: text/css");
?>
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
