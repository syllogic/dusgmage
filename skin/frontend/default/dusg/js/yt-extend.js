(function($){
	$.fn.detectDevice = function(){
		
		var width = $(window).width();
		var scrollWidth = $.fn.getScrollbarWidth();
		
		
		if( width >= 1184 ){
			// console.log(">=1184");
			return 'wide';
		}else if( width >= 964 ){
			// console.log(">=964");
			return 'normal';
		}else if(  width >= 752 && width <= 963 ){
			// console.log(" width >= 752 && width <= 963");
			return 'tablet';			
		}else if( width >= 464 && width <= 751 ){
			// console.log("width >= 464 && width <= 751");
			return 'stablet';
		// }else if( width > 600 && width < 800 ){
			// return 'stablet';
		}else if(  width > 0 ){
			// console.log("mobi");
			return 'mobile';
		}
		
		// width = width + scrollWidth;
		// console.log(width);
		// console.log(scrollWidth);
		// if( width >= 1216 ){
			// // console.log(">=1184");
			// return 'wide';
		// }else if( width >= 996 ){
			// // console.log(">=964");
			// return 'normal';
		// }else if(  width >= 784 && width <= 995 ){
			// // console.log(" width >= 752 && width <= 963");
			// return 'tablet';			
		// }else if( width >= 496 && width <= 783 ){
			// // console.log("width >= 464 && width <= 751");
			// return 'stablet';
		// // }else if( width > 600 && width < 800 ){
			// // return 'stablet';
		// }else if(  width > 0 ){
			// // console.log("mobi");
			// return 'mobile';
		// }
		
		// console.log(width);
		// if( width >= 1200 ){
			// // console.log('wide');
			// return 'wide';
		// }else if( width >= 980 ){
			// // console.log('normal');
			// return 'normal';
		// }else if(  width >= 768 && width <= 979 ){
			// // console.log('tablet');
			// return 'tablet';			
		// }else if( width >= 480 && width <= 767 ){
			// // console.log('stablet');
			// return 'stablet';
		// // }else if( width > 600 && width < 800 ){
			// // return 'stablet';
		// }else if(  width > 0 ){
			// return 'mobile';
		// }
		
		// if( width > 1200 ){
			// return 'wide';
		// }else if( width > 980 ){
			// return 'normal';	/* Normal(>980) && Tablet landscape (1024x768) */
		// }else if( width > 600 && width < 800 ){
			// return 'stablet';	/* Tablet portrait (768x1024) && Small tablet landscape (800x600) */
		// }else if(  width > 768 ){
			// return 'tablet';
		// }else if(  width > 0 ){
			// return 'mobile';
		// }		
	}	
	$.fn.getScrollbarWidth=	function(){
		document.body.style.overflow = 'hidden'; 
		var width = document.body.clientWidth;
		document.body.style.overflow = 'scroll'; 
		width -= document.body.clientWidth; 
		if(!width) width = document.body.offsetWidth - document.body.clientWidth;
		document.body.style.overflow = ''; 	
		return width;
	}
})(jQuery || jsmart)
$jsmart(document).ready(function($){
	var currentdevice = '';
	var bootstrap_elements = $('[class*="span"]');
	// Build data
	bootstrap_elements.each ( function(){
		var $this = $(this);
		// With attr data-*
		$this.data();
		// Make the source better view in inspector
    	$this.removeAttr ('data-default data-wide data-normal data-tablet data-stablet data-mobile');
		// For element no attr data-default
		if (!$this.data('default')) 
			$this.data('default', $this.attr('class'));
	
	});
	function updateBootstrapElementClass(newdevice){
		console.log(newdevice);
  		if (newdevice == currentdevice) return ;
		bootstrap_elements.each(function(){
			var $this = $(this);
			// Default
			if ( !$this.data('default') || (!$this.data(newdevice) && (!currentdevice || !$this.data(currentdevice))) )
				return;
			// Remove current
			if ($this.data(currentdevice)) $this.removeClass($this.data(currentdevice));
			else $this.removeClass ($this.data('default'));
			// Add new
			if ($this.data(newdevice)) $this.addClass ($this.data(newdevice));
			else $this.addClass ($this.data('default'));
		});
    	currentdevice = newdevice;
	};
	function getScrollbarWidth(){
		document.body.style.overflow = 'hidden'; 
		var width = document.body.clientWidth;
		document.body.style.overflow = 'scroll'; 
		width -= document.body.clientWidth; 
		if(!width) width = document.body.offsetWidth - document.body.clientWidth;
		document.body.style.overflow = ''; 	
		return width;
	}
	function detectDevice () {
		
		var width = $(window).width();
		var scrollWidth = getScrollbarWidth();
		
		
		if( width >= 1184 ){
			// console.log(">=1184");
			return 'wide';
		}else if( width >= 964 ){
			// console.log(">=964");
			return 'normal';
		}else if(  width >= 752 && width <= 963 ){
			// console.log(" width >= 752 && width <= 963");
			return 'tablet';			
		}else if( width >= 464 && width <= 751 ){
			// console.log("width >= 464 && width <= 751");
			return 'stablet';
		// }else if( width > 600 && width < 800 ){
			// return 'stablet';
		}else if(  width > 0 ){
			// console.log("mobi");
			return 'mobile';
		}
		
		// width = width + scrollWidth;
		// console.log(width);
		// console.log(scrollWidth);
		// if( width >= 1216 ){
			// // console.log(">=1184");
			// return 'wide';
		// }else if( width >= 996 ){
			// // console.log(">=964");
			// return 'normal';
		// }else if(  width >= 784 && width <= 995 ){
			// // console.log(" width >= 752 && width <= 963");
			// return 'tablet';			
		// }else if( width >= 496 && width <= 783 ){
			// // console.log("width >= 464 && width <= 751");
			// return 'stablet';
		// // }else if( width > 600 && width < 800 ){
			// // return 'stablet';
		// }else if(  width > 0 ){
			// // console.log("mobi");
			// return 'mobile';
		// }
		
		// console.log(width);
		// if( width >= 1200 ){
			// // console.log('wide');
			// return 'wide';
		// }else if( width >= 980 ){
			// // console.log('normal');
			// return 'normal';
		// }else if(  width >= 768 && width <= 979 ){
			// // console.log('tablet');
			// return 'tablet';			
		// }else if( width >= 480 && width <= 767 ){
			// // console.log('stablet');
			// return 'stablet';
		// // }else if( width > 600 && width < 800 ){
			// // return 'stablet';
		// }else if(  width > 0 ){
			// return 'mobile';
		// }
		
		// if( width > 1200 ){
			// return 'wide';
		// }else if( width > 980 ){
			// return 'normal';	/* Normal(>980) && Tablet landscape (1024x768) */
		// }else if( width > 600 && width < 800 ){
			// return 'stablet';	/* Tablet portrait (768x1024) && Small tablet landscape (800x600) */
		// }else if(  width > 768 ){
			// return 'tablet';
		// }else if(  width > 0 ){
			// return 'mobile';
		// }		
	}
  	updateBootstrapElementClass (detectDevice());
  
  	// With window resize 
  	$(window).resize(function(){ 
    	if ($.data(window, 'detect-device-time'))
      		clearTimeout($.data(window, 'detect-device-time'));
			
    	$.data(window, 'detect-device-time', 
      		setTimeout(function(){
        		updateBootstrapElementClass (detectDevice());
      		}, 200)
    	)
  	})
});	
