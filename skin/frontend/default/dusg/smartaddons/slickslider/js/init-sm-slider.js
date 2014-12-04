$jsmart(document).ready(function($) {
	function init(){ 

		$('#featured-slideshow').cycleYtc({
			fx:     'fade',
			timeout: 500,
			speed:  2000, 
			next:   '#next2123517701382723698', 
			prev:   '#prev2123517701382723698',
			pause: 0,
			theme:'theme1',
			linktarget:'_self',
			linkcaption:1,
			autoPlay:1,
			startingSlide:0		});		
		if($('#featured-slideshow').height()<=50){
			return false;	
		}

		$('#current_content_id').show();
					$('#cover_buttons').show();
				return true;
	}
	e = $(".ytc_background_theme1"),ehtml=e.html(),id='';
	
	function forceShow(){		e.children().empty().remove();e.html(ehtml);if(!init()){			setTimeout(	function(){	forceShow();	}	,		400);				}	}
	forceShow();
	// $jsmart(".ytc-content-slickslider").show();
  	$(window).resize(function(){
		if (id) clearTimeout(id);
		id = setTimeout(function(){//console.log($('body').width()+"-"+$('body').height());
			e.children().empty().remove();e.html(ehtml);init();
		}, 300);	
  	})	
init();
});
