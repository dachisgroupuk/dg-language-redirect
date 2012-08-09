<?php
class LanguageRedirectFrontend extends LanguageRedirectCore
{

    public $browserLang = null;

    function init()
    {
        parent::init();

        $prefered_languages = array();

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
                $prefered_languages[$match[1]] = $pr;
            endforeach;

            arsort($prefered_languages, SORT_NUMERIC);
            foreach($prefered_languages as $language => $priority):
                echo "This browser using language code: ".$language;
            endforeach;
        endif;
    }

}
