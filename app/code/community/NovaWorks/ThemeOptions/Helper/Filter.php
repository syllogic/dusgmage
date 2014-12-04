<?php
class NovaWorks_ThemeOptions_Helper_Filter extends Mage_Core_Helper_Abstract
{
	/**
	 * Regular expression patterns for identifying
	 * shortcodes and parameters
	 *
	 */
	const EXPR_SHOTRCODE_OPEN_TAG = '(\[{{shortcode}}[^\]]{0,}\])';
	const EXPR_SHOTRCODE_CLOSE_TAG = '(\[\/{{shortcode}}[^\]]{0,}\])';
//	const EXPR_SHORTCODE_PARAM = '[ ]{1}([^ ]{1,})=["]{0,1}(.*)["]{0,1}[ \]]{1}';
	const EXPR_SHORTCODE_PARAM = '[ ]{1}([^ ]{1,})=["\']{1}(.*)["\']{1}[ \]]{1}';

	/**
	 * Extract shortcodes from a string
	 *
	 * @param string $content
	 * @param string $tag
	 * @return false|array
	 */
	protected function _getShortcodesByTag($content, $tag)
	{
		$shortcodes = array();

		if (strpos($content, '[' . $tag) !== false) {
			$hasCloser = strpos($content, '[/' . $tag . ']') !== false;
			$open = str_replace('{{shortcode}}', $tag, self::EXPR_SHOTRCODE_OPEN_TAG);

			if ($hasCloser) {
				$close = str_replace('{{shortcode}}', $tag, self::EXPR_SHOTRCODE_CLOSE_TAG);

				if (preg_match_all('/' . $open . '(.*)' . $close . '/iU', $content, $matches)) {
					foreach($matches[0] as $matchId => $match) {
						$shortcodes[] = new Varien_Object(array(
							'html' => $match,
							'opening_tag' => $matches[1][$matchId],
							'inner_content' => $matches[2][$matchId],
							'closing_tag' => $matches[3][$matchId],
							'params' => new Varien_Object(NovaWorks_ThemeOptions_Helper_Filter::_parseShortcodeParameters($matches[1][$matchId])),
						));
					}
				}
			}
			else if (preg_match_all('/' . $open . '/iU', $content, $matches)) {
				foreach($matches[0] as $matchId => $match) {
					$shortcodes[] = new Varien_Object(array(
						'html' => $match,
						'opening_tag' => $matches[1][$matchId],
						'params' => new Varien_Object(NovaWorks_ThemeOptions_Helper_Filter::_parseShortcodeParameters($matches[1][$matchId])),
					));
				}
			}
		}

		if (count($shortcodes) > 0) {
			return $shortcodes;
		}
		
		return false;
	}

	/**
	 * Extract parameters from a shortcode opening tag
	 *
	 * @param string $openingTag
	 * @return array
	 */
	protected function _parseShortcodeParameters($openingTag)
	{
		$openingTag = preg_replace('/(\]){1}$/', ' ]', trim($openingTag));
		$openingTag = str_replace(' ', '  ', $openingTag);
		
		$parameters = array();

		if (preg_match_all('/' . self::EXPR_SHORTCODE_PARAM . '/iU', $openingTag, $matches)) {
			foreach($matches[1] as $matchId => $key) {
				$parameters[trim($key)] = trim($matches[2][$matchId], '"\' ');
			}
		}
			
		return $parameters;
	}
	
	/**
	 * Applies a set of filters to the given string
	 *
	 * @param string $content
	 * @param array $params
	 * @return string
	 */
	public function applyFilters($content, array $params = array())
	{
		if (isset($params['object'])) {
			$content = trim(preg_replace('/(&nbsp;)$/', '', trim($content)));
			
			$contentObj = new Varien_Object(array('content' => $content));

			Mage::dispatchEvent('magento_string_filter_before', array('content' => $contentObj, 'object' => $params['object'], 'params' => $params, 'helper' => $this));
			//print_r($this);
			$content = $contentObj->getContent();

			NovaWorks_ThemeOptions_Helper_Filter::_applyShortcodes($content, $params);
			
			$contentObj = new Varien_Object(array('content' => $content));
					
			Mage::dispatchEvent('magento_string_filter_after', array('content' => $contentObj, 'object' => $params['object'], 'params' => $params, 'helper' => $this));
			
			$content = $contentObj->getContent();
		}
		return $content;
	}
	
	/**
	 * Add paragraph tags to the content
	 * Taken from the WordPress core
	 * Long live open source!
	 *
	 * @param string &$content
	 */
	protected function _addParagraphsToString(&$content)
	{
		$pee = $content;

		$br = true;
		$pre_tags = array();
	
		if ( trim($pee) === '' )
			return '';
	
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
	
		if ( strpos($pee, '<pre') !== false ) {
			$pee_parts = explode( '</pre>', $pee );
			$last_pee = array_pop($pee_parts);
			$pee = '';
			$i = 0;
	
			foreach ( $pee_parts as $pee_part ) {
				$start = strpos($pee_part, '<pre');
	
				// Malformed html?
				if ( $start === false ) {
					$pee .= $pee_part;
					continue;
				}
	
				$name = "<pre wp-pre-tag-$i></pre>";
				$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';
	
				$pee .= substr( $pee_part, 0, $start ) . $name;
				$i++;
			}
	
			$pee .= $last_pee;
		}
	
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		$pee = '';
		foreach ( $pees as $tinkle )
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
		if ( $br ) {
			$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', array($this, '_preserveNewLines'), $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
	
		if ( !empty($pre_tags) )
			$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);
		
		foreach(array('script', 'style') as $tag) {
			$pee = str_replace(array('<p><' . $tag, '</' . $tag . '></p>'), array('<' . $tag, '</' . $tag . '>'), $pee);
		}
		
		$pee = str_replace(array('<p>[', ']</p>'), array('[', ']'), $pee);

		$content = $pee;
	}

