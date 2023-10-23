<?php require_once('Connections/ssrabbit.php'); ?>
<?php require_once('Connections/ssrabbit.php'); ?>
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

$colname_searchuser = "-1";
if (isset($_GET['username'])) {
  $colname_searchuser = $_GET['username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searchuser = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searchuser, "text"));
$searchuser = mysql_query($query_searchuser, $ssrabbit) or die(mysql_error());
$row_searchuser = mysql_fetch_assoc($searchuser);
$totalRows_searchuser = mysql_num_rows($searchuser);

$colname_updatedata = "-1";
if (isset($_GET['username'])) {
  $colname_updatedata = $_GET['username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_updatedata = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_updatedata, "text"));
$updatedata = mysql_query($query_updatedata, $ssrabbit) or die(mysql_error());
$row_updatedata = mysql_fetch_assoc($updatedata);
$totalRows_updatedata = mysql_num_rows($updatedata);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search &amp; Update | Sweet Sour Rabbit</title>
</head>

<body>
<form id="form1" name="form1" method="get" action="search update.php">
  <p>&nbsp;</p>
  <table width="328" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <p>SEARCHING USER</p>
      </blockquote></td>
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
      <td colspan="2" bgcolor="#FFCC66">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<form id="form2" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
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
              <p>UPDATE DATA</p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td width="112" bgcolor="#FFCC66">Username:</td>
      <td width="390" bgcolor="#FFCC66"><label for="username2"></label>
        <label for="username4"><?php echo $row_updatedata['username']; ?></label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Password:</label></td>
      <td bgcolor="#FFCC66"><input name="password" type="text" id="password" value="<?php echo $row_updatedata['password']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Name:</td>
      <td bgcolor="#FFCC66"><label>
        <input name="name" type="text" id="name" value="<?php echo $row_updatedata['name']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Email:</label></td>
      <td bgcolor="#FFCC66"><input name="email" type="text" id="email" value="<?php echo $row_updatedata['email']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Address :</label></td>
      <td bgcolor="#FFCC66"><textarea name="address1" id="address1"><?php echo $row_updatedata['address1']; ?></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">&nbsp;</td>
      <td bgcolor="#FFCC66"><label>
        <textarea name="address2" id="address2"><?php echo $row_updatedata['address2']; ?></textarea>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td bgcolor="#FFCC66"><input name="postcode" type="text" id="postcode" value="<?php echo $row_updatedata['postcode']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>State:</label></td>
      <td bgcolor="#FFCC66"><label>
        <select name="state" id="state" title="<?php echo $row_updatedata['state']; ?>">
          <option value="" <?php if (!(strcmp("", $row_updatedata['state']))) {echo "selected=\"selected\"";} ?>>Choose below:</option>
          <option value="perak" <?php if (!(strcmp("perak", $row_updatedata['state']))) {echo "selected=\"selected\"";} ?>>Perak</option>
          <option value="selangor" <?php if (!(strcmp("selangor", $row_updatedata['state']))) {echo "selected=\"selected\"";} ?>>Selangor</option>
          <?php
do {  
?>
          <option value="<?php echo $row_updatedata['state']?>"<?php if (!(strcmp($row_updatedata['state'], $row_updatedata['state']))) {echo "selected=\"selected\"";} ?>><?php echo $row_updatedata['state']?></option>
          <?php
} while ($row_updatedata = mysql_fetch_assoc($updatedata));
  $rows = mysql_num_rows($updatedata);
  if($rows > 0) {
      mysql_data_seek($updatedata, 0);
	  $row_updatedata = mysql_fetch_assoc($updatedata);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Country:</label></td>
      <td bgcolor="#FFCC66"><input name="country" type="text" id="country" value="<?php echo $row_updatedata['country']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td bgcolor="#FFCC66"><input name="telnumber" type="text" id="telnumber" value="<?php echo $row_updatedata['telnumber']; ?>" /></td>
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
                <input type="submit" name="button2" id="button2" value="Update Data" />
              </p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($searchuser);

mysql_free_result($updatedata);

mysql_free_result($searchuser);

mysql_free_result($updatedata);
?>
