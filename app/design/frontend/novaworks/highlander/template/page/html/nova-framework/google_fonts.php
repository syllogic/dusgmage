<?php
function google_fonts() {
$storeId = Mage::app()->getStore()->getStoreId();
$highlander_customfont = '';

$default = array(
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'helvetica'
				);

$googlefonts = array(
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/body_font', $storeId),
					Mage::getStoreConfig('themeoptions_theming/theme_fonts/heading_font', $storeId)
				);			
foreach($googlefonts as $googlefont) {
	
	if(!in_array($googlefont, $default)) {

			$highlander_customfont = str_replace(' ', '+', $googlefont). ':300,300italic,400,400italic,700,700italic,900,900italic|' . $highlander_customfont;
	}
}	
		echo '<link rel="stylesheet"  href="http://fonts.googleapis.com/css?family=' . substr_replace($highlander_customfont ,"",-1) . '" type="text/css" media="screen" />';

}
	
?>