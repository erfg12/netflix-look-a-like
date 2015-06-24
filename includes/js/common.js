function popitup(url) {
	newwindow=window.open(url,'name','height=900,width=700,scrollbars=1');
	if (window.focus) {newwindow.focus()}
	return false;
}

function popUpClosed() {
    window.location.reload();
}

function playvideo(url) {
	newwindow=window.open(url,'name','height=800,width=800,scrollbars=1');
	if (window.focus) {newwindow.focus()}
	return false;
}

function refreshAndClose() {
	window.opener.location.reload(true);
	window.close();
}

function showDiv(elem){
   if(elem.value == "vlc")
      document.getElementById('hidden_div').style.display = "block";
}

function chkMsg(cb) {
	if (cb.checked == false) {
		alert('WARNING: This will create blank data files and no corresponding posters for any videos added after this point.');
	}
} 

function checkFiles(){
	$.fancybox({
		'href' : 'includes/check.inc.php',
		'type' : 'iframe',
		'overlayShow' : true,
		'padding' : 5,
		'width' : 517,
		'height' : 'auto',
		'autoScale' : false,
        'autoDimensions' : false,
		'autoSize'         : false,
		'scrolling' : 'no',
		'height' : 512,
		afterLoad: function() {
      		parent.location.reload(true);
    	}
 	});
}

$(function() {
	cssdropdown.startchrome("chromemenu");
	$(".two").hide();
	$(".one").hover(function() {
		$('.two', this).fadeIn(200);
	}, function() {
		$('.two', this).fadeOut(200);
	});
});