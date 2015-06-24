<?PHP
// ADMINISTRATION AREA
$lang_admin_faq = array(
'Incorrect Box Art by Year' => 'If you have a movie file that shows an older or newer box art, you need to place the year in the name of the file. For example, the movie "The Day the Earth Stood Still" has been published in 1951. Then was remade with the same name in 2008. The software will pick whichever one is listed first in IMDb. If the file name is "The Day the Earth Stood Still.avi" and this is the 1951 release, then we rename the file to "The Day the Earth Stood Still 1951.avi", remove the data file in the data folder, and re-cache the data file.',
'How To Create a TV Show' => 'TV shows are detected by folders. Create a folder by the name of the TV show, then inside of this folder create another folder called "Season #", and place the episode video files inside that season numbered folders.',
'Detecting New Movies and TV Shows' => 'All new files and folders are detected automatically on the main index page, and in the data section of the administration page.',
'Slow Main Index Page' => 'It may be slow at first, in order to save new photos and cache IMDb data. But after, it will speed up.',
'The Mobile Page Doesn\'t Display All Movies and TV Shows' => 'The mobile version is currently only available for iPhone and iPod devices. These devices only play .mov and .mp4 videos, so it will only display files that are compatible with these devices. When visiting the website with an iPad, it will display all the movies, but when pressing to play, it will switch over from the VLC plugin, to HTML5 video tag code.',
'Additional Help' => 'Post in the New Age Soldier forums! <a href="http://newagesoldier.com">http://newagesoldier.com</a>'
);
$lang_admin_incPass = 'Incorrect Password.';
$lang_admin_admLogin = 'Admin Login';
$lang_admin_pass = 'Password';
$lang_admin_cacheData = 'Cache Data';
$lang_admin_checkFiles = 'CHECK FOR NEW VIDEO FILES';
$lang_admin_softHelp = 'Software Help';
$lang_admin_generalSettings = 'General Settings';
$lang_admin_title = 'Title';
$lang_admin_fpDisplay = 'front page displayed videos';
$lang_admin_vidsPerPage = 'videos per page';
$lang_admin_vidsPerPageMobile = 'videos per page for mobile';
$lang_admin_language = 'Language';
$lang_admin_movieOrder = 'movie order';
$lang_admin_desc = 'Descending';
$lang_admin_asc = 'Ascending';
$lang_admin_seasonOrder = 'TV show season order';
$lang_admin_episodeOrder = 'TV show episode order';
$lang_admin_playerType = 'Player Type';
$lang_admin_debugMode = 'Debug Mode';
$lang_admin_fileDirectories = 'Movie/TV-Show Directories';
$lang_admin_mobileBrowsers = 'Mobile Browsers';
$lang_admin_videoExt = 'Video Extensions';
$lang_admin_genres = 'Genres';
$lang_admin_currentVer = 'Current Version';
$lang_admin_IP = 'Server IP';
$lang_admin_support = 'Support';
$lang_admin_considerDonating = 'If you enjoy my software and look forward to the next version, please consider donating.';
$lang_admin_donationReason = 'Donations go towards my server\'s maintenance, domain yearly registration and hardware for future projects.';
$lang_admin_onePerLine = 'one per line';
$lang_admin_author = "Author";
$lang_admin_garbageFilter = "Garbage Filter";
$lang_admin_infoPhotos = "Info Page Photos";
$lang_admin_imdb = "iMDB Scrape Information";
$lang_admin_googleDomain = "Google Domain";

$lang_folder_empty = "The videos folder is empty.";

$lang_admin_data = 'Data';
$lang_admin_settings = 'Settings';
$lang_admin_help = 'Help';

$lang_function_curlDisabled = 'ERROR: cURL is disabled!';

$lang_search_noneFound = 'No videos to display for this search criteria.';
$lang_search_searchingFor = 'Searching for';
$lang_search_category_noneFound = 'No videos to display for this category.';

$lang_mobile_pickVideo = 'Pick a Movie or TV Show Category';
$lang_mobile_desktop = 'Desktop Version';
$lang_mobile_mobile = 'Mobile Version';

$lang_template_personalUse = 'For personal use ONLY!';
$lang_template_softwareBy = 'Software by';
$lang_template_playBtn = 'PLAY';

$lang_template_admin = 'Administration';
$lang_template_library = 'Video Library';

$lang_template_genres = 'Genres';
$lang_template_newVids = 'New Videos';

$lang_video_cantPlay = 'Video file cannot be played.';
$lang_video_vlcRequired = 'VLC Media Plugin is required for streaming videos.';
$lang_video_vlcDownload = 'Please download the VLC media player from here.';

$lang_check_cantLocate = 'ERROR: Could not locate any video files in the directories specified.';
$lang_check_notWritable = 'ERROR: Can\'t create cache file. Is data folder writable?';
$lang_check_done = 'Done.';
$lang_check_debugCreateFile = 'CREATING NEW DATA FILE';
$lang_check_debugFileExists = 'DATA FILE EXISTS';
$lang_check_debugContinue = 'REFRESH TO CONTINUE';

$lang_title_play = 'Stream Video';
$lang_title_admin = 'Administration Controls';

$lang_info_cast = "Cast";
$lang_info_director = "Director";
$lang_info_writer = "Writer";
$lang_info_creators = "Creators";
$lang_info_genre = "Genre";
$lang_info_details = "Movie details";
$lang_info_release = "Release Date";
$lang_info_oscars = "Oscars";
$lang_info_random = "Random Tagline";

$lang_loading_text = "Getting IMDb Information.";
$lang_loading_wait = "Please Wait ..."
?>