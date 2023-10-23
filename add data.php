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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO customer (username, password, name, email, address1, address2, postcode, `state`, country, telnumber) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['postcode'], "int"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['telnumber'], "text"));

  mysql_select_db($database_ssrabbit, $ssrabbit);
  $Result1 = mysql_query($insertSQL, $ssrabbit) or die(mysql_error());

  $insertGoTo = "adminmenu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Data | Sweet Sour Rabbit</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <?php $_SESSION["MM_Username"]; ?><table width="426" border="0" align="center">
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><img src="themes/images/logo2.png" width="193" height="37" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><p>ADD DATA</p></td>
    </tr>
    <tr>
      <td width="108" bgcolor="#FFCC66">Username:</td>
      <td width="308" bgcolor="#FFCC66"><label for="username"></label>
      <input name="username" type="text" id="username" readonly="readonly" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Password:</label></td>
      <td bgcolor="#FFCC66"><input name="password" type="text" id="password" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Name:</td>
      <td bgcolor="#FFCC66"><label>
        <input name="name" type="text" id="name" />
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Email:</label></td>
      <td bgcolor="#FFCC66"><input name="email" type="text" id="email" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Address :</label></td>
      <td bgcolor="#FFCC66"><textarea name="address1" id="address1"></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">&nbsp;</td>
      <td bgcolor="#FFCC66"><label>
        <textarea name="address2" id="address2"></textarea>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td bgcolor="#FFCC66"><input name="postcode" type="text" id="postcode" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>State:</label></td>
      <td bgcolor="#FFCC66"><label>
        <select name="state" id="state">
          <option value="">Choose below:</option>
          <option value="perak">Perak</option>
          <option value="selangor">Selangor</option>
</select>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Country:</label></td>
      <td bgcolor="#FFCC66"><input name="country" type="text" id="country" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td bgcolor="#FFCC66"><input name="telnumber" type="text" id="telnumber" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Gender: </td>
      <td bgcolor="#FFCC66"><p><br />
      </p></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <p>
                <input type="submit" name="button" id="button" value="Add Data" />
              </p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
</body>
</html>