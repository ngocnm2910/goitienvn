<?php
/*
define('HOST','localhost');
define('USERNAME','root');
define('PASSWORD','');
define('DBNAME','guitienvn');
*/
define('HOST','guitienvncom.netfirmsmysql.com');
define('USERNAME','dungminhle');
define('PASSWORD','dungminhle');
define('DBNAME','db2');
$link = mysql_connect(HOST,USERNAME,PASSWORD);
if (! $link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db(DBNAME);
date_default_timezone_set('America/New_York');
?>

