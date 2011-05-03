<?php
include "ctracker.php";
error_reporting( E_ERROR ^ E_WARNING );

// Next line sets the echelon userlevel for this page. 1=superadmins - 2=admins - 3=moderators
$requiredlevel = 3;
require_once('Connections/b3connect.php');
require_once('Connections/functions.php');
require_once('login/inc_authorize.php');

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_rs_activebans = 25;
$pageNum_rs_activebans = 0;
if (isset($_GET['pageNum_rs_activebans'])) {
  $pageNum_rs_activebans = $_GET['pageNum_rs_activebans'];
}
$startRow_rs_activebans = $pageNum_rs_activebans * $maxRows_rs_activebans;
$xlorderby_rs_activebans = "id";
if (isset($_GET['orderby'])) {
  $xlorderby_rs_activebans = (get_magic_quotes_gpc()) ? $_GET['orderby'] : addslashes($_GET['orderby']);
}
$xlorder_rs_activebans = "DESC";
if (isset($_GET['order'])) {
  $xlorder_rs_activebans = (get_magic_quotes_gpc()) ? $_GET['order'] : addslashes($_GET['order']);
}
mysql_select_db($database_b3connect, $b3connect);
//$query_rs_activebans = sprintf("SELECT penalties.id, penalties.type, penalties.time_add, penalties.time_expire, penalties.keyword, penalties.reason, penalties.inactive, penalties.duration, penalties.admin_id, coalesce(admin.name, 'b3') as admins_name, target.id as target_id, target.name as target_name FROM penalties, clients as target, clients as admin WHERE penalties.client_id = target.id LEFT JOIN penalties.admin_id = admin.id ORDER BY %s %s", $xlorderby_rs_activebans,$xlorder_rs_activebans);
$query_rs_activebans = sprintf("SELECT 
t1.id, 
t1.type, 
t1.time_add, 
t1.time_expire, 
t1.reason, 
t1.keyword,
t1.inactive, 
t1.duration, 
t2.id as target_id, 
t2.name as target_name, 
t1.admin_id, 
coalesce(t3.name, 'b3') as admins_name 
FROM penalties t1 
INNER JOIN clients t2 
ON t1.client_id = t2.id 
LEFT JOIN clients t3 
ON t1.admin_id = t3.id ORDER BY %s %s", $xlorderby_rs_activebans,$xlorder_rs_activebans);


$query_limit_rs_activebans = sprintf("%s LIMIT %d, %d", $query_rs_activebans, $startRow_rs_activebans, $maxRows_rs_activebans);
$rs_activebans = mysql_query($query_limit_rs_activebans, $b3connect) or die(mysql_error());
$row_rs_activebans = mysql_fetch_assoc($rs_activebans);
if (isset($_GET['totalRows_rs_activebans'])) {
  $totalRows_rs_activebans = $_GET['totalRows_rs_activebans'];
} else {
  $all_rs_activebans = mysql_query($query_rs_activebans);
  $totalRows_rs_activebans = mysql_num_rows($all_rs_activebans);
}
$totalPages_rs_activebans = ceil($totalRows_rs_activebans/$maxRows_rs_activebans)-1;
$queryString_rs_activebans = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs_activebans") == false && 
        stristr($param, "totalRows_rs_activebans") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs_activebans = "&" . implode("&", $newParams);
  }
}
$queryString_rs_activebans = sprintf("&totalRows_rs_activebans=%d%s", $totalRows_rs_activebans, $queryString_rs_activebans);
?>
<html>
  <head>
    <title>
      Echelon - B3 Repository Tool (by xlr8or)
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
      <!--
      @import url("css/default.css");
      -->
    </style>
  </head>
  <body>
    <div id="wrapper">
      <?php require_once('login/inc_loggedin.php'); ?>
      <?php include('Connections/inc_codnav.php'); ?>
      <table width="100%" class="tabeluitleg" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <strong>Recent Penalties</strong>
            <br>
            You are viewing the Recent Penalties.
 
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td class="tabelkop">
            client&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=target_name&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=target_name&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>
          <td class="tabelkop">
            type&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=type&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=type&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>
          <td class="tabelkop">
            duration&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=duration&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=duration&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>
          <td class="tabelkop">
            added&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=time_add&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=time_add&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>

          <td class="tabelkop">
            expires&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=time_expire&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=time_expire&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>
          <td class="tabelkop">
            admin&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=admins_name&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=admins_name&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>
          <td class="tabelkop">
            reason&nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=reason&order=ASC">
              <img src="img/asc.gif" alt="ascending" width="11" height="9" border="0" align="absmiddle"></a>
            &nbsp;
            <a href="<?php echo $navThisPage; ?>?game=<?php echo $game; ?>&orderby=reason&order=DESC">
              <img src="img/desc.gif" alt="descending" width="11" height="9" border="0" align="absmiddle"></a>
          </td>
        </tr>
        <?php do { ?>
        <tr class="tabelinhoud">
          <td title="penalty id : <?=$row_rs_activebans['id']?>">
            <a href="clientdetails.php?game=<?php echo $game; ?>&id=<?php echo $row_rs_activebans['target_id']; ?>">
              <?php echo htmlspecialchars($row_rs_activebans['target_name']); ?></a>
          </td>
          <td>
            <?php echo $row_rs_activebans['type']; ?>
          </td>
          <td>
            <?php if ($row_rs_activebans['duration']!=0) echo humanReadableDuration($row_rs_activebans['duration']*60) ; ?>
          </td>
          <td>
            <?php echo date('l, d/m/Y (H:i)',$row_rs_activebans['time_add']); ?>
          </td>
          <td>
<?php 
if ($row_rs_activebans['type'] == 'Notice'){
   echo "<span class=\"inactive\">Notice added by Admin</span>"; 
} elseif ($row_rs_activebans['type'] == 'Ban')  {
  echo "<span class=\"permanent\">permanent</span>";
} elseif ($row_rs_activebans['type'] == 'TempBan')  {
    if ($row_rs_activebans['time_expire'] <= time()) {
      echo "<span class=\"expired\">".date('l, d/m/Y (H:i)',$row_rs_activebans['time_expire'])."</span>"; 
    } else {
      echo "<span class=\"active\">".date('l, d/m/Y (H:i)',$row_rs_activebans['time_expire'])."</span>"; 
    }
} 
            ?>
          </td>
          <td>
            <?php echo $row_rs_activebans['admins_name']; ?>
          </td>
          <td>
            <?php echo preg_replace('/\\^([0-9])/ie', '', $row_rs_activebans['reason']); ?>
          </td>
        </tr>
        <?php } while ($row_rs_activebans = mysql_fetch_assoc($rs_activebans)); ?>
        <tr class="tabelonderschrift">
          <td>
            click client to see details
          </td>
          <td>
            &nbsp;
          </td>
          <td>
            &nbsp;
          </td>
          <td>
            &nbsp;
          </td>
          <td>
            <span class="expired">
              [expired ban]
            </span>
            <span class="active">
              [active ban]
            </span>
            <span class="permanent">
              [permban]
            </span>
          </td>
          <td>
            &nbsp;
          </td>
        </tr>
      </table>
      <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" class="recordnavigatie">
        <tr class="tabelkop">
          <td width="100%" colspan="4" align="center">
            Records:&nbsp;
            <?php echo ($startRow_rs_activebans + 1) ?>
            &nbsp;to&nbsp;
            <?php echo min($startRow_rs_activebans + $maxRows_rs_activebans, $totalRows_rs_activebans) ?>
            &nbsp;from&nbsp;
            <?php echo $totalRows_rs_activebans ?>
          </td>
        </tr>
        <tr>
          <td align="center" width="25%">
            <?php if ($pageNum_rs_activebans > 0) { // Show if not first page ?>
            <a href="<?php printf("%25s?pageNum_rs_activebans=%25d%25s", $currentPage, 0, $queryString_rs_activebans); ?>">First</a>
            <?php } // Show if not first page ?>
          </td>
          <td align="center" width="25%">
            <?php if ($pageNum_rs_activebans > 0) { // Show if not first page ?>
            <a href="<?php printf("%25s?pageNum_rs_activebans=%25d%25s", $currentPage, max(0, $pageNum_rs_activebans - 1), $queryString_rs_activebans); ?>">Previous</a>
            <?php } // Show if not first page ?>
          </td>
          <td align="center" width="25%">
            <?php if ($pageNum_rs_activebans < $totalPages_rs_activebans) { // Show if not last page ?>
            <a href="<?php printf("%25s?pageNum_rs_activebans=%25d%25s", $currentPage, min($totalPages_rs_activebans, $pageNum_rs_activebans + 1), $queryString_rs_activebans); ?>">Next</a>
            <?php } // Show if not last page ?>
          </td>
          <td align="center" width="25%">
            <?php if ($pageNum_rs_activebans < $totalPages_rs_activebans) { // Show if not last page ?>
            <a href="<?php printf("%25s?pageNum_rs_activebans=%25d%25s", $currentPage, $totalPages_rs_activebans, $queryString_rs_activebans); ?>">Last</a>
            <?php } // Show if not last page ?>
          </td>
        </tr>
      </table>
      <?php include "footer.php"; ?>
    </div>
  </body>
</html>
<?php
mysql_free_result($rs_activebans);
?>
