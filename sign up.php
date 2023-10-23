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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO customer (username, password, name, email, address1, address2, postcode, `state`, country, telnumber, gender, usertype) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
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
  $Result1 = mysql_query($insertSQL, $ssrabbit) or die(mysql_error());

  $insertGoTo = "success.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_ssrabbit, $ssrabbit);
$query_signup = "SELECT * FROM customer";
$signup = mysql_query($query_signup, $ssrabbit) or die(mysql_error());
$row_signup = mysql_fetch_assoc($signup);
$totalRows_signup = mysql_num_rows($signup);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign Up | Sweet Sour Rabbit</title>
</head>

<body>	
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
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
  <table width="474" border="0" align="center">
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <blockquote>
            <p>SIGN UP</p>
          </blockquote>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><img src="themes/images/logo2.png" width="193" height="37" /></td>
    </tr>
    <tr>
      <td width="108" align="left" bgcolor="#FFCC66">Username:</td>
      <td width="356" align="left" bgcolor="#FFCC66"><label>
        <input type="text" name="username" id="username" />
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Password:</label></td>
      <td align="left" bgcolor="#FFCC66"><input type="text" name="password" id="password" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66">Name:</td>
      <td align="left" bgcolor="#FFCC66"><label>
        <input type="text" name="name" id="name" />
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Email:</label></td>
      <td align="left" bgcolor="#FFCC66"><input type="text" name="email" id="email" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Address :</label></td>
      <td align="left" bgcolor="#FFCC66"><textarea name="address1" id="address1"></textarea></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66">&nbsp;</td>
      <td align="left" bgcolor="#FFCC66"><label>
        <textarea name="address2" id="address2"></textarea>
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Postcode:</label></td>
      <td align="left" bgcolor="#FFCC66"><input type="text" name="postcode" id="postcode" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>State:</label></td>
      <td align="left" bgcolor="#FFCC66"><label>
        <select name="state" id="state">
          <option>Choose below:</option>
          <option value="perak">Perak</option>
          <option value="selangor">Selangor</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Country:</label></td>
      <td align="left" bgcolor="#FFCC66"><input type="text" name="country" id="country" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66"><label>Tel Number:</label></td>
      <td align="left" bgcolor="#FFCC66"><input type="text" name="telnumber" id="telnumber" /></td>
    </tr>
    <tr>
      <td align="left" bgcolor="#FFCC66">Gender: </td>
      <td align="left" bgcolor="#FFCC66"><label>
        <input type="radio" name="gender" value="male" id="gender_0" />
        Male</label>
        <br />
        <label>
          <input type="radio" name="gender" value="female" id="gender_1" />
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
  <input type="hidden" name="MM_insert" value="form1" />
</form>
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($signup);
?>
