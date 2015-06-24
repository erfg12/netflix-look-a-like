<?PHP
include_once("includes/functions.inc.php");
$imdb = new Imdb();
	
$file = cleanWAMP(getDataFileName("$_GET[raw]"));
$cleanTitle = clean_title($file);

if (file_exists($dataFolder.$cleanTitle) !== false)
	exit(); //error
	
$handle = fopen($dataFolder.$file, "r");

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
<?PHP $template->headerFiles(false); ?>
</head>
<body>
<div id="dropmenu1" class="dropmenudiv">
<?PHP $template->printGenres(); ?>
</div>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td style="color:white;"><div style="padding:20px 0px 10px 0px;"><div class="webtitle"><?PHP echo $settings_data['title']; ?></div></div></td>
  </tr> 
</table>
<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td class="main_tab_table"><a href="index.php" class="tab_link"><div class="main_tab_selected"><?PHP echo $lang_template_library; ?></div></a><a href="admin.php" class="uptab_link_deselected"><div class="main_tab"><?PHP echo $lang_template_admin; ?></div></a>
	<div class="search_div">
	<?PHP $template->desktopSearch(); ?>
	</div></td>
	</tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
  <tr>
    <td class="dropmenu_container"><a class="tab_link"><div style="float:left;padding:8px 50px 8px 50px;" id="chromemenu">
    <a style="cursor:pointer;" rel="dropmenu1" class="tab_link"><?PHP echo $lang_template_genres; ?></a>
</div></a><a href="./" class="tab_link"><div style="float:left;padding:8px 20px 8px 20px;"><?PHP echo $lang_template_newVids; ?></div></a></td>
  </tr>
</table>

<table width="1200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E1E1E1" style="margin-left:auto;margin-right:auto;background-color:#E1E1E1;padding-bottom:20px;">
<?PHP
	if ($movieArray['title_id'] != "" && checkPosterExists($movieArray['title_id']) == false) 
		file_put_contents('pics/'.$movieArray['title_id'].'.jpg', file_get_contents($movieArray['poster'])); 
?>
  <tr>
    <td bgcolor="#FCFCFC">
    <div style="padding:50px;float:left;"><img src="<?PHP echo $template->printPoster($movieArray['title_id']); ?>" width="214" height="317"/><div style="text-align:center;padding-top:10px;"><div align="center"><div class="classification"><div class="cover"></div><div class="progress" style="width: <?PHP echo $movieArray['rating'] * 10; ?>%;"></div></div></div>
    </div></div>

    <div style="padding:50px;float:left;width:<?PHP if($toggle == "movie") { ?>500px<?PHP } else { ?>700px<?PHP } ?>;">
    <h2><?PHP echo $movieArray['title']; ?></h2>
    <div style="float:left;"><?PHP echo $movieArray['year']; ?></div><div style="float:left;padding-left:40px;"><?PHP if ($movieArray['movie_rating'] != ''){ echo strtoupper(str_replace('_', ' ', $movieArray['movie_rating'])); } else { ?>Unrated<?PHP } ?></div><div style="float:left;padding-left:40px;"><?PHP echo $movieArray['runtime']; ?> minutes</div><br /><br />

	<?PHP echo $movieArray['storyline']; ?><br /><br />
    <table width="550" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="66" align="right" valign="top"><strong><?PHP echo $lang_info_cast; ?>:</strong></td>
    <td width="464"><?PHP $cast_count = count($movieArray['cast']); $i = 0; foreach ($movieArray['cast'] as $cast) { $i++; echo $cast; if ($i >= $cast_count) { continue; } else { echo ', '; } } ?> <a href="http://www.imdb.com/title/<?PHP echo $movieArray['title_id']; ?>/fullcredits#cast" onClick="return popitup('http://www.imdb.com/title/<?PHP echo $movieArray['title_id']; ?>/fullcredits#cast')" style="text-decoration:none;">... more</a></td>
  </tr>
  <?PHP if ($toggle == "movie") { ?>
  <tr>
    <td align="right" valign="top"><strong><?PHP echo $lang_info_director; ?>:</strong></td>
    <td><?PHP $cast_count = count($movieArray['directors']); $i = 0; foreach ($movieArray['directors'] as $cast) { $i++; echo $cast; if ($i >= $cast_count) { continue; } else { echo ', '; } } ?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><?PHP echo $lang_info_writer; ?>:</strong></td>
    <td><?PHP $cast_count = count($movieArray['writers']); $i = 0; foreach ($movieArray['writers'] as $cast) { $i++; echo $cast; if ($i >= $cast_count) { continue; } else { echo ', '; } } ?></td>
  </tr>
  <tr>
	<?PHP } else { ?>
    <tr>
    <td align="right" valign="top"><strong><?PHP echo $lang_info_creators; ?>:</strong></td>
    <td><?PHP echo $movieArray['creators']; ?></td>
  </tr>
  <?PHP } ?>
    <td align="right" valign="top"><strong><?PHP echo $lang_info_genre; ?>:</strong></td>
    <td><?PHP $cast_count = count($movieArray['genres']); $i = 0; foreach ($movieArray['genres'] as $cast) { $i++; echo $cast; if ($i >= $cast_count) { continue; } else { echo ', '; } } ?></td>

  </tr>
