<?php
$navThisPage = $_SERVER["PHP_SELF"];
$game = "";
$search = "";
include_once('b3connect.php');
if (!empty($_GET['game'])) {
  $game = $_GET['game']; }
else {
  $game = "1"; }
if (!empty($_GET['search'])) {
  $search = $_GET['search']; }
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="navigatie">
  <tr>
    <td>
<?php if ($xlrdatabase == "multi")
    {
    $navcounter = 1;
    while ($navcounter <= $numservers) {
      if ($navcounter == 1) { echo "[ "; }
        else { echo " | "; }
      echo "<a href=\"" . $navThisPage . "?game=" . $navcounter;
      if (!empty($_GET['search'])) { echo "&search=" . $_GET['search']; }
      echo "\"";
      if ($game == $navcounter) { echo " class=\"activegame\">"; }
      else { echo " class=\"navigatie\">"; }
      echo "${gamename[$navcounter]}";
      echo "</a>";
      $navcounter++;
      }
	  echo " ] :";
    }
      ?>
      <?php /* DO NOT MODIFY ANYTHING ABOVE THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING */?>
      <a href="<?php echo $path; ?>clients.php?game=<?php echo $game; ?>" <?php if (preg_match('#/clients.php#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Clients</a>
      | 
      <a href="<?php echo $path; ?>adminbans.php?game=<?php echo $game; ?>" <?php if (preg_match('#/adminbans.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Admin-bans</a>
      | 
      <a href="<?php echo $path; ?>adminkicks.php?game=<?php echo $game; ?>" <?php if (preg_match('#/adminkicks.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Admin-kicks</a>
      | 
      <a href="<?php echo $path; ?>b3kicks.php?game=<?php echo $game; ?>" <?php if (preg_match('#/b3kicks.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>B3 auto kicks/bans</a>
      | 
      <a href="<?php echo $path; ?>toppenalties.php?game=<?php echo $game; ?>" <?php if (preg_match('#/toppenalties.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Toplist Penalties</a>
      | 
	  <a href="<?php echo $path; ?>recentpenalties.php?game=<?php echo $game; ?>" <?php if (preg_match('#/recentpenalties.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Recent Penalties</a>
      | 
      <a href="<?php echo $path; ?>notices.php?game=<?php echo $game; ?>" <?php if (preg_match('#/notices.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Notices list</a>
      <?php if ($chatlogger_plugin_activated == 1) { ?>
      | 
      <a href="<?php echo $path; ?>chats.php?game=<?php echo $game; ?>" <?php if (preg_match('#/chats.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Chatlog</a>
      <?php } ?>
      | 
      <a href="<?php echo $path; ?>links.php?game=<?php echo $game; ?>" <?php if (preg_match('#/links.php$#i',$_SERVER["PHP_SELF"])!=FALSE) echo 'class="activegame"'; else echo 'class="navigatie"'; ?>>Links</a>
      
      &nbsp;&nbsp;&nbsp;[&nbsp;<a href="<?php echo $path; ?>pubbans.php" class="navigatie">public bans page</a>
      &nbsp;|&nbsp;<a href="<?php echo $path; ?>banlist.php" class="navigatie">public banlist.txt</a>&nbsp;]
      <?php /* DO NOT MODIFY ANYTHING BELOW THIS LINE */?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelinhoud">
  <tr>
    <td>
      &nbsp;
    </td>
  </tr>
</table>
