<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ssrabbit = "localhost";
$database_ssrabbit = "sweetsour";
$username_ssrabbit = "root";
$password_ssrabbit = "";
$ssrabbit = mysql_pconnect($hostname_ssrabbit, $username_ssrabbit, $password_ssrabbit) or trigger_error(mysql_error(),E_USER_ERROR); 
?>