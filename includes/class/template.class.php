<?PHP
class template {
	public function headerFiles ($mobile) {
		if ($mobile){
			?><link rel="stylesheet" href="includes/css/mobile.css" type="text/css" />
			<meta name="viewport" content="width=300" />
			<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' /><?PHP
		} else {
			?><link rel="stylesheet" href="includes/css/style.css" type="text/css" /><?PHP
		} ?>
		<link rel="stylesheet" href="includes/css/style.css" type="text/css" />
		<link rel="stylesheet" href="includes/css/jquery.fancybox.css" type="text/css" />
		<link rel="stylesheet" href="includes/css/lightbox.css" type="text/css" />
		<script src="includes/js/jquery-1.10.2.min.js"></script>
		<script src="includes/js/jquery-ui-1.8.18.custom.min.js"></script>
		<script src="includes/js/jquery.fancybox.js"></script>
		<script src="includes/js/lightbox-2.6.min.js"></script>
		<script src="includes/js/common.js"></script>
		<script src="includes/js/chrome.js"></script>
		<meta name="robots" content="NOINDEX, NOFOLLOW">
		<?PHP
	}
	
	public function videoTitle ($title,$year='') {
		if ($year != '')
			return $title.' ('.$year.')';
		else
			return $title;
	}
	
    public function printPoster ($file) {
		$file = purify($file);
		if (file_exists('pics/'.$file.'.jpg'))
			return 'pics/'.$file.'.jpg';
		else if (file_exists('/pics/'.$file.'.gif'))
			return 'pics/'.$file.'.gif';
		else if (file_exists('/pics/'.$file.'.png'))
			return 'pics/'.$file.'.png';
		else if (file_exists('/pics/'.$file.'.bmp'))
			return 'pics/'.$file.'.bmp';
		else 
			return 'includes/img/unavailable.jpg';
	}

	public function printVideos($fp,$page=1,$genre="",$search=""){
		global $settings_data,$lang_search_noneFound,$lang_search_category_noneFound,$lang_search_noneFound,$lang_folder_empty;
		$files = sortFileList();
		
		if (empty($files)) {
			$files[] = "";
			if (isset($_GET['search']))
				$errorMSG = $lang_search_noneFound;
			else if (isset($_GET['g']))
				$errorMSG = $lang_search_category_noneFound;
			else
				$errorMsg = $lang_folder_empty;
			echo '<div class="novideosfound">'.$errorMSG.'</div>';
		}
		
		$nextpage = $page * $settings_data['page_display'];
		$previous = $nextpage - $settings_data['page_display'];
		
		$i=0;
		foreach ($files as $entry) {
			$i++;
			if (file_exists($entry)) { //WAMP
				if ($fp == false) {
					if (($i > $nextpage) || ($i <= $previous))
						continue;
				} else {
					if ($i > $settings_data['fp_display'])
						break;
				}

				$videodata = explode("\n", file_get_contents($entry));
				if (!isset($videodata[5]) || !isset($videodata[1]) || !isset($videodata[3]))
					continue;
				
				$movie_rating = $videodata[5] * 10; ?>

				<div style="float:left;padding:50px 0px 0px 60px;width:214px;height:317px;"><div class="one">
    			<a href="info.php?name=<?PHP echo urlencode(cleanWAMP($videodata[1])); ?>&raw=<?PHP echo urlencode(cleanWAMP($videodata[6])); ?>" class="hovercover">
    			<div class="two"><?PHP echo $videodata[1]; ?><div class="classification" style="margin-top:5px;">
                <div class="cover"></div>
    			<div class="progress" style="width: <?PHP echo $movie_rating; ?>%;"></div>
    			<div class="fp_rated">Rated: <?PHP echo formatRating($videodata[7]); ?></div>
    			<div class="fp_plot"><?PHP echo $videodata[8]; ?></div>
    			</div></div><img src="<?PHP echo $this->printPoster($videodata[3]); ?>" border="0" width="214" height="317">
    			</a></div></div>

				<?PHP
			}
		}
		if ($fp == false){
			$prev = $page - 1;
			$prev_link = '<div class="nav"><a href="./?p='.$prev; 
			if ($genre != "")
				$prev_link .= '&g='.$genre; 
			if ($search != "")
				$prev_link .= '&search='.$search; 
			$prev_link .= '">< back</a></div>';
			
			$next = $page + 1;
			$next_link = '<div class="nav"><a href="./?p='.$next; 
			if ($genre != "")
				$next_link .= '&g='.$genre; 
			if ($search != "")
				$next_link .= '&search='.$search; 
			$next_link .= '">next ></a></div>';

			if ($page == 1)
				$prev_link = strip_tags($prev_link);
			if ($i <= $nextpage)
				$next_link = strip_tags($next_link);
			echo '<div class="navcontainer"><div class="navprev">'.$prev_link.'</div>
			<div class="navnext">'.$next_link.'</div></div>';
		}
	}

