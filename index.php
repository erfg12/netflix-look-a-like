<?PHP include_once("includes/functions.inc.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo $settings_data['title']; ?></title>
<?PHP $template->headerFiles(false); ?>
</head>
<body>
<div id="dropmenu1" class="dropmenudiv">
<?PHP $template->printGenres(); ?>
</div>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="center">
  <tr>
    <td style="color:white;"><div style="padding:20px 0px 10px 0px;"><div class="webtitle"><?PHP echo $settings_data['title']; ?></div></div></td>
  </tr> 
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="center">
  <tr>
    <td class="main_tab_table"><a href="./" class="tab_link"><div class="main_tab_selected"><?PHP echo $lang_template_library; ?></div></a><a href="admin.php" class="uptab_link_deselected"><div class="main_tab"><?PHP echo $lang_template_admin; ?></div></a>
	<div class="search_div">
	<?PHP $template->desktopSearch(); ?>
	</div></td></tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="center">
  <tr>
    <td class="dropmenu_container"><a class="tab_link"><div style="float:left;padding:8px 50px 8px 50px;" id="chromemenu">
    <a style="cursor:pointer;" rel="dropmenu1" class="tab_link"><?PHP echo $lang_template_genres; ?></a>
</div></a><a href="./" class="tab_link"><div style="float:left;padding:8px 20px 8px 20px;"><?PHP echo $lang_template_newVids; ?></div></a></td>
  </tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="center" style="background-color:#E1E1E1;padding-bottom:20px;">
  <tr>
    <td bgcolor="#FCFCFC" style="padding-bottom:20px;">
<?PHP $template->indexVideos(); ?>
    </td>
  </tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" class="center">
  <tr>
    <td>
<?PHP $template->footer(true); ?>
</td>
</tr>
</table>

</body>
</html>