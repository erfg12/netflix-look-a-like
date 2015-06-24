<?PHP include_once('functions.inc.php'); ?><head>
<script>
window.onunload = function() {
    if (window.opener && !window.opener.closed) {
        window.opener.popUpClosed();
    }
};
</script>
<script src="js/common.js"></script>
</head>

<?PHP if (isset($_GET['check'])==true) { ?>

<div style="font-size:16px;padding-bottom:10px;font-weight:bold;">Checking for new video files/folders, please wait... <input type="button" onclick="refreshAndClose()" value="Close Window" /></div>
<iframe src="check.inc.php?report" style="width:100%;height:85%;">
<?PHP } else { ?>
<?PHP $file = ".././data/$_GET[file]";
$readFile = arrayFile($file); ?>
<form method="post">
<input name="file" type="hidden" value="<?PHP echo $file; ?>">
Date File Added <input type="text" name="date_added" value="<?PHP echo $readFile[0]; ?>"><br>
Film Title <input type="text" name="title" value="<?PHP echo $readFile[1]; ?>"><br>
File Category <select name="file_category"><option <?PHP if ($readFile['2'] == "movie") { echo 'selected'; } ?>>movie</option><option <?PHP if ($readFile['2'] == "tvshow") { echo 'selected'; } ?>>tvshow</option></select><br>
File ID <input type="text" name="id" value="<?PHP echo $readFile[3]; ?>"><br>
Genre Category <input name="genre_category" type="text" value="<?PHP echo $readFile[4]; ?>"><br>
Film Rank <input type="text" name="rank" value="<?PHP echo $readFile[5]; ?>"><br>
File Location <input type="text" name="location" value="<?PHP echo $readFile[6]; ?>"><br>
Film Rating <input type="text" name="rating" value="<?PHP echo $readFile[7]; ?>"><br>
Film Description <textarea name="description" style="width:250px;height:75px;vertical-align:top;"><?PHP echo $readFile[8]; ?></textarea><br>
<br>
<input name="save" type="submit" value="SAVE" style="color:green;font-weight:bold;"> 
<input name="close" type="submit" value="CLOSE" style="font-weight:bold;"> 
<input name="delete" type="submit" value="DELETE" style="color:red;font-weight:bold;">
</form>

<?PHP
if (isset($_POST['save']) == true) {
	$fh = fopen($_POST['file'], 'w') or die("can't open file");
	unset($_POST['file']); unset($_POST['save']);
	fwrite($fh, implode("\n",$_POST));
	fclose($fh);
	?><script>window.close();</script><?PHP
} else if (isset($_POST['delete']) == true) {
	unlink($_POST['file']);
	?><script>window.opener.location.href = window.opener.location.href; window.close();</script><?PHP
} else if (isset($_POST['close']) == true) {
	?><script>window.close();</script><?PHP
}
} ?>