	public function printMobileVideos($fp,$name="",$cat=""){
		global $settings_data,$lang_search_searchingFor;
		$searchContent = "";
		if (isset($_POST['sname']))
			$searchContent = $_POST['sname'];
			
		if ($fp == false){
			if ($name != "")
				echo '<div class="mobilesearch"><h3>'.$lang_search_searchingFor.' "'.$searchContent.'"</h3></div>';
			else if ($cat != "" && $name != "")
				echo '<div class="pick">'.$lang_mobile_pickVideo.'</div>';
		}
		$files = sortFileList();

		$i=1;
		foreach ($files as $entry) {
			$videodata = explode("\n", file_get_contents($entry));
			$movie_rating = $videodata[5] * 10;
			if ($cat != "" && strstr($videodata[4], $cat) == false)
				continue;
			?>

			<div style="width:100%;height:170px;"><a href="m_info.php?name=<?PHP echo urlencode($videodata[1]); ?>&raw=<?PHP echo urlencode(cleanWAMP($videodata[6])); ?>" style="text-decoration:none;"><div style="float:left;"><img src="<?PHP echo $this->printPoster($videodata[3]); ?>" border="0" width="100" height="150"></div><div class="mobile_video_title"><?PHP echo $videodata[1]; ?><br>

			<div align="left"><div class="classification"><div class="cover"></div>
    		<div class="progress" style="width:<?PHP echo $movie_rating; ?>%;"></div>
    		<div class="mobile_rated">Rated: <?PHP echo formatRating($videodata[7]); ?></div>
    		<div class="mobile_plot"><?PHP echo $videodata[8]; ?></div>
    		</div></div></div></a></div>

			<?PHP
			if ($fp == true){
				if ($i == $settings_data['m_display'])
					break;
			}
		
			$i++;
		}
	}

	public function printGenres(){
		global $settings_data;
		$genres = arraySettings($settings_data["genres"]);

		foreach ($genres as $genre)
			echo '<a href="./?g='.$genre.'">'.$genre.'</a>';
	}

	public function printMGenres($category){
		global $settings_data;
		$genres = arraySettings($settings_data["genres"]);

		foreach ($genres as $genre) {
			if ($category == $genre)
				echo '<option value="'.$genre.'" selected>'.$genre.'</option>';
			else
				echo '<option value="'.$genre.'">'.$genre.'</option>';
		}
	}
	
	public function desktopSearch () {
		?>
		<form action="./?search" method="post">
		<input name="sname" type="text" style="width:250px;" value="<?PHP if (isset($_POST['sname'])){ echo $_POST['sname']; } ?>" /> 
		<input name="" type="submit" value="search" />
		</form>
		<?PHP
	}
	
	public function mobileSearch () {
		if (isset($_GET['search'])) {
			$searchContent = "";
			if (isset($_POST['sname']))
				$searchContent = $_POST['sname']; ?>
			<div align="center" style="padding-bottom:10px;">
			<form action="mobile.php?search" method="post">
			<input name="sname" type="text" style="width:190px;font-size:16px;" value="<?PHP echo $searchContent; ?>" />
			<input name="" type="submit" value="search" />
			</form></div>
			<?PHP
		} else if (isset($_GET['browse'])) { ?>
			<div align="center" style="margin-bottom:20px;"><form action="mobile.php?browse" method="post">
			<select name="category" style="font-size:16px;">
			<?PHP echo $this->printMGenres($_POST['category']); ?>
			</select>
			<input name="" type="submit" value="go" /></form></div>
			<?PHP
		}
	}
	
