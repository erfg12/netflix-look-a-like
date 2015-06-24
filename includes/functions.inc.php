<?PHP
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// Created by: Jacob Fliss
// Website: http://newagesoldier.com
/////////////////////////////////////////////////////////////////////////////////////////////////////////

error_reporting(E_ALL & ~E_NOTICE);

//global variables
$prefix = '';
if (file_exists('includes'))
	$prefix = 'includes/';

$dataFolder = 'data/';
$langFolder = $prefix.'lang/';

//read our global settings file
$settings_file = $prefix.'settings.ini.php';
$settings_data = parse_ini_file($settings_file, true, 1);


$garbage = explode(',',$settings_data['garbage']);//array('.','..','downloaded from','.txt','Thumbs.db','placeholder');

require($langFolder.$settings_data['language'].'.php');

function loader($class) {
	global $prefix;
	include($prefix.'class/'.$class.'.class.php');
}
spl_autoload_register('loader');

//set defaults
if (!isset($_POST['category'])) 
	$_POST['category'] = "";
if (!isset($_GET['p']))
	$_GET['p'] = 1;
if (!isset($_COOKIE['mobile']))
	if (checkMobile()==true)
		setcookie('mobile','1',0);
		
$page_display = $settings_data['page_display'];
//$imdbToggle = $settings_data['imdb_mode'];

//check and set mobile cookie
if (isset($_GET['mobile']) == true){
	setcookie('mobile','1',0); 
	?><script type="text/javascript"> window.location = "mobile.php" </script><?PHP
}
if (isset($_COOKIE['mobile']) && $_COOKIE['mobile'] == "1" && basename($_SERVER['PHP_SELF']) == "index.php"){ 
	setcookie('mobile','1',0); 
	?><script type="text/javascript"> window.location = "mobile.php" </script><?PHP
} else if (isset($_GET['desktop'])){ 
	setcookie('mobile','0',0); 
	?><script type="text/javascript"> window.location = "index.php" </script><?PHP
}

if (!function_exists('curl_init'))
	echo '<div class="error_msg">'.$lang_function_curlDisabled.'</div>';

$template = new template();
	
////////////////	
// FUNCTIONS
////////////////
function readSettings($string) {
	return str_replace(',',"\n",$string);
}

function arrayFile($file) {
	$oldArray = explode("\n", file_get_contents($file));
	$newArray = array('date' => $oldArray[0], 'title' => $oldArray[1]); //NOT FINISHED
	return explode("\n", file_get_contents($file));
}

function settingsForm($string) {
	$new = explode(',',$string);
	$newFields = '';
	foreach($new as $formFields){
		$newFields .= '<option>'.$formFields.'</option>';
	}
	return $newFields;
}

function arraySettings($string) {
	return explode(',',$string);
}

function saveSettings($string) {
	return preg_replace('/\s+/',',',str_replace(array("\r\n","\r","\n"),' ',trim($string)));
}

function debugWrite ($message) {
	global $settings_data;
	if ($settings_data['debug_mode'] == 'true')
		echo $message;
}

function newFileCheck () {
	global $settings_data,$garbage,$lang_loading_text,$lang_loading_wait;
		
	$data_array = arraySettings($settings_data["directories"]);
	foreach ($data_array as $directories) {
		if ($directories == "" || empty($directories) || !file_exists($directories))
			break;
		if ($handle = opendir($directories)) {
    		while (false !== ($entry = readdir($handle))) {
				if (in_array($entry,$garbage))
					continue;
        		$value = $directories.'/'.$entry;
				$onlyFileName = strrchr($value,'/');
				if (file_exists('data/'.$onlyFileName.'.txt') == false){
					?><script>
					window.onload=function() {
						checkFiles();
						document.getElementById("fancybox-loading").innerHTML="<div style=\"color:black;text-align:center;padding-top:50px;font-size:21px;\"><?PHP echo $lang_loading_text; ?><p><?PHP echo $lang_loading_wait; ?></p></div>";
						$.fancybox.helpers.overlay.open({parent: $('body')});
					}
                    </script><?PHP
					exit();
				}
    		}
		}
	}
}

function debugStop () {
	global $settings_data;
	if ($settings_data['debug_mode'] == 'true')
		exit;
}

