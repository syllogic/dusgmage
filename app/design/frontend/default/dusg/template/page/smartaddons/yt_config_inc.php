<?php
/*------------------------------------------------------------------------
 * Copyright (C) 2009 - 2012 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
-------------------------------------------------------------------------*/
/*--- BEGIN: Theme param config ---*/
$_params = new ThemeParameter();
$_config = array(
	'showcpanel'				=>'',
	'show_notice'				=>'1',
	'body_font_size'			=>'14px',
	'body_font_family'			=>'Arial',
	'google_font'				=>'Archivo Narrow',
	'google_font_targets'		=>'
								.header-nav-container-home ul#nav li a, 
								#yt_tab_products .yt-tab-navi li a:hover, 
								#yt_tab_products .yt-tab-navi li.active, 
								li.selected a.subhead, 
								#review-form h4, 
								.col-left .block-subtitle, 
								.social h4,
								.newslet label, 
								.des-block, 
								.promotions p, 
								#yt_sidenav li a.subhead,  
								#yt_sidenav li li a,  
								#yt_sidenav li.selected li a,  
								#yt_sidenav li.active li a,  
								#yt_sidenav li li.active li a, 
								.header-nav-container ul#nav li a, 
								h1#logo a span , 
								ul.yt-tab-navi li a ,
								ul.yt-tab-navi li.active a, 
								.yt-product-detail .product-name, 
								.product-name a,
								.popup-box a.link-wishlist,
								.header-nav-container-home ul#nav li ul li a,
								.sm_megamenu_wrapper_vertical_menu ul.sm_megamenu_menu li div div.sm_megamenu_title a ,
								.sm_megamenu_lv1 .sm_megamenu_nodesc  .sm_megamenu_title ,
								.sm_megamenu_content h2.product-name a,
								.login-quick .more-actions a,
								.ytc_background_theme1	.ytc-content-slickslider .content-box .block-description .sub-content,
								.f-base',
	'color'						=>'yellow',
	'menu_styles'				=>'2',
	'body_background_color'		=>'#222',
	'body_background_image'		=>'1',
	'body_link_color'			=>'#EDAA00',
	'body_text_color'			=>'#686868',
	'header_background_color'	=>'#000',
	'header_background_image'	=>'',	
	'footer_background_color'	=>'#000',
	'footer_background_image'	=>'',
);
// if(Mage::getConfig()->getNode('modules/Smartaddons_Glasses')){
	// $_config	=	Mage::helper('glasses/data')->get($attributes);
// }
// enable Cpanel
$_params->set('showCpanel',$_config['showcpanel']);//image: Image; text: Text
// show custom box notice
$_params->set('shownotice',$_config['show_notice']);//image: Image; text: Text
// Logo type
$_params->set('logoType','Text');//image: Image; text: Text
// Logo text desx
$_params->set('logoText','Logo Text');
// Slogan text
$_params->set('sloganText','Slogan');
// Fontsize
$_params->set('fontsize',$_config['body_font_size']);//value from 1 to 6
// font family
$_params->set('font_name',$_config['body_font_family']);
// Google web font
$_params->set('googleWebFont',$_config['google_font']);
// Google WebFont Targets
$_params->set('googleWebFontTargets',$_config['google_font_targets']);
// Theme color
$_params->set('sitestyle',$_config['color']);//'black','blue','brown','cyan';
// Theme menu
if($_config['menu_styles'] ==1) {	$menu_style='mega';}	
if($_config['menu_styles'] ==2) {	$menu_style='css';}	
if($_config['menu_styles'] ==3) {	$menu_style='split';}	
$_params->set('menustyle',$menu_style);//css:CSS Menu; split: Split Menu; mega: Mega Menu
// Body background-color
$_params->set('bgcolor', $_config['body_background_color']);
// Body background-image
$_params->set('body-bgimage', 'pattern'.$_config['body_background_image']);
// Body link color
$_params->set('linkcolor', $_config['body_link_color']);
// Body text color
$_params->set('textcolor', $_config['body_text_color']);
// Header background-color
$_params->set('header-bgcolor', $_config['header_background_color']);
// Header background-image
$_params->set('header-bgimage', 'hpattern'.$_config['header_background_image']);
// Footer background-color
$_params->set('footer-bgcolor', $_config['footer_background_color']);
// Footer background-image
$_params->set('footer-bgimage', 'fpattern'.$_config['footer_background_image']);

// CategoryID array of displays 2nd image when hover - Catalog list
$_params->set('yt_arraydisplaylist', array('4','5','16','17','18'));
/*--- END: Theme param config ---*/

// Zend_Debug::dump($_params);die;
// Array param for cookie
$paramscookie =array(
				  'direction', 
				  'fontsize',
				  'font_name',
				  'sitestyle',
				  'bgcolor',
				  'body-bgimage',
				  'linkcolor',
				  'textcolor',
				  'header-bgimage',
				  'header-bgcolor',
				  'footer-bgcolor',
				  'footer-bgimage',
				  'menustyle',
				  'shownotice',
				  'googleWebFont'
);
// Global var
global $var_yttheme;
$var_yttheme = new YtTheme('sm_glasses_free', $_params, $paramscookie);
// Zend_Debug::dump($_params);die;
?>


