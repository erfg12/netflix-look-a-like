<?PHP include_once("includes/functions.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?PHP $template->headerFiles(true); ?>
<title><?PHP echo $settings_data['title']; ?></title>
</head>

<body>
<div class="bar" align="center"><a href="mobile.php"><img src="includes/img/home.png" border="0" /></a><a href="mobile.php?browse"><img src="includes/img/browse.png" border="0" /></a><a href="mobile.php?search"><img src="includes/img/search.png" border="0" /></a></div>

<div style="padding:10px;background-color:white;width:285px;">
<h2><?PHP echo $settings_data['title']; ?></h2>
<?PHP 
echo $template->mobileSearch();

echo $template->mobileVideos();
?>

<p><a href="mobile.php?desktop"><?PHP echo $lang_mobile_desktop; ?></a></p>

</div>
<?PHP $template->footer(); ?>
</body>
</html>