	public function episodeLists() {
		global $garbage,$settings_data;
		
		if (!file_exists($_GET['raw']))
			return; //error
		
		$files = sortSeasonsList($_GET['raw']);
		
		$episodes='';
		$episodeList = array();
		foreach ($files as $folder){
			$path = $_GET['raw'].'/'.$folder;
			if (is_dir($path) == true){
				if ($handle = opendir($path)) {
					$episodes.='<h3>'.$folder.'</h3>';
					//put episodes in array, filter garbage, sort array
					while (false !== ($entry = readdir($handle))) {
						if (in_array($entry, $garbage))
							continue;

						$episodeList[] = $entry;
					}
					$episodeFiles = sortEpisodesList($episodeList);
					foreach ($episodeFiles as $episodeFile){
						$episodes.= '<a href="play.php?video='.urlencode($_GET['raw']).'/'.urlencode($folder).'/'.urlencode($episodeFile).'" onClick="return playvideo(\'play.php?video='.urlencode($_GET['raw']).'/'.urlencode($folder).'/'.urlencode($episodeFile).'\')">'.clean_title($episodeFile).'</a><br>';
					}
					unset($episodeList);
				}
				closedir($handle);
			} else //outside files. Filter garbage, sort array, print after loop
				$extras[] = str_replace($_GET['raw'].'/','',$path);
		}
		
		if (!empty($extras)){
			$extraFiles = sortEpisodesList($extras);
			foreach ($extraFiles as $extraFile){
				$episodes.= '<p><a href="play.php?video='.urlencode($_GET['raw']).'/'.$extraFile.'" onClick="return playvideo(\'play.php?video='.urlencode($_GET['raw']).'/'.$extraFile.'\')">'.clean_title($extraFile).'</a></p>';
			}
		}
		return $episodes;
	}

	public function mobileEpisodeLists(){
		global $garbage;
		
		if (!file_exists($_GET['raw']))
			return; //error
		
		$files = sortSeasonsList($_GET['raw']);
		
		$episodes='';
		$episodeList = array();
		foreach ($files as $folder){
			$path = $_GET['raw'].'/'.$folder;
			if (is_dir($path) == true){
				if ($handle = opendir($path)) {
					$episodes.='<h3>'.$folder.'</h3>';
					//put episodes in array, filter garbage, sort array
					while (false !== ($entry = readdir($handle))) {
						if (in_array($entry, $garbage))
							continue;

						$episodeList[] = $entry;
					}
					$episodeFiles = sortEpisodesList($handle,$episodeList);
					foreach ($episodeFiles[0] as $episodeFile){
						$episodes.= '<a href="play.php?video='.urlencode($_GET['raw']).'/'.urlencode($folder).'/'.urlencode($episodeFile).'" onClick="return playvideo(\'play.php?video='.urlencode($_GET['raw']).'/'.urlencode($folder).'/'.urlencode($episodeFile).'\')">'.clean_title($episodeFile).'</a><br>';
					}
					unset($episodeList);
				}
				closedir($handle);
			} else //outside files. Filter garbage, sort array, print after loop
				$extras[] = str_replace($_GET['raw'].'/','',$path);
		}
		
		if (!empty($extras)){
			$extraFiles = sortEpisodesList($handle,$extras);
			foreach ($extraFiles[0] as $extraFile){
				$episodes.= '<p><a href="play.php?video='.urlencode($_GET['raw']).'/'.$extraFile.'" onClick="return playvideo(\'play.php?video='.urlencode($_GET['raw']).'/'.$extraFile.'\')">'.clean_title($extraFile).'</a></p>';
			}
		}
		return $episodes;
	}
	
	public function mobileVideos () {
		if (isset($_GET['browse']))
			$this->printMobileVideos(false, "", $_POST['category']);
		else if (isset($_GET['search']) && isset($_POST['sname']))
			$this->printMobileVideos(false, $_POST['sname']);
		else
			$this->printMobileVideos(true);
	}
	
	public function indexVideos () {
		global $settings_data;
		newFileCheck();
		if (isset($_GET['search']))
			$this->printVideos(false, $_GET['p'], "", $_GET['search']);
		else if (isset($_GET['g']))
			$this->printVideos(false, $_GET['p'], $_GET['g']);
		else
			$this->printVideos(true);
	}
	
	public function footer($checkMobile = false) {
		global $lang_template_softwareBy,$lang_template_personalUse,$lang_mobile_mobile;
		if ($checkMobile == true) {
			if (checkMobile()==true) { ?>
    			<p><a href="mobile.php?mobile" style="color:white;font-size:24px;"><?PHP echo $lang_mobile_mobile; ?></a></p>
    		<?PHP } }
		echo '<div style="color:white;font-size:10px;padding:10px 0px 45px;">
		'.$lang_template_softwareBy.' <a href="http://newagesoldier.com/" style="color:white;font-weight:bold;">New Age Soldier</a>.</div>';
	}
}
?>