<?PHP
include_once("includes/functions.inc.php");
$imdb = new Imdb();

$file = cleanWAMP(getDataFileName("$_GET[raw]"));

if (!file_exists($dataFolder.$file))
	exit(); //error
	
$handle = fopen($dataFolder.$file, "r");

$cleanTitle = clean_title($file);

if (isset($_GET['tab']) && $_GET['tab'] == "photos")
	$movieArray = $imdb->getMovieInfo($cleanTitle, 3);
else if ($settings_data['imdb_mode'] == 'false')
	$movieArray = arrayFile("$dataFolder/$file");
else
	$movieArray = $imdb->getMovieInfo($cleanTitle, 2);
	
if ($handle){
	$videodata = explode("\n", file_get_contents("$dataFolder/$file"));
	$toggle = cleanWAMP($videodata[2]);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?PHP echo $template->videoTitle($movieArray['title'],$movieArray['year']); ?></title>
<?PHP $template->headerFiles(true); ?>
</head>

<body>
<div class="bar" align="center"><a href="mobile.php"><img src="includes/img/home.png" border="0" /></a><a href="mobile.php?browse"><img src="includes/img/browse.png" border="0" /></a><a href="mobile.php?search"><img src="includes/img/search.png" border="0" /></a></div>

<div style="padding:10px;background-color:white;width:285px;overflow:auto;">
<?PHP 
$movie_rating = $movieArray['rating'] * 10;
?>
<div style="height:160px;">
<div style="float:left;"><img src="<?PHP echo $template->printPoster($movieArray['title_id']); ?>" border="0" width="100" height="150"></div>
<div style="float:left;padding:0px 0px 0px 10px;width:175px;"><div style="font-size:15px;font-weight:bold;"><?PHP echo $movieArray['title']; ?></div>
<span><?PHP echo $movieArray['year']; ?></span>
<span style="padding-left:10px;">
<?PHP if ($movieArray['movie_rating'] != ''){ echo str_replace('_', ' ', $movieArray['movie_rating']); } else { echo 'Unrated'; } ?></span>
<span style="padding-left:10px;"><?PHP echo mins2hrs($movieArray['runtime']); ?></span>
<div class="classification"><div class="cover"></div><div class="progress" style="width:<?PHP echo $movie_rating; ?>%;"></div>
</div></div>
</div>

<?PHP if ($toggle == "movie") { ?>
<div style="padding-bottom:10px;"><a href="play.php?video=<?PHP echo urlencode($_GET['raw']); ?>" target="_NEW" style="text-decoration:none;"><div style="font-size:20px;background-color:#003366;width:100%;height:28px;color:white;text-align:center;"><?PHP echo $lang_template_playBtn; ?></div></a></div>
<?PHP } else { 
	echo $template->mobileEpisodeLists();
} ?>

<?PHP echo $movieArray['storyline']; ?>
</div>

<?PHP $template->footer(); ?>
</body>
</html>