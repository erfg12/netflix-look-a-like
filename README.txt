Make your own Netflix style movie/tv-show streaming website!

Designed for NAS hardware. All PHP, no MySQL needed.

Created by NeWaGe
http://newagesoldier.com


All configuration changes can be made in the includes/settings.ini.php file.




CHANGELOG
============================================================================

Version 1.9
------------
Added movie_order, tvshow_season_order and tvshow_episode_order
Added build number to beta builds
Added movie rating and plot to data files
Added version to settings.ini.php
Added some classes to style sheet
Added info.php, m_info.php, Imdb.class.php, template.class.php, eng.php
Fixed only 1 movie/tvshow displaying
Fixed reported mobile warnings
Fixed video info now comes from raw tag instead of title
Fixed blank photo image names
Changed string data to centralized variables in functions.php
Changed lightbox to v2.6
Changed $data to $settings_data
Changed scrapMovieInfo to scrapeMovieInfo
Changed front page and mobile to display plot and rating
Changed manual posters can now be any image format (supports animated gifs)
Changed can choose player type
Changed settings.ini to settings.ini.php
Changed admin cookie to session
Changed scripts to includes
Moved images to img
Moved css,js and img folders to includes folder
Moved check.php,config.php,edit.php,functions.php,trailer.php,settings.ini files to scripts
Removed lots of redundant code
Removed directories.txt,mobile.txt,genres.txt,extensions.txt files and settings directory
Removed search.php,m_search.php,m_browse.php,m_tvshow.php,m_movie.php,movie.php,tvshow.php,config.php
Removed scrapMovieInfo2 and scrapMovieInfo3
Removed search cookie


Version 1.8
------------
Added custom file extensions
Added custom genres
Added css styling for trailer.php
Changed some error reporting messages
Changed centralized movie checking code to check.php
Changed javascript functions to common.js file
Removed redundant and old commented code
Moved .txt and .ini files to settings folder
Fixed IMDb posters
Fixed trailers.php
Fixed debug_mode


Version 1.7
------------
Fixed IMDb photos and posters
Changed some wording


Version 1.6
------------
Added debug mode in config.php
Moved imdb.php, faster_imdb.php and quick_imdb.php to functions.php
Fixed movie name encrypt/decrypt function
Fixed star rating being on top of genre menu dropdown
Removed imdb scrape code from search.php
Moved all functions from other files into functions.php
Removed old comments and spaced out lines
Fixed right arrow in search sometimes getting line break
Removed space above cover art when using search.php
Added no movies or tv shows notification to search.php
Removed include config.php from all files but admin.php
Added mobile browser detection customization
Fixed Play Trailer text centering
Added hover movie/show name with rank