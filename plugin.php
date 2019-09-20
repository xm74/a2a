<?php

class plugina2a extends Plugin {

        private $enable;

        private function a2acode()
        {
                $ret  = '<!-- a2a BEGIN -->
		<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
		<div class="a2a-social" style="margin:20px 0px;">
			<style type="text/css">.a2a_specialcss '.$this->getValue('specialCSS').'</style>
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style a2a_specialcss">
				<a class="a2a_button_facebook"></a>
				<a class="a2a_button_twitter"></a>
				<a class="a2a_button_linkedin"></a>
				<a class="a2a_button_mastodon"></a>
				<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
			</div>
		</div>
		<script type="text/javascript">
			var a2a_config = a2a_config || {};
			a2a_config.icon_color = "#343a40";';
		if ( $this->getValue('enableMinifyURL') ) {
			$ret .= PHP_EOL.'			a2a_config.track_links = "googl";';
		};
		$ret .= PHP_EOL.'		</script>'.PHP_EOL;
		$ret .= '	<!-- a2a END -->'.PHP_EOL;
                
                return $ret;
        }

        public function init()
        {
                $this->dbFields = array(
                        'enablePages'=>false,
                        'enablePosts'=>true,
                        'enableMinifyURL'=>true,
			'specialCSS'=>''
                );
        }

        public function form()
        {
                global $L;

                $html  = '<div>';
                $html .= '<label for="a2aenablepages">'.$L->get('enable-addtoany-on-pages').'</label>';
                $html .= '<select id="a2aenablepages" name="enablePages">';
                $html .= '<option value="true" '.($this->getValue('enablePages')===true?'selected':'').'>'.$L->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enablePages')===false?'selected':'').'>'.$L->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label for="a2aenableposts">'.$L->get('enable-addtoany-on-posts').'</label>';
                $html .= '<select id="a2aenableposts" name="enablePosts">';
                $html .= '<option value="true" '.($this->getValue('enablePosts')===true?'selected':'').'>'.$L->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enablePosts')===false?'selected':'').'>'.$L->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label for="a2aminifyurl">'.$L->get('enable-google-url-shortener').'</label>';
                $html .= '<select id="a2aminifyurl" name="enableMinifyURL">';
                $html .= '<option value="true" '.($this->getValue('enableMinifyURL')===true?'selected':'').'>'.$L->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enableMinifyURL')===false?'selected':'').'>'.$L->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label for="a2aspecialcss">'.$L->get('a2a-special-css').'</label>';
                $html .= '<textarea id="a2aspecialcss" type="text" name="specialCSS">'.$this->getValue('specialCSS').'</textarea>';
                $html .= '<span class="tip">'.$L->get('complete-this-field-with-css-code').'</span>';
                $html .= '</div>';

                return $html;
        }

        public function pageEnd()
        {
                global $url, $page;
		
		if ($url->notFound()) {
			return false;
		}

                if( $url->whereAmI()=='page' ) {
                        if( ($this->getValue('enablePosts') && $page->published()) ||
                            ($this->getValue('enablePages') && $page->static()) ) {
                                return $this->a2acode();
                        }
                }
        }

}

