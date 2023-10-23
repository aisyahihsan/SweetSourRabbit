<?php require_once('Connections/ssrabbit.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_searchingUser = "-1";
if (isset($_GET['username'])) {
  $colname_searchingUser = $_GET['username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searchingUser = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searchingUser, "text"));
$searchingUser = mysql_query($query_searchingUser, $ssrabbit) or die(mysql_error());
$row_searchingUser = mysql_fetch_assoc($searchingUser);
$totalRows_searchingUser = mysql_num_rows($searchingUser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Searching User</title>
</head>

<body>
<form id="form1" name="form1" method="get" action="searching display.php">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="368" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <p>SEARCHING USER</p>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><img src="userbunny.jpg" width="328" height="334" /></td>
    </tr>
    <tr>
      <td width="153" bgcolor="#FFCC66">Username</td>
      <td width="205" bgcolor="#FFCC66"><label for="username"></label>
      <input type="text" name="username" id="username" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">&nbsp;</td>
      <td bgcolor="#FFCC66">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <p>
              <input type="submit" name="button" id="button" value="SEARCH" />
            </p>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
<?php
mysql_free_result($searchingUser);
?>
