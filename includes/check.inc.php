<?PHP include_once('functions.inc.php');
if (isset($_GET['report'])) { ?>
<script src="includes/js/jquery-1.10.2.min.js"></script>
<?PHP }
$data_array = arraySettings($settings_data["directories"]);
$imdb = new Imdb();

$prefix = '.././';

foreach ($data_array as $directories) {
	$directories = $prefix.$directories;
	if ($handle = opendir($directories)) {
    	while (false !== ($entry = readdir($handle))) {
			if (in_array($entry,$garbage))
				continue;

        	$contents[] = $directories.'/'.$entry;
    	}
	}
}

if (!$contents)
	exit('<div class="error_msg">'.$lang_check_cantLocate.'</div>');

if (ob_get_level() == 0) ob_start();
foreach ($contents as $value) {
	if (in_array($value, $garbage))
		continue;
		
	$dirPath = str_replace($prefix,'',$value);
	$onlyFileName = strrchr($value,'/'); 
	$file_date = date("m/d/Y H:i:s", filectime($value));
	$file_type = file_type($onlyFileName);
	$clean_title = clean_title($onlyFileName);
	
	$datafile = $prefix.'data'.$onlyFileName.'.txt';
	
	if (file_exists($datafile))
		continue;
		
	debugWrite('[DEBUG] <b>Name:</b>'.$clean_title.' <b>File:</b>'.$onlyFileName.' <b>Type:</b>'.$file_type);
		
	if ($settings_data['imdb_mode'] == 'false') {
		touch($datafile);
		continue;
	}
	
	debugWrite(' ['.$lang_check_debugCreateFile.']<BR>');
	$fh = fopen($datafile, 'a') or die($lang_check_notWritable);
	$movieArray = $imdb->getMovieInfo($clean_title, 2);
	$genres = implode(',',$movieArray['genres']);
	$stringData = $file_date.PHP_EOL.$movieArray['title'].PHP_EOL.$file_type.PHP_EOL.$movieArray['title_id'].PHP_EOL.$genres.PHP_EOL.$movieArray['rating'].PHP_EOL.$dirPath.PHP_EOL.$movieArray['movie_rating'].PHP_EOL.$movieArray['plot'];
	fwrite($fh, $stringData);
	fclose($fh);

	if (!isset($movieArray['title_id']) || stristr($movieArray['poster'], 'ad.doubleclick.net'))
		continue;

	if (checkPosterExists($movieArray['title_id']) == false) //create movie poster
		file_put_contents($prefix.'pics/'.$movieArray['title_id'].'.jpg', file_get_contents($movieArray['poster'])); 
		
	debugWrite('[DEBUG] <b>stringData:</b>'.$stringData.' ['.$lang_check_debugContinue.']');
	debugStop();
	
	echo $value."<br>";
	
	flush();
    ob_flush();
	set_time_limit(30); 
}
ob_end_flush();

if (isset($_GET['report']))
	echo '<h1>'.$lang_check_done.'</h1>';
?>