<?php
$cleardb_url      = parse_url(getenv("JAWSDB_CYAN"));
$dbhost   = $cleardb_url["host"];
$dbuser = $cleardb_url["user"];
$dbpass = $cleardb_url["pass"];
$dbdatabase       = substr($cleardb_url["path"],1);
?>
