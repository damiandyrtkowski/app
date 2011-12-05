<?php
/**
 * WikiaMobile Hooks handlers
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileHooks extends WikiaObject{
	public function onOutputPageParserOutput( &$out, $parserOutput ){
		//cleanup page output from unwanted stuff
		if ( get_class( $this->wg->User->getSkin() ) == 'SkinWikiaMobile' ) {
			$text = $parserOutput->getText();
			
			//remove inline styling
			$text = preg_replace('/style=(\'|")[^"\']*(\'|")/im', '', $text);
			
			//remove image sizes
			//$text = preg_replace('/(width|height)=(\'|")[^"\']*(\'|")/im', '', $text);
			
			$parserOutput->setText( $text );
		}
		
		return true;
	}
	
	public function onParserLimitReport( $parser, &$limitReport ){
		//strip out some unneeded content to lower the size of the output
		$limitReport = null;
		return true;
	}
	
	public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, $ret ){
		//WikiaMobile only
		if ( !$skin instanceof SkinWikiaMobile ) {
			return true;
		}

		//remove bold tag from section headings
		$text = str_replace( array( '<b>', '</b>' ), '', $text );

		//$link contains the section edit link, add it to the next line to put it back
		//ATM editing is not allowed in WikiaMobile
		$ret = "<h{$level} id=\"{$anchor}\"{$attribs}{$text}</span>";

		if ( $level == 2 ) {
			$ret .= '<span class="chevron"></span>';
		}
		
		$ret .= "</h{$level}>";
		return true;
	}
}