<?PHP
session_start();
include_once('includes/functions.inc.php');
$admin_pass = $settings_data['admin_password'];

if (isset($_POST['submit_pass'])){
	if ($_POST['password'] == $admin_pass){
		$_SESSION['admin'] = $_POST['password'];
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo $lang_title_admin; ?></title>
<?PHP $template->headerFiles(false); ?>
<
</head>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td style="color:white;"><div style="padding:20px 0px 10px 0px;"><div class="webtitle"><?PHP echo $settings_data['title']; ?></div></div></td>
  </tr> 
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td class="main_tab_table"><a href="./" class="uptab_link_deselected"><div class="main_tab"><?PHP echo $lang_template_library; ?></div></a><a href="admin.php" class="tab_link"><div class="main_tab_selected"><?PHP echo $lang_template_admin; ?></div></a>
	<div class="search_div">
	<?PHP $template->desktopSearch(); ?>
	</div></td>
  </tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td class="dropmenu_container"><a href="admin.php" class="tab_link"><div style="float:left;padding:8px 50px 8px 50px;"><?PHP echo $lang_admin_settings; ?></div></a><a href="admin.php?data" class="tab_link"><div style="float:left;padding:8px 50px 8px 50px;"><?PHP echo $lang_admin_data; ?></div></a><a href="admin.php?help" class="tab_link"><div style="float:left;padding:8px 50px 8px 50px;"><?PHP echo $lang_admin_help; ?></div></a></td>
  </tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E1E1E1" style="margin-left:auto;margin-right:auto;background-color:#E1E1E1;padding-bottom:20px;">
  <tr>
    <td bgcolor="#FCFCFC">
<div style="padding:10px;">

<?PHP
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != $admin_pass){ ?>
	<h2><?PHP echo $lang_admin_admLogin; ?></h2>
    <form action="admin.php" method="post">
    <?PHP if (isset($_POST['password'])) { if ($_POST['password'] != $admin_pass){ echo '<p style="color:red;font-weight:bold;">'.$lang_admin_incPass.'</p>'; } } ?>
	<?PHP echo $lang_admin_pass; ?>: <input name="password" type="password"><br>
<br>
<input name="submit_pass" type="submit" value="Login">
</form>
<?PHP } else { ?>

<?PHP if (isset($_GET['data']) == true) { ?>
<h2><?PHP echo $lang_admin_cacheData; ?></h2>
<div style="margin-bottom:20px;"><a onClick="return popitup('includes/edit.php?check')" class="checklink"><?PHP echo $lang_admin_checkFiles; ?></a></div>

<?PHP
foreach(scandir($dataFolder) as $file) {
	if (in_array($file,$garbage))
		continue;
	echo '<a style="line-height:20px;" href="javascript:;" onClick="return popitup(\'includes/edit.php?file='.urlencode($file).'\')">'.str_replace('.txt', '', $file).'</a><br>';
}

} else if (isset($_GET['help']) == true) { ?>

<h2><?PHP echo $lang_admin_softHelp; ?></h2>

<?PHP foreach ($lang_admin_faq as $key => $value) { ?>
<div class="faq_title"><?PHP echo $key; ?></div>
<div class="faq_desc"><?PHP echo $value; ?></div>
<?PHP } ?>

<?PHP } else { ?>
<h2><?PHP echo $lang_admin_generalSettings; ?></h2>
<form action="admin.php" method="post">
<?PHP
if (isset($_POST['save'])){

	if (!isset($_POST['debug_mode']))
		$_POST['debug_mode'] = 'false';
	if ($_POST['debug_mode'] != 'true')
		$_POST['debug_mode'] = 'false';
		
	if (!isset($_POST['imdb_mode']))
		$_POST['imdb_mode'] = 'false';
	if ($_POST['imdb_mode'] != 'true')
		$_POST['imdb_mode'] = 'false';

	$replace_with = array(
		'title' => $_POST['title'],
		'fp_display' => $_POST['fp_display'],
		'page_display' => $_POST['page_display'],
		'm_display' => $_POST['m_display'],
		'debug_mode' => $_POST['debug_mode'],
		'movie_order' => $_POST['movie_order'],
		'language' => $_POST['language'],
		'info_photos' => $_POST['info_photos'],
		//'imdb_mode' => $_POST['imdb_mode'],
		'tvshow_season_order' => $_POST['tvshow_season_order'],
		'tvshow_episode_order' => $_POST['tvshow_episode_order'],
		'player_type' => $_POST['player_type'],
		'google_domain' => $_POST['google_domain'],
		'directories' => saveSettings($_POST['directories']),
		'mobile' => saveSettings($_POST['mobile']),
		'extensions' => saveSettings($_POST['extensions']),
		'genres' => saveSettings($_POST['genres']),
		'garbage' => saveSettings($_POST['garbage'])
	);

	$fh = fopen($settings_file, 'w');

	foreach ( $settings_data as $key => $value ) {
		if (!empty($replace_with[$key]))
			$value = $replace_with[$key];

		fwrite($fh, "{$key}={$value}".PHP_EOL);
	}
	fclose($fh);
	
	?><script type="text/javascript"> window.location = "admin.php" </script><?PHP
}
?>
<div style="float:left;">
<table>
  <tr>
    <td width="200" valign="middle" align="right"><strong><?PHP echo $lang_admin_title; ?>:</strong></td>
    <td width="292" align="left"><input name="title" type="text" value="<?PHP echo $settings_data['title']; ?>" style="width:100%;"></td> 
  </tr>  
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_fpDisplay; ?>:</strong></td>
    <td align="left"><input name="fp_display" type="text" value="<?PHP echo $settings_data['fp_display']; ?>" style="width:100%;"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_vidsPerPage; ?>:</strong></td>
    <td align="left"><input name="page_display" type="text" value="<?PHP echo $settings_data['page_display']; ?>" style="width:100%;"></td>
  </tr> 
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_vidsPerPageMobile; ?>:</strong></td>
    <td align="left"><input name="m_display" type="text" value="<?PHP echo $settings_data['m_display']; ?>" style="width:100%;"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_googleDomain; ?>:</strong></td>
    <td align="left"><input name="google_domain" type="text" value="<?PHP echo $settings_data['google_domain']; ?>" style="width:100%;"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_infoPhotos; ?>:</strong></td>
    <td align="left"><input name="info_photos" type="text" value="<?PHP echo $settings_data['info_photos']; ?>" style="width:100%;"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_language; ?>:</strong></td>
    <td align="left">
    <select name="language" style="width:300px;">
    <?PHP foreach (languages() as $lang) { ?>
    <option <?PHP if ($settings_data['language'] == $lang) { echo 'selected'; } ?>><?PHP echo $lang; ?></option>
    <?PHP } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_movieOrder; ?>:</strong></td>
    <td align="left">
    <select name="movie_order" style="width:300px;">
    <option <?PHP if ($settings_data['movie_order'] == "SORT_DESC") { echo 'selected'; } ?> value="SORT_DESC"><?PHP echo $lang_admin_desc; ?></option>
    <option <?PHP if ($settings_data['movie_order'] == "SORT_ASC") { echo 'selected'; } ?> value="SORT_ASC"><?PHP echo $lang_admin_asc; ?></option>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_seasonOrder; ?>:</strong></td>
    <td align="left">
    <select name="tvshow_season_order" style="width:300px;">
    <option <?PHP if ($settings_data['tvshow_season_order'] == 'SORT_DESC') { echo 'selected'; } ?> value="SORT_DESC"><?PHP echo $lang_admin_desc; ?></option>
    <option <?PHP if ($settings_data['tvshow_season_order'] == 'SORT_ASC') { echo 'selected'; } ?> value="SORT_ASC"><?PHP echo $lang_admin_asc; ?></option>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_episodeOrder; ?>:</strong></td>
    <td align="left">
    <select name="tvshow_episode_order" style="width:300px;">
    <option <?PHP if ($settings_data['tvshow_episode_order'] == 'SORT_DESC') { echo 'selected'; } ?> value="SORT_DESC"><?PHP echo $lang_admin_desc; ?></option>
    <option <?PHP if ($settings_data['tvshow_episode_order'] == 'SORT_ASC') { echo 'selected'; } ?> value="SORT_ASC"><?PHP echo $lang_admin_asc; ?></option>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_playerType; ?>:</strong></td>
    <td align="left">
    <select name="player_type" style="width:300px;" onchange="showDiv(this)">
    <option <?PHP if ($settings_data['player_type'] == 'vlc') { echo 'selected'; } ?> value="vlc">VideoLAN Player</option>
    <option <?PHP if ($settings_data['player_type'] == 'embeded') { echo 'selected'; } ?> value="embeded">Embeded (QuickTime, WMPlayer etc.) Player</option>
    <option <?PHP if ($settings_data['player_type'] == 'html5') { echo 'selected'; } ?> value="html5">HTML5 Player</option>
    <option <?PHP if ($settings_data['player_type'] == 'flash') { echo 'selected'; } ?> value="flash">SWF Flash Player</option>
    </select>
	<!--
	I will bring this to v2.0
	<div id="hidden_div">VLC TEST</div>
	-->
    </td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_debugMode; ?>:</strong></td>
    <td align="left"><input name="debug_mode" type="checkbox" value="true" <?PHP if ($settings_data['debug_mode'] == 'true') { echo 'checked="checked"'; } ?> /></td>
  </tr>
  <!--
  I will bring this to v2.0
  <tr>
    <td align="right" valign="middle"><strong><?PHP //echo $lang_admin_imdb; ?>:</strong></td>
    <td align="left"><input name="imdb_mode" type="checkbox" value="true" <?PHP //if ($settings_data['imdb_mode'] == 'true') { echo 'checked="checked"'; } ?> onchange='chkMsg(this);' /></td>
  </tr>
  -->
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_fileDirectories; ?>:</strong>
      <br />(<?PHP echo $lang_admin_onePerLine; ?>)</td>
    <td align="left"><textarea name="directories" cols="45" rows="4" style="width:100%;"><?PHP echo readSettings($settings_data['directories']); ?></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_mobileBrowsers; ?>:</strong>
      <br />(<?PHP echo $lang_admin_onePerLine; ?>)</td>
    <td align="left"><textarea name="mobile" cols="45" rows="4" style="width:100%;"><?PHP echo readSettings($settings_data['mobile']); ?></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_videoExt; ?>:</strong>
      <br />(<?PHP echo $lang_admin_onePerLine; ?>)</td>
    <td align="left"><textarea name="extensions" cols="45" rows="4" style="width:100%;"><?PHP echo readSettings($settings_data['extensions']); ?></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_genres; ?>:</strong>
      <br />(<?PHP echo $lang_admin_onePerLine; ?>)</td>
    <td align="left"><textarea name="genres" cols="45" rows="4" style="width:100%;"><?PHP echo readSettings($settings_data['genres']); ?></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong><?PHP echo $lang_admin_garbageFilter; ?>:</strong>
      <br />(<?PHP echo $lang_admin_onePerLine; ?>)</td>
    <td align="left"><textarea name="garbage" cols="45" rows="4" style="width:100%;"><?PHP echo readSettings($settings_data['garbage']); ?></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="right"><input name="save" type="submit" value="Save Information" /></form></td>
  </tr>
</table>
</div>

<div style="float:left;padding-left:20px;">
<table width="300" border="0">
  <tr>
    <td>
    <div style="line-height:20px;">
    <b><?PHP echo $lang_admin_currentVer; ?>:</b> <?PHP echo $settings_data["version"]; ?><br />
	<b><?PHP echo $lang_admin_author; ?>:</b> Jacob "NeWaGe" Fliss<br />
	<b><?PHP echo $lang_admin_support; ?>:</b> <a href="http://newagesoldier.com/netflix-site/">http://newagesoldier.com</a><br />
	<h2>Server Information</h2>
	<b><?PHP echo $lang_admin_IP; ?>:</b> <?PHP echo $_SERVER['REMOTE_ADDR']; ?><br />
	<b>cURL Status:</b> <?PHP if (!function_exists('curl_init')) echo '<span style="color:red;">Disabled</span>'; else echo '<span style="color:green;">Enabled</span>'; ?><br />
	<b>Software Version:</b> 1.91<br />
	<b>Build Date:</b> January 14th, 2015<br />
    <div style="margin-left:auto;margin-right:auto;text-align:center;margin-top:20px;">
	<iframe src="https://newagesoldier.com/myfiles/donations.html" width="400" height="350" frameborder="0" style="border:black thin solid;"></iframe>
	</div></div>
	</td>
  </tr>
</table>
</div>
<br>
<?PHP } } ?>
</div>
    </td>
  </tr>
</table>
<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td>
<?PHP $template->footer(); ?>
</td>
</tr>
</table>

</body>
</html>