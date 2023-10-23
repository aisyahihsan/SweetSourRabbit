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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE customer SET password=%s, name=%s, email=%s, address1=%s, address2=%s, postcode=%s, `state`=%s, country=%s, telnumber=%s WHERE username=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['postcode'], "int"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['telnumber'], "text"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_ssrabbit, $ssrabbit);
  $Result1 = mysql_query($updateSQL, $ssrabbit) or die(mysql_error());

  $updateGoTo = "adminmenu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_searchingDisplay = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_searchingDisplay = $_SESSION['MM_Username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searchingDisplay = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searchingDisplay, "text"));
$searchingDisplay = mysql_query($query_searchingDisplay, $ssrabbit) or die(mysql_error());
$row_searchingDisplay = mysql_fetch_assoc($searchingDisplay);
$totalRows_searchingDisplay = mysql_num_rows($searchingDisplay);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Data | Sweet Sour Rabbit</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="426" border="0" align="center">
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><img src="themes/images/logo2.png" width="193" height="37" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><p>UPDATE DATA</p></td>
    </tr>
    <tr>
      <td width="108" bgcolor="#FFCC66">Username:</td>
      <td width="308" bgcolor="#FFCC66"><label for="username"></label>
      <input name="username" type="text" id="username" value="<?php echo $row_searchingDisplay['username']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Password:</label></td>
      <td bgcolor="#FFCC66"><input name="password" type="text" id="password" value="<?php echo $row_searchingDisplay['password']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Name:</td>
      <td bgcolor="#FFCC66"><label>
        <input name="name" type="text" id="name" value="<?php echo $row_searchingDisplay['name']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Email:</label></td>
      <td bgcolor="#FFCC66"><input name="email" type="text" id="email" value="<?php echo $row_searchingDisplay['email']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Address :</label></td>
      <td bgcolor="#FFCC66"><textarea name="address1" id="address1"><?php echo $row_searchingDisplay['address1']; ?></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">&nbsp;</td>
      <td bgcolor="#FFCC66"><label>
        <textarea name="address2" id="address2"><?php echo $row_searchingDisplay['address2']; ?></textarea>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td bgcolor="#FFCC66"><input name="postcode" type="text" id="postcode" value="<?php echo $row_searchingDisplay['postcode']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>State:</label></td>
      <td bgcolor="#FFCC66"><label>
        <select name="state" id="state" title="<?php echo $row_searchingDisplay['state']; ?>">
          <option value="" <?php if (!(strcmp("", $row_searchingDisplay['state']))) {echo "selected=\"selected\"";} ?>>Choose below:</option>
          <option value="perak" <?php if (!(strcmp("perak", $row_searchingDisplay['state']))) {echo "selected=\"selected\"";} ?>>Perak</option>
          <option value="selangor" <?php if (!(strcmp("selangor", $row_searchingDisplay['state']))) {echo "selected=\"selected\"";} ?>>Selangor</option>
          <?php
do {  
?>
          <option value="<?php echo $row_searchingDisplay['state']?>"<?php if (!(strcmp($row_searchingDisplay['state'], $row_searchingDisplay['state']))) {echo "selected=\"selected\"";} ?>><?php echo $row_searchingDisplay['state']?></option>
          <?php
} while ($row_searchingDisplay = mysql_fetch_assoc($searchingDisplay));
  $rows = mysql_num_rows($searchingDisplay);
  if($rows > 0) {
      mysql_data_seek($searchingDisplay, 0);
	  $row_searchingDisplay = mysql_fetch_assoc($searchingDisplay);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Country:</label></td>
      <td bgcolor="#FFCC66"><input name="country" type="text" id="country" value="<?php echo $row_searchingDisplay['country']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td bgcolor="#FFCC66"><input name="telnumber" type="text" id="telnumber" value="<?php echo $row_searchingDisplay['telnumber']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Gender: </td>
      <td bgcolor="#FFCC66"><p>
        <label>
          <input type="radio" name="gender" value="<?php echo $row_searchingDisplay['gender']; ?>" id="gender_0" />
          Male</label>
        <br />
        <label>
          <input type="radio" name="gender" value="<?php echo $row_searchingDisplay['gender']; ?>" id="gender_1" />
          Female</label>
        <br />
        <br />
      </p></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><input name="usertype" type="hidden" id="usertype" value="user" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <p>
                <input type="submit" name="button" id="button" value="Update Data" />
              </p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($searchingDisplay);
?>
