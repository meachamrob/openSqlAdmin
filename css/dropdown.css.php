<?php
    header("Content-type: text/css");
?>
body { font-family:Arial, Helvetica, Sans-Serif; font-size:0.75em; color:#000;}
.desc { color:#6b6b6b;}
.desc a {color:#0092dd;}

.dropdown dd, .dropdown dt, .dropdown ul { margin:0px; padding:0px; }
.dropdown dd { position:relative; }

.dropdown a, .dropdown a:visited {
    color:#816c5b;
    text-decoration:none;
    outline:none;
}

.dropdown a:hover {}

.dropdown dt a:hover, .dropdown dt a:focus {
    background:#d4d4d4 url(dropdown/arrow.png) no-repeat scroll right center;
    color:#666;
    border: 1px solid #ddd;
}

.dropdown dt a {
    background:#dddddd url(dropdown/arrow.png) no-repeat scroll right center;
    display:block;
    padding-right:20px;
    border:1px solid #bbb;
    border-radius:5px;
    -moz-border-radius:5px;
    -webkit-border-radius: 5px;
}

.dropdown dt a span {cursor:pointer; display:block; padding:5px;}

.dropdown dd ul {
    background:#fff none repeat scroll 0 0;
    border:1px solid #666;
    display:none;
    left:0px;
    padding:5px;
    position:absolute;
    top:0px;
    width:auto;
    min-width:170px;
    list-style:none;

    border-radius:5px;
    -moz-border-radius:5px;
    -webkit-border-radius: 5px;
}
.dropdown span.value { display:none;}
.dropdown dd ul li a { padding:5px; display:block;}
.dropdown dd ul li a:hover { background-color:#f4f4f4;}

