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

if ((isset($_GET['username'])) && ($_GET['username'] != "")) {
  $deleteSQL = sprintf("DELETE FROM customer WHERE username=%s",
                       GetSQLValueString($_GET['username'], "text"));

  mysql_select_db($database_ssrabbit, $ssrabbit);
  $Result1 = mysql_query($deleteSQL, $ssrabbit) or die(mysql_error());

  $deleteGoTo = "adminmenu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_searchingdisplay = "-1";
if (isset($_GET['username'])) {
  $colname_searchingdisplay = $_GET['username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searchingdisplay = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searchingdisplay, "text"));
$searchingdisplay = mysql_query($query_searchingdisplay, $ssrabbit) or die(mysql_error());
$row_searchingdisplay = mysql_fetch_assoc($searchingdisplay);
$totalRows_searchingdisplay = mysql_num_rows($searchingdisplay);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Delete Data | Sweet Sour Rabbit</title>
</head>

<body>
<form action="" method="post" name="form1" id="form1">
  <table width="426" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <p><img src="themes/images/logo2.png" width="193" height="37" /></p>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <p>DELETE DATA</p>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td width="108" bgcolor="#FFCC66">Username:</td>
      <td width="308" bgcolor="#FFCC66"><label for="username"></label>
      <input name="username" type="text" id="username" value="<?php echo $row_searchingdisplay['username']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Password:</label></td>
      <td bgcolor="#FFCC66"><input name="password" type="text" id="password" value="<?php echo $row_searchingdisplay['password']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Name:</td>
      <td bgcolor="#FFCC66"><label>
        <input name="name" type="text" id="name" value="<?php echo $row_searchingdisplay['name']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Email:</label></td>
      <td bgcolor="#FFCC66"><input name="email" type="text" id="email" value="<?php echo $row_searchingdisplay['email']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Address :</label></td>
      <td bgcolor="#FFCC66"><textarea name="address1" id="address1"><?php echo $row_searchingdisplay['address1']; ?></textarea></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">&nbsp;</td>
      <td bgcolor="#FFCC66"><label>
        <textarea name="address2" id="address2"><?php echo $row_searchingdisplay['address2']; ?></textarea>
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td bgcolor="#FFCC66"><input name="postcode" type="text" id="postcode" value="<?php echo $row_searchingdisplay['postcode']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>State:</label></td>
      <td bgcolor="#FFCC66"><label for="state"></label>
      <input name="state" type="text" id="state" value="<?php echo $row_searchingdisplay['state']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Country:</label></td>
      <td bgcolor="#FFCC66"><input name="country" type="text" id="country" value="<?php echo $row_searchingdisplay['country']; ?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td bgcolor="#FFCC66"><input name="telnumber" type="text" id="telnumber" value="<?php echo $row_searchingdisplay['telnumber']; ?>" /></td>
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
              <p>&nbsp;</p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
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
</form>
</body>
</html>
<?php
mysql_free_result($searchingdisplay);
?>
