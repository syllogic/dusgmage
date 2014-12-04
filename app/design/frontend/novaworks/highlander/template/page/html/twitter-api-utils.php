<?php
/**
 * Helper utilities for working with Twitter API data.
 * @author Tim Whitlock
 */




/**
 * Utility for rendering tweet text with clickable links
 * @param string plain text tweet
 * @param string optional target for links, defaults to _blank
 * @param bool optionally specify that passed text is already escaped HTML
 * @return string HTML source of tweet text
 */
function twitter_api_html( $src, $target = '_blank', $alreadyhtml = false ){
    // linkify URLs (restricting to 30 chars as per twitter.com)
    $src = preg_replace_callback('!(https?://)(\S+)!', 'twitter_api_html_linkify_callback', $src );
    if( '_blank' !== $target ){
        $src = str_replace( '"_blank"', '"'.$target.'"', $src );
    }
    // linkify @names
    $src = preg_replace('!@([a-z0-9_]{1,15})!i', '<a class="twitter-screen-name" href="https://twitter.com/\\1" target="'.$target.'">\\0</a>', $src );
    // linkify #hashtags
    $src = preg_replace('/(?<!&)#(\w+)/i', '<a class="twitter-hashtag" href="https://twitter.com/search?q=%23\\1&amp;src=hash" target="'.$target.'">\\0</a>', $src );
    return $src;
} 



/**
 * @internal
 */
function twitter_api_html_linkify_callback( array $r ){
    list( , $proto, $label ) = $r;
    $label = str_replace( '#', '&#35;', $label );
    $href = $proto.$label;
    if( isset($label{30}) ){
        $label = substr_replace( $label, '&hellip;', 30 );
    }
    return '<a href="'.$href.'" target="_blank">'.$label.'</a>';
}

/**
 * Clean Emoji icons out of tweet text.
 * Wordpress isn't escaping these strings properly for database insertion.
 */
function twitter_api_strip_emoji( $text ){
    // replace all control and private use unicode sequences
    return preg_replace_callback('/\p{C}/u', '_twitter_api_strip_emoji_replace', $text );
}



/**
 * @internal
 */
function _twitter_api_strip_emoji_replace( array $r ){
    // emoticons start at U+1F601 (\xF0\x9F\x98\x81)
    // @todo plain text mappings for common smileys 
    return '';
}



/**
 * Resolve shortened url fields via entities
 * @return string
 */ 
function twitter_api_expand_urls( $text, array $entities ){
    if( isset($entities['urls']) && is_array($entities['urls']) ){
        foreach( $entities['urls'] as $r ){
            $text = str_replace( $r['url'], $r['expanded_url'], $text );
        }
    }
    if( isset($entities['media']) && is_array($entities['media']) ){
        foreach( $entities['media'] as $r ){
            if( 0 === strpos($r['display_url'], 'pic.twitter.com' ) ) {
                $text = str_replace( $r['url'], 'https://'.$r['display_url'], $text );
            }
            else {
                $text = str_replace( $r['url'], $r['expanded_url'], $text );
            }
        }
    }
    return $text;
}        



