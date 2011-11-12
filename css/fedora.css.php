<?php
    header("Content-type: text/css");
    $PREFIX_URL_CSS = $_GET['PREFIX_URL_CSS'];
?>
*{ cursor:default; }

body {
    background:url("<?php echo $PREFIX_URL_CSS; ?>fedora/background.jpg") repeat-x top center fixed #618fc0;
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
