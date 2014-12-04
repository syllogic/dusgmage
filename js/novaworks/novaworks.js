jQuery(function() {
var ver = getInternetExplorerVersion();
	// Top dropdown
	jQuery(".top-dropdown").mouseenter(function() {
			jQuery(this).click();
	});
	jQuery(".top-dropdown").click(function() {
		jQuery(this).addClass('hover');
		jQuery(this).find("ul").stop(true, true).delay(300).fadeIn(300, "easeOutCubic");
	}).mouseleave(function() {
		jQuery(this).find("ul").stop(true, true).delay(300).fadeOut(300, "easeInCubic");
	});
	// Shopping cart dropdown		
	jQuery(".minicart").hover(function() {
			jQuery(this).addClass('hover');
			jQuery(".minicart .block-content").stop(true, true).delay(300).fadeIn(500, "easeOutCubic");
		}, function() {
			jQuery(".minicart .block-content").stop(true, true).delay(300).fadeOut(500, "easeInCubic");
	});
	
	//Top menu
	if(jQuery('#default-menu #nav').length) {
	  jQuery("#default-menu #nav").superfish({
		  autoArrows: false,
		  dropShadows: false
	   });
	  jQuery('#superfish-menu ul#nav li li a').prepend('<span class="menu-arr"></span >');
	}	
	if(jQuery('#wide-menu #nav').length) {
	  jQuery ('#wide-menu #nav li.level-top.parent').hover (function(){
		      jQuery(this).addClass("hover").find('ul:first').stop(true, true).delay(300).fadeIn(300, "easeOutCubic");
		  }, function (){
			   jQuery(this).removeClass("hover").find('ul:first').stop(true, true).delay(300).fadeOut(300, "easeInCubic");
			  })
	}
	 if ( ver == 9.0 || ver == 8.0 ) { 
       jQuery(".item").hover(function() {
		jQuery(this).find(".descriptions-hidden").show();
		//$(this).find("ul").slideToggle(); 
	}, function() {
		jQuery(this).find(".descriptions-hidden").hide();
	});	
	}

	// Sort by dropdown
	jQuery(".sorter .sort-by").mouseenter(function() {
			jQuery(this).click();
	});
	jQuery(".sorter .sort-by").click(function() {
		jQuery(this).addClass('hover');
		jQuery(this).find("ul").stop(true, true).delay(300).fadeIn(500, "easeOutCubic");
	}).mouseleave(function() {
		jQuery(this).find("ul").stop(true, true).delay(300).fadeOut(500, "easeInCubic");
	});	
	// Limiter dropdown
	jQuery(".sorter .limiter").mouseenter(function() {
			jQuery(this).click();
	});
	jQuery(".sorter .limiter").click(function() {
		jQuery(this).addClass('hover');
		jQuery(this).find("ul").stop(true, true).delay(300).fadeIn(500, "easeOutCubic");
	}).mouseleave(function() {
		jQuery(this).find("ul").stop(true, true).delay(300).fadeOut(500, "easeInCubic");
	});
	
		
	jQuery.each(jQuery('#accordion a.accordion-toggle'), function(i, link){
	    
	        jQuery('#collapse' + 1).collapse({
	            toggle : true,
	            parent : '#accordion'
	        });
	jQuery(link).on('click', 
	    function(){
	        jQuery('#collapse' + 1).collapse('toggle');
	    }
	)
	});
	jQuery('.collapsible').each(function(index) {
			jQuery(this).prepend('<span class="mobile-coll-arrow">+</span>');
			if (jQuery(this).hasClass('active'))
			{
				jQuery(this).children('.block-content').css('display', 'block');
			}
			else
			{
				jQuery(this).children('.block-content').css('display', 'none');
			}			
	});
	jQuery('.collapsible .mobile-coll-arrow').click(function() {
			
			var parent = jQuery(this).parent();
			if (parent.hasClass('active'))
			{
				jQuery(this).siblings('.block-content').stop(true).slideUp(300, "easeOutCubic");
				parent.removeClass('active');
				jQuery(this).html('+');
			}
			else
			{
				jQuery(this).siblings('.block-content').stop(true).slideDown(300, "easeOutCubic");
				parent.addClass('active');
				jQuery(this).html('-');
			}
			
		});
	
	
	jQuery('.ajaxcart_colorbox').live('mouseenter', function(){
		jQuery(this).colorbox({
			iframe:true,
			opacity:	0.8,
			width:"402",
			height:"200"
		});
	});	
   jQuery('.quickview_small').live('mouseenter', function(){
   	jQuery(this).colorbox({iframe:true, width:"780px", height:"480px", opacity:0.8});
   	});	
	/* Add (+/-) Button Number Incrementers */
	jQuery(".button-qty").on("click", function() {
	  var $button = jQuery(this);
	  var oldValue = $button.parent().find("input").val();
	
	  if ($button.text() == "+") {
		  var newVal = parseFloat(oldValue) + 1;
		} else {
	   
	    if (oldValue > 1) {
	      var newVal = parseFloat(oldValue) - 1;
	    } else {
	      newVal = 1;
	    }
	  }
	
	  $button.parent().find("input").val(newVal);
	
	});

});
function setAjaxData(data,iframe){
		if(data.status == 'ERROR'){
			alert(data.message);
		}else{
			if(jQuery('.minicart')){
	            jQuery('.minicart').replaceWith(data.sidebar);
	        }
					// Shopping cart dropdown		
					jQuery(".minicart").hover(function() {
							jQuery(this).addClass('hover');
							jQuery(".minicart .block-content").stop(true, true).delay(300).fadeIn(500, "easeOutCubic");
						}, function() {
							jQuery(".minicart .block-content").stop(true, true).delay(300).fadeOut(500, "easeInCubic");
					});
			jQuery.colorbox.close();
			
						 					      	        
		}
}
function ajaxcart(url,id) {
 url += 'isAjax/1';
 url = url.replace("checkout/cart","ajax/index");
jQuery(".button-ajax-cart-id-"+id).html('<span class="act-icon"><i class="icon-spin4 animate-spin"></i></span>'); 
 try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {
                        if(data.status == 'SUCCESS'){    
                             jQuery('#notification').html('<div class="alert-bg"><div class="alert-box" style="display: none;"><h6><i class="icon-ok-circled2-1"></i></h6><p>' + data.message + '</p></div></div>');
							 jQuery('.alert-box').fadeIn('slow').delay(2000).fadeOut('slow', function() {
							 	jQuery('.alert-bg').remove();
							 }); 
							 
                        }else{
                            bootbox.alert('<p class="error-msg">' + data.message + '</p>');
                        }   
                        jQuery(".button-ajax-cart-id-"+id).html('<span class="act-icon"><i class="icon-ok"></i></span>');

                        setAjaxData(data,false);
                            
                    }
                });
            } catch (e) {
 }
}
function deletecart(url){
		url = url.replace("checkout/cart","ajax/index");
 		try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {  
                        setAjaxData(data,false);   
                    }
                });
            } catch (e) {
 		}
}
function setAjaxCompareData(data,iframe){
		if(data.status == 'ERROR'){
			alert(data.message);
		}else{
			if(jQuery('.block-compare')){
	            jQuery('.block-compare').replaceWith(data.sidebar);
	        }
			if(jQuery('.ajax-compare')){
	            jQuery('.ajax-compare').replaceWith(data.dropdown);
	        }
						 					      	        
		}
}
function ajaxcompare(url,id) {
 url = url.replace("catalog/product_compare/add","ajax/index/compare");
jQuery(".button-ajax-compare-id-"+id).html('<i class="icon-spin4 animate-spin"></i>'); 
 try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {
                        if(data.status == 'SUCCESS'){    
                             jQuery('#notification').html('<div class="alert-bg"><div class="alert-box" style="display: none;"><h6><i class="icon-ok-circled2-1"></i></h6><p>' + data.message + '</p></div></div>');
							 jQuery('.alert-box').fadeIn('slow').delay(2000).fadeOut('slow', function() {
							 	jQuery('.alert-bg').remove();
							 }); 
                        }else{
                            bootbox.alert('<p class="error-msg">' + data.message + '</p>');
                        }   
                        setAjaxCompareData(data,false);
                        jQuery(".button-ajax-compare-id-"+id).html('<i class="icon-ok added"></i>'); 
                            
                    }
                });
            } catch (e) {
 }
}
function removeCompare(url){
	url = url.replace("catalog/product_compare/remove","ajax/index/removecompare"); 
 		try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {  
                        setAjaxCompareData(data,false);   
                    }
                });
            } catch (e) {
 		}
}
function clearCompare(url){
	url = url.replace("catalog/product_compare/clear","ajax/index/clearcompare"); 
 		try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {  
                        setAjaxCompareData(data,false); 
                    }
                });
            } catch (e) {
 		}
}
function ajaxwishlist(url,id) {
 url = url.replace("wishlist/index/add","ajax/index/addwishlist");
jQuery(".button-ajax-wishlist-id-"+id).html('<i class="icon-spin4 animate-spin"></i>'); 
 try {
                jQuery.ajax( {
                    url : url,
                    dataType : 'json',
                    success : function(data) {
                        if(data.status == 'SUCCESS'){  
                             jQuery('#notification').html('<div class="alert-bg"><div class="alert-box" style="display: none;"><h6><i class="icon-ok-circled2-1"></i></h6><p>' + data.message + '</p></div></div>');
							 jQuery('.alert-box').fadeIn('slow').delay(2000).fadeOut('slow', function() {
							 	jQuery('.alert-bg').remove();
							 }); 
							if(jQuery('.count-wishlist-box')){
	            				jQuery('#count-wishlist-'+id).replaceWith(data.sidebar);
	            				jQuery('.wishlist-link').replaceWith(data.wishlist_header);
	       					 }                        	  
                        }else{
                            bootbox.alert('<p class="error-msg">' + data.message + '</p>');
                        }   
                        jQuery(".button-ajax-wishlist-id-"+id).html('<i class="icon-ok added"></i>'); 
                            
                    }
                });
            } catch (e) {
 }
}
function show_bpopup(){
jQuery('#popup').bPopup();
}

function getInternetExplorerVersion()
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
{
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}