</table>
</div>

<?PHP if ($toggle == "movie") { ?>
    <div style="padding:20px;float:left;width:150px;padding-top:50px;"><a href="play.php?video=<?PHP echo urlencode($_GET['raw']); ?>" title="Play Movie" style="text-decoration:none;" onClick="return playvideo('play.php?video=<?PHP echo urlencode($_GET['raw']); ?>')" ><div style="font-size:20px;background-color:#003366;width:100%;height:28px;color:white;text-align:center;cursor:pointer;">PLAY</div></a><br>
    </div>
<?PHP } ?>

<div style="clear:both;">&nbsp;</div>  
<div style="float:left;width:300px;font-size:16px;padding:0px 20px 20px 20px;"><b><?PHP echo $lang_info_details; ?></b><hr />
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="126" align="right" valign="top"><strong><?PHP echo $lang_info_release; ?>:</strong></td>
    <td width="109"><?PHP if ($movieArray['release_date'] != '') { echo $movieArray['release_date']; } else { echo 'N/A'; } ?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><?PHP echo $lang_info_oscars; ?>:</strong></td>
    <td><?PHP if ($movieArray['oscars'] != '') { echo $movieArray['oscars']; } else { if (isset($movieArray['oscars2']) && $movieArray['oscars2'] != '') { echo 'Nominated '.$movieArray['oscars2']; } else { echo 'N/A'; } } ?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><strong><?PHP echo $lang_info_random; ?>:</strong></td>
    <td><?PHP if($movieArray['tagline']!=''){ echo $movieArray['tagline']; } else { echo 'N/A'; } ?></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<div style="float:left;width:830px;border:thin #CCC solid;background-color:white;border-bottom:white;background-color:#CCCCCC;">

<?PHP if ($toggle == "movie"){ ?>
<a href="info.php?tab=trailers&name=<?PHP echo urlencode("$_GET[name]"); ?>&raw=<?PHP echo urlencode("$_GET[raw]"); ?>" title="Movie Trailers" alt="Movie Trailers" class="tab_link">
<div <?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'trailers')){ ?>class="selected_tab"<?PHP } else { ?>class="deselected_tab"<?PHP } } else { ?>class="selected_tab"<?PHP } ?>>Trailer</div></a>
<?PHP } else { ?>
<a href="info.php?tab=episodes&name=<?PHP echo urlencode("$_GET[name]"); ?>&raw=<?PHP echo urlencode("$_GET[raw]"); ?>" title="Movie Trailers" alt="Movie Trailers" class="tab_link">
<div <?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'episodes')){ ?>class="selected_tab"<?PHP } else { ?>class="deselected_tab"<?PHP } } else { ?>class="selected_tab"<?PHP } ?>>Episodes</div></a>
<?PHP } ?>

<a href="info.php?tab=photos&name=<?PHP echo urlencode("$_GET[name]"); ?>&raw=<?PHP echo urlencode("$_GET[raw]"); ?>" title="Movie Photos & Screenshots" alt="Movie Photos & Screenshots" class="tab_link">

<div <?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'photos')){ ?>class="selected_tab"<?PHP } else { ?>class="deselected_tab"<?PHP } } else { ?>class="deselected_tab"<?PHP } ?>>Photos</div></a>

<a href="info.php?tab=reviews&name=<?PHP echo urlencode("$_GET[name]"); ?>&raw=<?PHP echo urlencode("$_GET[raw]"); ?>" title="Movie Reviews" alt="Movie Reviews" class="tab_link">

<div <?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'reviews')){ ?>class="selected_tab"<?PHP } else { ?>class="deselected_tab"<?PHP } } else { ?>class="deselected_tab"<?PHP } ?>>Reviews</div></a></div>

<div style="float:left;width:830px;border:thin #CCC solid;padding:10px;background-color:white;border-top:white;">

<?PHP if ($toggle == "movie"){ ?>
<?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'trailers')){ echo '<div align="center"><iframe width="680" height="520" src="includes/trailer.php?url=http://www.imdb.com/video/imdb/'.$movieArray['trailer'].'/player"></iframe></div>'; } } else { echo '<div align="center"><iframe width="680" height="520" src="includes/trailer.php?url=http://www.imdb.com/video/imdb/'.$movieArray['trailer'].'/player"></iframe></div>'; }

} else {

if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'episodes')){ echo $template->episodeLists(); } } else { echo $template->episodeLists(); } 

}?>

<?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'photos')){ 
	echo $imdb->createPhotos($movieArray['media_images'],$settings_data['info_photos']);
 } } ?>

<?PHP if (isset($_GET['tab'])){ if (stristr($_GET['tab'],'reviews')){
	foreach ($imdb->getReviews($movieArray['title_id']) as $all_reviews)
		echo $all_reviews.'<hr>';
 } } ?>

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