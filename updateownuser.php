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
  $updateSQL = sprintf("UPDATE customer SET password=%s, name=%s, email=%s, address1=%s, address2=%s, postcode=%s, `state`=%s, country=%s, telnumber=%s, gender=%s, usertype=%s WHERE username=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address1'], "text"),
                       GetSQLValueString($_POST['address2'], "text"),
                       GetSQLValueString($_POST['postcode'], "int"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['telnumber'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['usertype'], "text"));

  mysql_select_db($database_ssrabbit, $ssrabbit);
  $Result1 = mysql_query($updateSQL, $ssrabbit) or die(mysql_error());
}

$colname_searching_update = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_searching_update = $_SESSION['MM_Username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searching_update = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searching_update, "text"));
$searching_update = mysql_query($query_searching_update, $ssrabbit) or die(mysql_error());
$row_searching_update = mysql_fetch_assoc($searching_update);
$totalRows_searching_update = mysql_num_rows($searching_update);

$colname_searching_update = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_searching_update = $_SESSION['MM_Username'];
}
mysql_select_db($database_ssrabbit, $ssrabbit);
$query_searching_update = sprintf("SELECT * FROM customer WHERE username = %s", GetSQLValueString($colname_searching_update, "text"));
$searching_update = mysql_query($query_searching_update, $ssrabbit) or die(mysql_error());
$row_searching_update = mysql_fetch_assoc($searching_update);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
<blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <blockquote>
                      <blockquote>
                        <blockquote>
                          <blockquote>
                            <blockquote>
                              <blockquote>
                                <blockquote>&nbsp;</blockquote>
                              </blockquote>
                            </blockquote>
                          </blockquote>
                        </blockquote>
                      </blockquote>
                    </blockquote>
                  </blockquote>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
  <?php $_SESSION["MM_Username"]; ?><table width="474" border="0" align="center">
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <p>UPDATE DATA</p>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><img src="themes/images/logo2.png" width="193" height="37" /></td>
    </tr>
    <tr>
      <td width="108" align="left" bgcolor="#FFCC66">Username:</td>
      <td width="356" align="left" bgcolor="#FFCC66"><label><?php echo $row_searching_update['username']; ?></label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Password:</label></td>
      <td align="left" bgcolor="#FFCC66"><input name="password" type="text" id="password" value="<?php echo $row_searching_update['username']; ?>" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66">Name:</td>
      <td align="left" bgcolor="#FFCC66"><label>
        <input name="name" type="text" id="name" value="<?php echo $row_searching_update['name']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Email:</label></td>
      <td align="left" bgcolor="#FFCC66"><input name="email" type="text" id="email" value="<?php echo $row_searching_update['email']; ?>" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Address :</label></td>
      <td align="left" bgcolor="#FFCC66"><textarea name="address1" id="address1"><?php echo $row_searching_update['address1']; ?></textarea></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66">&nbsp;</td>
      <td align="left" bgcolor="#FFCC66"><label>
        <textarea name="address2" id="address2"><?php echo $row_searching_update['address2']; ?></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td align="left" bgcolor="#FFCC66"><input name="postcode" type="text" id="postcode" value="<?php echo $row_searching_update['postcode']; ?>" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>State:</label></td>
      <td align="left" bgcolor="#FFCC66"><label>
        <select name="state" id="state" title="<?php echo $row_searching_update['state']; ?>">
          <option>Choose below:</option>
          <option value="perak">Perak</option>
          <option value="selangor">Selangor</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Country:</label></td>
      <td align="left" bgcolor="#FFCC66"><input name="country" type="text" id="country" value="<?php echo $row_searching_update['country']; ?>" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td align="left" bgcolor="#FFCC66"><input name="telnumber" type="text" id="telnumber" value="<?php echo $row_searching_update['telnumber']; ?>" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66">Gender: </td>
      <td align="left" bgcolor="#FFCC66"><label>
        <input type="radio" name="gender" value="<?php echo $row_searching_update['gender']; ?>" id="gender_0" />
        Male</label>
        <br />
        <label>
          <input type="radio" name="gender" value="<?php echo $row_searching_update['gender']; ?>" id="gender_1" />
      Female</label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><p>
        <input name="usertype" type="hidden" id="usertype" value="user" />
      </p></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <p>
                <input type="submit" name="button" id="button" value="Submit" />
              </p>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
          <blockquote>
            <blockquote>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <blockquote>
                      <blockquote>
                        <blockquote>
                          <blockquote>&nbsp;</blockquote>
                        </blockquote>
                      </blockquote>
                    </blockquote>
                  </blockquote>
                </blockquote>
              </blockquote>
            </blockquote>
          </blockquote>
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($searching_update);
?>