function purify ($string) {
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function decodeRawVideo ($url) {
	return str_replace(' ', '%20', urldecode($url));
}

function cleanWAMP ($string) {
	$string = str_replace(":","_",$string);
	return preg_replace('/[^(\x20-\x7F)]*/','',$string);
}

function checkPosterExists ($file) {
	$file = cleanWAMP($file);
	if (file_exists('pics/'.$file.'.jpg'))
		return true;
	else if (file_exists('pics/'.$file.'.gif'))
		return true;
	else if (file_exists('pics/'.$file.'.png'))
		return true;
	else if (file_exists('pics/'.$file.'.bmp'))
		return true;
	else 
		return false;
}

function file_type ($file) {
	global $settings_data;
	$type = 'tvshow';
	$extensions = arraySettings($settings_data["extensions"]);

	foreach ($extensions as $extension)
		if (stristr($file, '.'.purify($extension)))
			$type = 'movie';

	return $type;
}

function languages(){
	global $garbage,$langFolder;
	if ($handle = opendir($langFolder)) {
		while (false !== ($file = readdir($handle))) {
			if (!in_array($file, $garbage) && strstr($file,'.php')){
				$file = str_replace('.php','',$file);
				$files[] = $file;
			}
		}
		closedir($handle);
	}
	return $files;
}

function clean_title ($file) {
	global $settings_data;
	$file = str_replace('/', '', $file);
	$extensions = arraySettings($settings_data["extensions"]);
	$file = str_replace('.txt', '', $file);

	foreach ($extensions as $extension) //remove file extension
		$file = str_replace(purify($extension), '', $file);
	
	$file = str_replace('.', ' ', $file);
	if (stristr($file, " ("))
		$file = stristr($file, ' (', true);
	if (stristr($file, "DVD"))
		$file = stristr($file, 'DVD', true);
	$file = cleanWAMP($file);
	$file = trim($file);
	return $file;
}

function mins2hrs($min) {
	$min = abs($min);
	return sprintf("%dh %02dm", floor($min / 60), $min % 60);
}

function getDataFileName($file) {
	if (strstr($file,'/')){
		$file = explode('/',$file);
		$file = end($file);
	}
	return $file.".txt";
}

function checkMobile(){
	global $settings_data;
	$mobiles = arraySettings($settings_data["mobile"]);
	foreach ($mobiles as $mobile){
		if (stristr($_SERVER['HTTP_USER_AGENT'],$mobile)==true)
			return true;
	}
}

function sortFileList(){
	global $garbage,$dataFolder,$settings_data,$_POST;
	$files = array();
	
	if ($handle = opendir($dataFolder)) {
		while (false !== ($file = readdir($handle))) {
			if (!in_array($file, $garbage)){
				$videodata = explode("\n", file_get_contents($dataFolder.$file));
				if (isset($_GET['g'])) {
					if (stristr($videodata[4], $_GET['g']) === FALSE)
						continue;
				} else if (isset($_GET['search']) && isset($_POST['sname'])) {
					if (stristr($videodata[1], $_POST['sname']) === FALSE)
						continue;
				}
				$files[] = $dataFolder.$file;
			}
		}
		closedir($handle);
		if (!empty($files)){
			if ($settings_data["movie_order"] == 'SORT_ASC')
				array_multisort(array_map('filemtime', $files), SORT_ASC, $files);
			else
				array_multisort(array_map('filemtime', $files), SORT_DESC, $files);
		}
			
		return $files; 
	}
}

function sortSeasonsList($raw){
	global $garbage,$settings_data;
	
	if (!file_exists(cleanWAMP($raw)))
		return; //error
	
	if ($handle = opendir(cleanWAMP($raw))) {		
		while (false !== ($file = readdir($handle))) {
			if (!in_array($file, $garbage)){
				$files[] = $file;
			}
		}
		closedir($handle);
		if (!empty($files)){
			if ($settings_data["tvshow_season_order"] == 'SORT_ASC')
				array_multisort($files, SORT_ASC);
			else
				array_multisort($files, SORT_DESC);
		}
			
		return $files; 
	}
}

function sortEpisodesList($file){
	global $garbage,$settings_data;
	
	if (!in_array($file, $garbage))
		$files[] = $file;
		
	if (empty($files))
		return;
		
	$sortThis = $files[0];
		
	if ($settings_data["tvshow_episode_order"] == 'SORT_ASC')
		asort ($sortThis,SORT_STRING);
	else
		arsort ($sortThis,SORT_STRING);
	
	return $sortThis; 
}

function formatRating($rating){
	$color = ""; //WAMP
	$rating = strtoupper($rating);
	$rating = str_replace('_','',$rating);
	switch ($rating) {
		case "G":
			$color = "color:green;";
			break;
		case "PG":
			$color = "color:#069;";
			break;
		case "PG13":
			$color = "color:#1D1A4D;";
			break;
		case "R":
			$color = "color:red;";
			break;
		case "NR":
			$color = "color:gray;";
			break;
	}
	return '<span style="'.$color.'">'.$rating.'</span>';
}
?>