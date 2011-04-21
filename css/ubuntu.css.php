<?php
    header("Content-type: text/css");
?>
body {
	background:url("<?=$PREFIX_URL_CSS?>ubuntu/background.jpg") no-repeat top center fixed #803a20;
}
a, input{
	color:#f59a3c;
}
.formConnexion, .menu_active:hover, .menu_inactive:hover{
	background:#3f1a0a;
}
.sidebox {
	background:#DFD7CD;
}
.boxbody {
    border-right:4px solid #DFD7CD;
    border-left:4px solid #DFD7CD;
}
.postFilesColumnTitleBackground{
	background:#dddddd url("<?=$PREFIX_URL_CSS?>ubuntu/header.gif") repeat-x 0px 0px;
}

.SQL_titre {
	background:transparent url('<?=$PREFIX_URL_CSS?>ubuntu/folder-remote.png') no-repeat 0px 3px;
}
