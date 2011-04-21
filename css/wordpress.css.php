<?php
    header("Content-type: text/css");
?>
body {
	background:#000;
}


a, input{
	color:#21759B;
}


.formConnexion, .menu_active:hover, .menu_inactive:hover{
	background:#21759B;
}


.sidebox{
	-moz-box-shadow:0 0 0 #000000;
	background:transparent;
	border-color:#DFDFDF;
	border-radius:0 0 0 0;
	border:0;
}



.boxhead{
	background:#4C4C4C;
	border:0;
	color:#FFFFFF;
	-moz-border-radius:9px 9px 0px 0px;
	text-shadow:0 -1px 0 rgba(0, 0, 0, 0.4);
}

.ib_titre {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/logo.png") no-repeat scroll 15px 8px transparent;
	height:inherit;
	padding:6px 0 15px 40px;
}

table td .boxbody{
	margin:0;
	border:0;
	padding:0;
	background:#F9F9F9;
}

table td .boxbody form{

}

table td + td .boxbody{
	margin:0;
	border:0;
	background:#F9F9F9;
	padding:5px;
}


.menus_row {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/menu-bits.gif") repeat-x scroll left top #6D6D6D;
	border-color:#6D6D6D;
	color:#FFFFFF;
	text-shadow:0 -1px 0 rgba(0, 0, 0, 0.4);
}

.SQL_titre{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/titre.png") no-repeat scroll 5px center  transparent;
	color:#FFF;
	border:0;
	font-size:13px;
	margin:0;
	padding:6px 0 2px 28px;
}

.LIBELLES_titre{
	color:#FFF;
	margin:0;
	border:0;
	padding:8px 0 2px 28px;
}

.boxbody ul{
	list-style:none;
	padding:0;

	background:url("<?=$PREFIX_URL_CSS?>wordpress/menu-bits.gif") repeat-x scroll left -379px #F1F1F1;
}

.boxbody ul  div {
	border:0;
	font-size:12px;
}

.boxbody ul > div {
	background:transparent;
	border:0;

	padding:0;
	border:solid #DDD;
	border-width:0 0 1px 0;
}

.menus_row0 li,
.menus_row1 li 
{
	padding:0;
}

.menu_inactive,
.menu_active
{
	padding:4px 4px 4px 20px;	
}

.menu_active:hover,
.menu_active:hover a,
.menu_inactive:hover,
.menu_inactive:hover a
{
	background:#EAF2FA;
	color:#000;
	border:0;
	
}

.menu_inactive{
	border:#DDD solid;
	border-width:0 1px;
}

.menu_active{
	border:0;
	background:url("<?=$PREFIX_URL_CSS?>wordpress/active.png") no-repeat scroll -18px center transparent !important;
}

.menu_active a,
.menu_active:hover a
{
	color:#000;
	font-weight:bold;
}


.version{
	display:none;
}


input[type="text"]{
	-moz-border-radius:6px 6px 6px 6px;
	border:1px solid #DFDFDF;
	color:#000000;
	font-size:1.2em;
	outline:medium none;
	padding:4px;
	width:60%;
}

input[type="text"]:active{
	-moz-border-radius:6px 6px 6px 6px;
	border:1px solid #298CBA;
	color:#000000;
	font-size:1.2em;
	outline:medium none;
	padding:4px;
	width:60%;
}





.sql_toolbar_edit{
	width:100%;
	padding:0px;
	position:fixed;
	bottom:0;
	left:0;
	top:inherit;
	margin:0;
	border:0;
	border-radius:0 0 0 0;
	-moz-border-radius: 0 0 0 0;
	height:inherit;
	background:none repeat scroll 0 0 #444;
	z-index:100;
	border:solid #298CBA;
	border-width:1px 0;
	text-align:right;
}

.total input[type="submit"]
{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/button-grad.png") repeat-x scroll left top #21759B;
	border-color:#298CBA;
	color:#FFFFFF;
	font-weight:bold;
	text-shadow:0 -1px 0 rgba(0, 0, 0, 0.3);
	width:auto;
	padding:3px 5px;
	font-size:10px;
	text-transform:uppercase;
	text-align:center;
	cursor:pointer;
}

.total input[type="submit"]:hover
{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/button-grad.png") repeat-x scroll left top #21759B;
	border-color:#222;
	color:#000;
	font-weight:bold;
	text-shadow:0 -1px 0 rgba(0, 0, 0, 0.3);
	width:auto;
	padding:3px 5px;
	font-size:10px;
	text-transform:uppercase;
	text-align:center;
}

.total input[type="text"]{
	-moz-border-radius:4px 4px 4px 4px
	border:1px solid #DFDFDF;
	color:#000000;
	font-size:11px;
	outline:medium none;
	padding:2px;
	width:20px;
}


.sql_toolbar_edit input
{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/button-grad.png") repeat-x scroll left top #21759B;
	border-color:#298CBA;
	color:#FFFFFF;
	font-weight:bold;
	text-shadow:0 -1px 0 rgba(0, 0, 0, 0.3);
	width:auto;
	margin:5px;
	padding:0px 5px 3px 5px;
	font-size:9px;
	text-transform:uppercase;
	text-align:center;
}

