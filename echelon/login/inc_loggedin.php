<table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" class="head"><?php echo "Current time: ". date('l, d/m/Y (H:i)'). " Timezone: " . date_default_timezone_get() ."..... Logged in as: <strong>".$_SESSION['xlradmin']."</strong>. <a href=\"".$path."login/logout.php\">[logout]</a>";?></td>
  </tr>
    
</table>
