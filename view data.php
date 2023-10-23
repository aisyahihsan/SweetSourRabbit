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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_VIEWDATA = 3;
$pageNum_VIEWDATA = 0;
if (isset($_GET['pageNum_VIEWDATA'])) {
  $pageNum_VIEWDATA = $_GET['pageNum_VIEWDATA'];
}
$startRow_VIEWDATA = $pageNum_VIEWDATA * $maxRows_VIEWDATA;

mysql_select_db($database_ssrabbit, $ssrabbit);
$query_VIEWDATA = "SELECT * FROM customer";
$query_limit_VIEWDATA = sprintf("%s LIMIT %d, %d", $query_VIEWDATA, $startRow_VIEWDATA, $maxRows_VIEWDATA);
$VIEWDATA = mysql_query($query_limit_VIEWDATA, $ssrabbit) or die(mysql_error());
$row_VIEWDATA = mysql_fetch_assoc($VIEWDATA);

if (isset($_GET['totalRows_VIEWDATA'])) {
  $totalRows_VIEWDATA = $_GET['totalRows_VIEWDATA'];
} else {
  $all_VIEWDATA = mysql_query($query_VIEWDATA);
  $totalRows_VIEWDATA = mysql_num_rows($all_VIEWDATA);
}
$totalPages_VIEWDATA = ceil($totalRows_VIEWDATA/$maxRows_VIEWDATA)-1;

$queryString_VIEWDATA = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_VIEWDATA") == false && 
        stristr($param, "totalRows_VIEWDATA") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_VIEWDATA = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_VIEWDATA = sprintf("&totalRows_VIEWDATA=%d%s", $totalRows_VIEWDATA, $queryString_VIEWDATA);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Data | Sweet Sour Rabbit</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;	</p>
  <table width="245" border="0" align="center">
    <tr>
      <td width="239" align="center" bgcolor="#FFCC66"><img src="themes/images/logo2.png" width="193" height="37" /></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFCC66"><blockquote>
        <blockquote>
          <p>View Data</p>
        </blockquote>
      </blockquote></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFCC66"><blockquote>
        <p><a href="adminmenu.php">Menu Admin</a></p>
      </blockquote></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="200" border="2" align="center">
    <tr>
      <td bgcolor="#FFCC66">USERNAME</td>
      <td bgcolor="#FFCC66">PASSWORD</td>
      <td bgcolor="#FFCC66">NAME</td>
      <td bgcolor="#FFCC66">EMAIL</td>
      <td bgcolor="#FFCC66">ADDRESS</td>
      <td bgcolor="#FFCC66">POSTCODE</td>
      <td bgcolor="#FFCC66">STATE</td>
      <td bgcolor="#FFCC66">COUNTRY</td>
      <td bgcolor="#FFCC66">TELEPHONE NUMBER</td>
      <td bgcolor="#FFCC66">GENDER</td>
      <td bgcolor="#FFCC66">USERTYPE</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_VIEWDATA['username']; ?></td>
        <td><?php echo $row_VIEWDATA['password']; ?></td>
        <td><?php echo $row_VIEWDATA['name']; ?></td>
        <td><?php echo $row_VIEWDATA['email']; ?></td>
        <td><?php echo $row_VIEWDATA['address1']; ?><?php echo $row_VIEWDATA['address2']; ?></td>
        <td><?php echo $row_VIEWDATA['postcode']; ?></td>
        <td><?php echo $row_VIEWDATA['state']; ?></td>
        <td><?php echo $row_VIEWDATA['country']; ?></td>
        <td><?php echo $row_VIEWDATA['telnumber']; ?></td>
        <td><?php echo $row_VIEWDATA['gender']; ?></td>
        <td><?php echo $row_VIEWDATA['usertype']; ?></td>
      </tr>
      <?php } while ($row_VIEWDATA = mysql_fetch_assoc($VIEWDATA)); ?>
  </table>
  <p>&nbsp;<a href="<?php printf("%s?pageNum_VIEWDATA=%d%s", $currentPage, 0, $queryString_VIEWDATA); ?>">First</a> <a href="<?php printf("%s?pageNum_VIEWDATA=%d%s", $currentPage, max(0, $pageNum_VIEWDATA - 1), $queryString_VIEWDATA); ?>">Previous</a> <a href="<?php printf("%s?pageNum_VIEWDATA=%d%s", $currentPage, min($totalPages_VIEWDATA, $pageNum_VIEWDATA + 1), $queryString_VIEWDATA); ?>">Next</a> <a href="<?php printf("%s?pageNum_VIEWDATA=%d%s", $currentPage, $totalPages_VIEWDATA, $queryString_VIEWDATA); ?>">Last</a></p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
<?php
mysql_free_result($VIEWDATA);
?>
