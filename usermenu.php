<?php require_once('Connections/ssrabbit.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "user";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "invalidform.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_menuuser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_menuuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_menuuser = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_menuuser, "text"));
$menuuser = mysql_query($query_menuuser, $ssrabbit) or die(mysql_error());
$row_menuuser = mysql_fetch_assoc($menuuser);
$totalRows_menuuser = mysql_num_rows($menuuser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Menu | Sweet Sour Rabbit</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
          <blockquote>
            <p>&nbsp;</p>
            <?php $_SESSION["MM_Username"]; ?><table width="200" border="0" align="center">
              <tr>
                <td align="center" bgcolor="#FFCC66"><p>USER MENU</p></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFCC66">WELCOME</td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFCC66"><blockquote>
                  <p><?php echo $row_menuuser['username']; ?></p>
                </blockquote></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFCC66"><img src="themes/images/logo2.png" width="193" height="37" /></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFCC66"><a href="update own user.php">Update Data</a></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#FFCC66"><a href="index.html">Log Out</a></td>
              </tr>
            </table>
          </blockquote>
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
  <p>&nbsp;</p>
</form>
</body>
</html>
<?php
mysql_free_result($menuuser);
?>
