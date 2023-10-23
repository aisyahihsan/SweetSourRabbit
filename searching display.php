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

$colname_searchingDisplay = "-1";
if (isset($_GET['username'])) {
  $colname_searchingDisplay = $_GET['username'];
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
<title>Searching Display</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="426" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><img src="bunny2.jpg" width="316" height="371" /></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <p>DISPLAY DATA</p>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td width="108" bgcolor="#FFCC66">Username:</td>
      <td width="308" bgcolor="#FFCC66"><label>
        <input name="username" type="text" id="username" value="<?php echo $row_searchingDisplay['username']; ?>" />
      </label></td>
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
      <td bgcolor="#FFCC66"><p><br />
      </p></td>
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
mysql_free_result($searchingDisplay);
?>
