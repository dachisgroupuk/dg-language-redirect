<?php
class LanguageRedirectFrontend extends LanguageRedirectCore
{

    public $browserLang = null;

    function init()
    {
        parent::init();
        self::redirect();
    }


    /**
     * Get the browser languages
     *
     * @param void
     * @return array
     */
    static function getBrowserLanguages( )
    {
        $preferedLanguages = array();

        $allMatches = preg_match_all("#([^;,]+)(;[^,0-9]*([0-9\.]+)[^,]*)?#i", $_SERVER["HTTP_ACCEPT_LANGUAGE"], $matches, PREG_SET_ORDER);

        if ( $allMatches ):

            $priority = 1.0;
            foreach($matches as $match):
                if(!isset($match[3])) {
                    $pr = $priority;
                    $priority -= 0.001;
                } else {
                    $pr = floatval($match[3]);
                }
                $preferedLanguages[$match[1]] = $pr;
            endforeach;

            arsort($preferedLanguages, SORT_NUMERIC);

            return $preferedLanguages;
        endif;

        return $preferedLanguages;
    }

    /**
     * If the current page the blog homepage
     *
     * @param void
     * @return boolean true | false
     */
    static function isHome()
    {
        $homeUrl = rtrim( get_home_url(), '/');

        $currentUrl = 'http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $currentUrl = str_replace( '?noredirect', '', $currentUrl);
        $currentUrl = rtrim($currentUrl, '/');

        if ( (string) $currentUrl === (string) $homeUrl ){
            return true;
        }

        return false;
    }


    /**
     * Check and perform the redirect
     *
     * @param void
     * @return void
     */
    static function redirect()
    {
        global $current_site;

        $languages = self::getBrowserLanguages();

        if ( !empty( $current_site->cookie_domain ) ):
            $cookieDomain = '.' . $current_site->cookie_domain;
        else:
            $cookieDomain = '.' . $current_site->domain;
        endif;


        if( self::isHome() ){

            // Get current blog language;
            $wplang = get_option( 'WPLANG', true );

            if ( ! $wplang || $wplang == 1){
                $wplang = 'en_GB';
            }
            $currentLanguage = substr( $wplang, 0, 2 );

            // If we should stay on this page, set the cookie to avoid redirecting.
            if ( $_SERVER['QUERY_STRING'] == 'noredirect' ){

                setcookie( 'dg-lang', $currentLanguage, time()+60*60*24*30, '/', $cookieDomain);
                setcookie( 'blog', get_current_blog_id(), time()+60*60*24*30, '/', $cookieDomain);

                return false;

            }

            //Get the available languages
            $availableLanguages = self::get_available_languages();

            foreach( $availableLanguages AS $blogId => $detail ){

                $shortCode = substr( $detail['code'], 0, 2 );

                if ( (string)$shortCode == (string)$currentLanguage ){
                    continue;
                }

                $cookie = isset( $_COOKIE )? $_COOKIE : array() ;

                foreach( $languages AS $language => $value){

                    if ( (string)substr( $language, 0, 2 ) == (string)$shortCode ){

                        // Check the cookie to see if the blog ID differs, if it does don't redirect.
                        if ( isset( $cookie ) && isset( $cookie['blog'] ) && (int)$cookie['blog'] !== (int)$blogId ){
                            return false;
                        }

                        $url = get_blogaddress_by_id( $blogId );

                        if ( !function_exists('wp_redirect') ) :
                            include_once( ABSPATH . 'wp-includes/pluggable.php');
                        endif;

                        // Set the cookies
                        setcookie('dg-lang', $shortCode, time()+60*60*24*30, '/', $cookieDomain );
                        setcookie('blog', $blogId, time()+60*60*24*30, '/', $cookieDomain );

                        wp_redirect( $url );
                        exit;
                    }
                }
            }

        }

    }


}