	/**
	 * Preserve new lines
	 * Used as callback in _addParagraphsToString
	 *
	 * @param array $matches
	 * @return string
	 */
	public function _preserveNewLines($matches)
	{
		return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
	}

	/**
	 * Apply shortcodes to the content
	 *
	 * @param string &$content
	 * @param array $params = array
	 */
	protected function _applyShortcodes(&$content, $params = array())
	{
		NovaWorks_ThemeOptions_Helper_Filter::add_icon_shortcode($content, $params);
		
		$contentObj = new Varien_Object(array('content' => $content));	
		Mage::dispatchEvent('wordpress_shortcode_apply', array('content' => $contentObj, 'object' => $params['object'], 'params' => $params, 'helper' => $this));
		
		$content = $contentObj->getContent();
	}

	/**
	 * Apply the caption short code
	 *
	 * @param string &$content
	 * @param array $params = array
	 */
	protected function add_icon_shortcode(&$content, $params = array())
	{
		if (strpos($content, '[icon') === false) {
			return $this;
		}

		$shortcodes = NovaWorks_ThemeOptions_Helper_Filter::_getShortcodesByTag($content, 'icon');
			foreach($shortcodes as $shortcode) {
				 $params = $shortcode->getParams();
				 $html = '<i class="'.$params->getName().'"></i>';
				 $content = str_replace($shortcode->getHtml(),$html, $content);
			}
		
	}
		

	/**
	 * Generate a block tag for Magento to process
	 *
	 * @param string $type
	 * @param $blockparams = array()
	 * @param string $name = null
	 * @return string
	 */
	protected function _generateBlockTag($type, array $blockParams = array(), $name = null)
	{
		if (isset($blockParams['type'])) {
			unset($blockParams['type']);
		}
		
		if (!$name) {
			$name = 'wp_block_' . rand(1, 9999);
		}
		
		$blockParams['name'] 	= $name;
		$blockParams 				= array_merge(array('type' => $type), $blockParams);
		
		foreach($blockParams as $key => $value) {
			if ($value) {
				$blockParams[$key] = sprintf('%s="%s"', $key, $value);
			}
			else {
				unset($blockParams[$key]);
			}
		}	
		
		return sprintf('{{block %s}}', implode(' ', $blockParams));
	}
	
	/**
	 * Explodes a string into parts based on the given short tag
	 *
	 * @param string $shortcode
	 * @param string $content
	 * @param bool $splitTags = false
	 * @return array
	 */
	protected function _explode($shortcode, $content, $splitTags = false)
	{
		$pattern 	= $splitTags ? "/(\[" . $shortcode . "[^\]]*\])|(\[\/".$shortcode . "\])/" : "/(\[" . $shortcode . "[^\]]*\].*?\[\/".$shortcode . "\])/";
		$parts 		= preg_split($pattern, $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
		
		return NovaWorks_ThemeOptions_Helper_Filter::_sortExplodedString($parts, $shortcode);
	}

	/**
	 * Sorts and classifies a string exploded by self::_explode
	 *
	 * @param array $parts
	 * @param string $shortcode
	 * @return array
	 */
	protected function _sortExplodedString(array $parts, $shortcode)
	{
		foreach($parts as $key => $part) {
			if (strpos($part, "[$shortcode") !== false) {
				$parts[$key] = array('is_opening_tag' => true, 'is_closing_tag' => false,  'content' => $part);
			}
			else if (strpos($part, "[/$shortcode]")  !== false) {
				$parts[$key] = array('is_opening_tag' => false, 'is_closing_tag' => true,  'content' => $part);
			}
			else {
				$parts[$key] = array('is_opening_tag' => false, 'is_closing_tag' => false, 'content' => $part);
			}
		}

		return $parts;
	}

	/**
	 * Returns a matched string from $buffer
	 *
	 * @param string $buffer
	 * @param string $field
	 * @return string
	 */
	protected function _getMatchedString($buffer, $field, $defaultValue = null)
	{
		return ($matchedValue = NovaWorks_ThemeOptions_Helper_Filter::_match("/".$field."=['\"]([^'\"]+)['\"]/", $buffer, 1)) ? $matchedValue : $defaultValue;
	}

	/**
	 * Wrapper for preg_match that adds extra functionality
	 *
	 * @param string $pattern
	 * @param string $value
	 * @param int $keyToReturn
	 * @return mixed
	 */
	public function _match($pattern, $value, $keyToReturn = -1)
	{
		$result = array();
		preg_match($pattern, $value, $result);
		
		if ($keyToReturn == -1) {
			return $result;
		}

		return isset($result[$keyToReturn]) ? $result[$keyToReturn] : null;
	}
}
