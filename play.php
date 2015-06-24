<?PHP 
include("includes/functions.inc.php");
$cleanFilename = decodeRawVideo($_GET['video']);  
$pathParts = pathinfo($_SERVER['PHP_SELF']); 
$videoURL = 'http://'.$_SERVER['HTTP_HOST'].'/'.basename(dirname($_SERVER['PHP_SELF'])).'/'.$cleanFilename;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script>
function loadObject() {
	var vlc_html = '';
	vlc_html += '<OBJECT classid="clsid:E23FE9C6-778E-49D4-B537-38FCDE4887D8" codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab" width=750 height=750 id="vlc" events="True" VIEWASTEXT>';
	vlc_html += '<param name="MRL" value="<?PHP echo $cleanFilename; ?>" />';
	vlc_html += '<param name="ShowDisplay" value="True" />';
	vlc_html += '<param name="AutoLoop" value="False" />';
	vlc_html += '<param name="AutoPlay" value="true" />';
	vlc_html += '<param name="Volume" value="100" />';
	vlc_html += '</OBJECT>';
	document.write(vlc_html);
}
</script>
<title><?PHP echo $lang_title_play; ?></title>
<?PHP if (isset($_SERVER['HTTP_USER_AGENT']) &&(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) { ?>

<?PHP } else { ?>
<script>
var vlcInstalled= false;
if (navigator.plugins && navigator.plugins.length) {
	for (var i=0; i < navigator.plugins.length; i++ ) {
		var plugin = navigator.plugins[i];
		if (plugin.name.indexOf("VideoLAN") > -1 || plugin.name.indexOf("VLC") > -1) {
			vlcInstalled = true;
		}
	}
}
</script>
<?PHP } ?>
</head>
<body style="background-color:black;">

<?PHP if (checkMobile() == true) { ?>
<video controls src="http://<?PHP echo $_SERVER['HTTP_HOST']?><?PHP echo $pathParts['dirname']; ?>/<?PHP echo $cleanFilename; ?>" style="width:100%;height:100%;"><?PHP echo $lang_video_cantPlay; ?></video>
<?PHP } else { ?>
<div align="center">

<!-- VLC start -->
<?PHP if ($settings_data['player_type']=='vlc') { ?>
<script> if ( vlcInstalled == false ) { document.write('<a href="http://www.videolan.org/vlc"><?PHP echo $lang_video_vlcRequired; ?><br><?PHP echo $lang_video_vlcDownload; ?></a></div>'); } </script>
<?PHP if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) { ?>
<div align="center"><script language="Javascript">loadObject();</script></div>
<?PHP } else { ?>
<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" version="VideoLAN.VLCPlugin.2" width="750" height="750" autoplay="yes" target="<?PHP echo $videoURL; ?>" id="vlc"></embed>
<?PHP } ?>
<!-- VLC end -->

<!-- Embeded Start -->
<?PHP } else if ($settings_data['player_type']=='embeded') { ?>
<embed src="<?PHP echo $videoURL; ?>" width="750" height="750"></embed>
<!-- Embeded End -->

<!-- HTML5 Start -->
<?PHP } else if ($settings_data['player_type']=='html5') { ?>
<video controls width="750" height="750" src="<?PHP echo $videoURL; ?>" type="<?PHP echo file_type($videoURL); ?>">
Your browser does not support HTML5 video.
</video>
<!-- HTML5 End -->

<!-- Flash Start -->
<?PHP } else if ($settings_data['player_type']=='flash') { ?>
<object type="application/x-shockwave-flash" data="<?PHP echo $videoURL; ?>" width="750" height="750">
<param name="movie" value="<?PHP echo $videoURL; ?>" /><param name="quality" value="high"/>
</object>
<!-- Flash End -->

<?PHP } ?>
</div>
<?PHP } ?>

</body>
</html>