.sql_toolbar_edit input:hover{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/button-grad.png") repeat-x scroll left top #21759B;
	border-color:#222;
	color:#000;
	font-weight:bold;
	text-shadow:0 -1px 0 rgba(255, 255, 255, 0.3);
	width:auto;
	margin:5px;

	text-align:center;
}


.sql_toolbar_edit br{
	display:none;
}



.boxhead h2{
	margin:0;
	padding:0;
}

.boxhead h2 .show_titre,
.boxhead h2 .edit_titre {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/bigNews.png") no-repeat scroll 4px -4px transparent;
	height:inherit;
	margin:0;
	padding:12px 0 12px 40px;
}


#sql_table{
	-moz-border-radius:6px 6px 4px 4px;
	background:url("<?=$PREFIX_URL_CSS?>wordpress/gray-grad.png") repeat-x scroll left top #DFDFDF;
	border:1px solid #DFDFDF;
	margin: 0px;
	width:100%;
}


.colonne_de_tri  {
	color:#21759B;
	font-style:italic;
	text-shadow:0 1px 0 rgba(255, 255, 255, 0.8);
}



.trhead
{

	padding:7px 7px 8px;
	-moz-border-radius:0 0 0 0;
	color:#333333;
	text-align:center;
	border:solid #AAA;
	border-width:0 0 1px 0;
	font-size:11px;
}

.titre_colonne{
	text-shadow:0 1px 0 rgba(255, 255, 255, 0.8);
	-moz-border-radius:0 0 0 0;
	border:0;
	background:transparent;
	padding:4px 10px 2px;
		font-size:11px;
}

.titre_colonne input{
	min-width:60px;
	padding:1px 2px;
	font-size:11px;
	border:solid #BBB 1px;
	-moz-border-radius:2px 2px 2px 2px;
}

.bgcolor1 td{
	background:#F9F9F9;
	border:#DFDFDF solid;
	border-width:0 0 1px 0;
}

.bgcolor0 td{
	background:#FFF;	
	border:#DFDFDF solid;
	border-width:0 0 1px 0;
}


.records a img{
	border:0;
}

.editRecord{
	margin:5px 0 5px 30px;
}


.editRecord tbody tr{
	margin:5px 0;
	-moz-border-radius:4px 0 0 4px;
	border:solid 1px #F9F9F9;
	background: #F9F9F9;   
}

.editRecord tbody tr td{
	margin:5px 0;
}

.editRecord td.titre{
	color:#464646;
	font:italic 17px/40px Georgia,"Times New Roman","Bitstream Charter",Times,serif;
	margin:0;
	padding:0 10px 0 0;
	text-shadow:0 1px 0 #FFFFFF;
	position:relative;
	top:-4px;
}

.editRecord td.titre .remarque{
	font:italic 10px/10px Arial,"Times New Roman","Bitstream Charter",Times,serif;
	background-color:#FFF;
	border:1px solid gray;
	color:#000;
	font-style:normal;
	font-weight:normal;
	padding:3px;
}


.iconeIMG{
	display:none;
}


.fileLabel{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/menu.png") no-repeat scroll -121px -40px transparent;
	padding:2px 0 2px 30px;
}


.su_titre {
background:url("<?=$PREFIX_URL_CSS?>wordpress/lock.png") no-repeat scroll 6px 3px transparent;
height:40px;
padding-left:50px;
padding-top:15px;
}


.sql_checkbox1 h3 {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/onoff.png") no-repeat left top;
	width:40px;
	height:13px;
	margin:10px auto 5px;
}

.sql_checkbox0 h3 {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/onoff.png") no-repeat left bottom;
	width:40px;
	height:13px;
	margin:10px auto 5px;
}


.scrollbox {
border:0 solid #666666;
height:60px;
overflow:hidden;
width:200px;
}

.boxfooter {
	background:none repeat scroll 0 0 #4C4C4C;
	-moz-border-radius:0 0 9px 9px;
	margin:0;
	padding:0;
	text-align:center;
}




#sql_back_first h3,
#sql_back h3,
#sql_next h3,
#sql_actualise h3
{
	height:22px;
	width:24px;
	-moz-border-radius:4px 4px 4px 4px;
	border:solid 1px #DFDFDF;
}

#sql_back_first h3:hover,
#sql_back h3:hover,
#sql_next h3:hover,
#sql_actualise h3:hover
{
	height:22px;
	width:24px;
	-moz-border-radius:4px 4px 4px 4px;
	border:solid 1px #666;
}

#sql_back_first h3{
	background:url("<?=$PREFIX_URL_CSS?>wordpress/first.png");
}

#sql_back h3 {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/prev.png");
}

#sql_next h3 {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/next.png");
}

#sql_actualise h3 {
	background:url("<?=$PREFIX_URL_CSS?>wordpress/first.png");
}

#sql_empty_table h3 {
background:url("<?=$PREFIX_URL_CSS?>wordpress/trash.png") no-repeat center center;
height:30px;
width:30px;
}
