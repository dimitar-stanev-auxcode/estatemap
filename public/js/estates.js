var $instance;

$(function(){
	$instance = $("a").imageLightbox();
});

$(document).ready(function(){
	$(document).click(function(){
		$instance.quitImageLightbox();
	})
});