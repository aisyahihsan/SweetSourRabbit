<?php require_once('Connections/ssrabbit.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
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

$MM_restrictGoTo = "usermenu.php";
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

$colname_searchuser = "-1";
if (isset($_GET['username'])) {
  $colname_searchuser = $_GET['username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searchuser = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searchuser, "text"));
$searchuser = mysql_query($query_searchuser, $ssrabbit) or die(mysql_error());
$row_searchuser = mysql_fetch_assoc($searchuser);
$totalRows_searchuser = mysql_num_rows($searchuser);

$colname_displaydata = "-1";
if (isset($_GET['username'])) {
  $colname_displaydata = $_GET['username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_displaydata = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_displaydata, "text"));
$displaydata = mysql_query($query_displaydata, $ssrabbit) or die(mysql_error());
$row_displaydata = mysql_fetch_assoc($displaydata);
$totalRows_displaydata = mysql_num_rows($displaydata);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search &amp; Display | Sweet Sour Rabbit</title>
</head>

<body>
<form id="form1" name="form1" method="get" action="search display.php">
  <p>&nbsp;</p>
  <table width="328" border="0" align="center">
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><p>SEARCHING USER</p></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <p><img src="themes/images/logo2.png" width="193" height="37" /></p>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td width="153" bgcolor="#FFCC66">Username</td>
      <td width="168" bgcolor="#FFCC66"><label for="username"></label>
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
      <td colspan="2" align="center" bgcolor="#FFCC66"><a href="adminmenu.php">Admin Menu</a></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<form id="form2" name="form1" method="get" action="<?php echo $editFormAction; ?>">
  <table width="512" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <p><img src="themes/images/logo2.png" width="193" height="37" /></p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <p>DISPLAY DATA</p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td width="112" bgcolor="#FFCC66">Username:</td>
      <td width="390" bgcolor="#FFCC66"><label for="username2"></label>
        <?php echo $row_displaydata['username']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Password:</label></td>
      <td bgcolor="#FFCC66"><?php echo $row_displaydata['password']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Name:</td>
      <td bgcolor="#FFCC66"><label><?php echo $row_displaydata['name']; ?></label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Email:</label></td>
      <td bgcolor="#FFCC66"><?php echo $row_displaydata['email']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Address :</label></td>
      <td bgcolor="#FFCC66"><?php echo $row_displaydata['address1']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">&nbsp;</td>
      <td bgcolor="#FFCC66"><label><?php echo $row_displaydata['address2']; ?></label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td bgcolor="#FFCC66"><?php echo $row_displaydata['postcode']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>State:</label></td>
      <td bgcolor="#FFCC66"><label><?php echo $row_displaydata['state']; ?></label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Country:</label></td>
      <td bgcolor="#FFCC66"><?php echo $row_displaydata['country']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td bgcolor="#FFCC66"><?php echo $row_displaydata['telnumber']; ?></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Gender: </td>
      <td bgcolor="#FFCC66"><p><?php echo $row_displaydata['gender']; ?><br />
      </p></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <p>&nbsp;</p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
</p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($searchuser);

mysql_free_result($displaydata);
?>
