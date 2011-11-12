<?php
    header("Content-type: text/css");
    $PREFIX_URL_CSS = $_GET['PREFIX_URL_CSS'];
?>
*{ cursor:default; }

body {
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/background.png") repeat-x top center #d8dce0;
}

a { cursor:pointer; color:#4580C2; }

input{ cursor:text; color:#4580C2; }
input:hover{ border:1px solid #000; }
input[type="submit"]:hover{cursor:pointer;}
input[type="checkbox"]:hover{cursor:pointer;}
select{ cursor:pointer; }
option{ cursor:pointer; }
.linkDisconnect{cursor:pointer;}
.sql_checkbox0 h3{cursor:pointer;}
.sql_checkbox1 h3{cursor:pointer;}

a:hover{ color:#4580C2; background:#eee; }

._a_{ color:#4580C2; }
._a_:hover{ color:#4580C2; background:#eee; }

.ib_titre, .show_titre, .edit_titre, .su_titre{
    background:none;
    height:auto;
    padding-top:0px;
    padding-left:0px;
    padding-bottom:8px;
}

#sidebox_su form{ padding:5px; }

.sidebox{
    margin:10px; auto
    width:100%;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    background:#eeeeee;
    /* these go to the end as the css validator does not like them
    will be replaced by border-radius with css3 */
    font-size: 100%;
    border:0px;
    -webkit-box-shadow: 3px 3px 6px #AAAAAA;
    -moz-box-shadow:3px 3px 6px #AAAAAA;
    
}

.boxhead h2 {
    margin: 0px;
    padding: 0px auto;
    color: white; 
    font-weight: bold; 
    font-size:16px; 
    line-height: 1em;
    text-shadow: rgba(0,0,0,.4) 1px 1px 5px; /* Safari-only, but cool */

    -moz-border-radius-topleft:5px;
    -moz-border-radius-topright:5px;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    
    background-color:#5590D2;
    background-image:-moz-linear-gradient(center top , #61A7F2, #5590D2);
    border-left:1px solid #86B7ED;
}

.boxbody {
    background:#fff;
    border:0px;
    margin:0px;
    padding:0px;
}

.boxfooter {
    margin: 0;
    padding: 0;
    text-align: center;
    background-color:#C9E2FC;
    border-left:1px solid #E4F1FE;
    border-top:1px solid #B8C6D9;
    overflow:hidden;
    padding:6px;
    -moz-border-radius-bottomleft:5px;
    -moz-border-radius-bottomright:5px;
    -webkit-border-bottom-left-radius: 5px;
    -webkit-border-bottom-right-radius: 5px;
}

.boxfooter h2 {
    color:#000;
    font-weight:normal;
    padding:0px;
    height:20px;
    text-align:left;
}

.count{
    color:white;
    background:#99bb00;
    -moz-border-radius:8px;
    -webkit-border-radius:8px;
    border-radius:8px;
    padding:0px 3px 0px 3px;
    margin-left:4px;
    margin-right:3px;
}
.boxtoolbar{
    background:red;
    border:0px;
    border-left:1px solid #E4F1FE;
    background-color:#C9E2FC;
    padding:0px;
}

.bgcolor0, .bgcolor1{ background:none; }

#sql_table{ padding:0px; margin:0px;}

.trhead{
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/column_title.png") repeat-x top center #d8dce0;
}
.trhead td{
    border-top:1px solid #ccc;
    border-bottom:1px solid #ccc;
}

#sql_table tr td{
    padding:10px 2px 5px 2px;
}

a img{
    border-radius:4px;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    cursor:pointer;
}

.titre_colonne{
    font-weight:normal;
    border:0px;
    border-radius:0px;
    -moz-border-radius: 0px;
    -webkit-border-radius: 0px;
    background:none;
    border-right:1px solid #ddd;
    border-left:1px solid #eee;
    height:24px;
}

#slide{
    background:none;
    color:gray;
    padding:0px 10px 0px 9px;
}

.version{
    padding-right:4px;
    padding-top:10px;
}

.SQL_titre{
    color:#777;
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/arrow1.png") no-repeat 10px 55%;
    text-transform:uppercase;
}

#sql_back_first{}
#sql_back_first h3 {
    cursor:pointer;
    opacity:0.7;
    background-image: url('<?php echo $PREFIX_URL_CSS; ?>wave/start.png');
    background-repeat: no-repeat;
    background-position: left;
    width:32px; height:32px;
}
#sql_back_first h3:hover {opacity:1.0;}
#sql_back_first h3 span{ display:none; }

#sql_next h3{
    cursor:pointer;
    opacity:0.7;
    width:32px;
    height:32px;
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/arrow0.png") no-repeat scroll 0px 0px;
}

#sql_next h3:hover{
    opacity:1.0;
}

#sql_back h3{
    cursor:pointer;
    opacity:0.7;
    width:32px;
    height:32px;
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/arrow2.png") no-repeat scroll 0px 0px;
}

#sql_back h3:hover{ opacity:1.0; }

#sql_actualise h3{
    cursor:pointer;
    opacity:0.7;
    width:32px;
    height:32px;
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/refresh.png") no-repeat scroll 0px 0px;
}

