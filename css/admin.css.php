<?php
    header("Content-type: text/css");
?>
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