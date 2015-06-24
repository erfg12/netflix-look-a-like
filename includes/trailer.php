<link rel="stylesheet" href="css/style.css" type="text/css" />

<body class="trailer_body">
<div class="trailer_div">
<?PHP if (isset($_GET['play'])==false){ ?>
	<a href="trailer.php?url=<?PHP echo $_GET['url']; ?>&play" class="trailer_link" title="Play Movie Trailer">PLAY<br>TRAILER</a>
<?PHP } else {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $_GET['url']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	$output = str_replace('"/images/js/app/video/mediaplayer.swf"', '"http://www.imdb.com/images/js/app/video/mediaplayer.swf"', $output);
	echo $output;
	curl_close($ch);   
} ?>
</div>
</body>