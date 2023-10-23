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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "usertype";
  $MM_redirectLoginSuccess = "adminmenu.php";
  $MM_redirectLoginFailed = "invalidform.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_ssrabbit, $ssrabbit);
  	
  $LoginRS__query=sprintf("SELECT username, password, usertype FROM customer WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $ssrabbit) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'usertype');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign In | Sweet Sour Rabbit</title>
</head>

<body>
<p>&nbsp;</p>
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="294" border="0" align="center">
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <p> SIGN IN</p>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFCC66"><a href="index.html"><img src="themes/images/logo2.png" width="193" height="37" /></a></td>
    </tr>
    <tr>
      <td width="101" bgcolor="#FFCC66">Username</td>
      <td width="183" bgcolor="#FFCC66"><label for="username"></label>
      <input type="text" name="username" id="username" /></td>
    </tr>
    <tr>
      <td bgcolor="#FFCC66">Password</td>
      <td bgcolor="#FFCC66"><label for="password"></label>
      <input type="password" name="password" id="password" /></td>
    </tr>
    <tr align="center">
      <td colspan="2" bgcolor="#FFCC66"><input type="submit" name="button" id="button" value="Submit" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