#sql_actualise h3:hover{ opacity:1.0; }

#sql_close h3 {
    cursor:pointer;
    opacity:0.7;
    background-image: url('<?php echo $PREFIX_URL_CSS; ?>wave/close.png');
    width:32px; height:32px;
}
#sql_close h3:hover { opacity:1.0; }

#sql_empty_table h3 {
    cursor:pointer;
    margin-left:0px;
    opacity:0.7;
    background-image: url('<?php echo $PREFIX_URL_CSS; ?>wave/delete.png');
    background-repeat: no-repeat;
    background-position: left;
    width:32px;
    height:32px;
}
#sql_empty_table h3:hover { opacity:1.0; }

.sql_delete{
    cursor:pointer;
    opacity:0.7;
    background:transparent url('<?php echo $PREFIX_URL_CSS; ?>wave/delete_mini.png') no-repeat;
}

.sql_delete:hover{
    opacity:1.0;
    background:transparent url('<?php echo $PREFIX_URL_CSS; ?>wave/delete_mini.png') no-repeat;
}

ul {list-style:none;}

.menu_active{ padding-left:0px; background:none #99bb00; }
.menu_active a{ color:white; }

.menu_active:hover{ background:none #99bb00; }
.menu_active a:hover{ background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAALEwAACxMBAJqcGAAAAIlJREFUGNN1jLENwjAURO9brhnAkYXECNSIgjkoIqX4JQtE+pnDcgODwCZs8n00hMIKrzrdPZ2gw8zCMAwTyVlV97EbLiSN5Gnto5mFnPPB3Y3ktX+MKaXF3W8AdtggkCQA4g9BVRd3P4rIY0uIIkIAb5JjrfXeWjMA55+whq/4JPkqpUwAZgD4AEwLOvoRtgWJAAAAAElFTkSuQmCC") no-repeat 98% 50% #99bb00; }

.menu_inactive a:hover{ background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAALEwAACxMBAJqcGAAAAIlJREFUGNN1jLENwjAURO9brhnAkYXECNSIgjkoIqX4JQtE+pnDcgODwCZs8n00hMIKrzrdPZ2gw8zCMAwTyVlV97EbLiSN5Gnto5mFnPPB3Y3ktX+MKaXF3W8AdtggkCQA4g9BVRd3P4rIY0uIIkIAb5JjrfXeWjMA55+whq/4JPkqpUwAZgD4AEwLOvoRtgWJAAAAAElFTkSuQmCC") no-repeat 98% 50% #eee; }

.formConnexion{
    background:none;
}

.formConnexion form{
    margin:4px;
}

#admin_logo{
    text-align:center;
    margin-top:5px;
    padding-top:45px;
    color:#333;
    background: url(<?php echo $PREFIX_URL_CSS; ?>defaut/logo_rounded.png) no-repeat center 5px;
}

.editRecord{
    margin:4px;
}

#slide img{
    opacity:0.7;
    filter:alpha(opacity=70);
}

.btn-slide{
    background:url('<?php echo $PREFIX_URL_CSS; ?>wave/arrows.png') no-repeat left 5px;
}

.active {
    background-position: left -34px;
    /*-webkit-transform: rotate(-180deg);
    -moz-transform: rotate(-180deg);*/
}

.selectTheme{
    height:21px;
    padding-left:28px;
    padding-right:1px;
    padding-top:0px;
    background:transparent url('<?php echo $PREFIX_URL_CSS; ?>wave/theme.png') no-repeat 0px -2px;
}

/* ============= */
/* --- MENUS --- */
/* ============= */

.extensions_titre{
    background: url(<?php echo $PREFIX_URL_CSS; ?>wave/extensions.png) no-repeat;
    height:40px;
    padding-top:15px;
    padding-left:50px;
}

/* ================ */
/* --- LIBELLES --- */
/* ================ */

#libelles_table td{
    padding:1px 2px 1px 2px;
}
.LIBELLES_titre{
    color:#777;
    background:url("<?php echo $PREFIX_URL_CSS; ?>wave/arrow1.png") no-repeat 10px 55%;
    text-transform:uppercase;
}
