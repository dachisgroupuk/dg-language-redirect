<?php

class LanguageRedirectCore
{
    var $wpdb;
    static $plugin_file, $plugin_path, $plugin_url;

    function __construct()
    {
        global $wpdb;
        $this->wpdb         = $wpdb;
        self::$plugin_path  = dirname( dirname( __FILE__ ) ) . '/';
        self::$plugin_url   = plugin_dir_url(dirname( __FILE__ ) );
    }

    function get_plugin_file()
    {
        return self::$plugin_file;
    }

    function get_plugin_path()
    {
        return self::$plugin_path;
    }

    function get_plugin_url()
    {
        return self::$plugin_url;
    }

    function init()
    {
        // Stub
    }


    function install()
    {
        // Stub
    }

    function uninstall()
    {
        // Stub
    }


    static function get_available_languages(  ) {

		// Get all registered blogs
		$languages = get_site_option( 'inpsyde_multilingual' );

		if ( ! is_array( $languages ) )
			return FALSE;

		$options = array( );

		// Loop through blogs
		foreach ( $languages as $language_blogid => $language_data ) {

			// no blogs with a link to other blogs
			if ( '-1' === $language_data[ 'lang' ] )
				break;

			$lang = $language_data[ 'lang' ];

			// We only need the first two letters of the language code, i.e. "de"
			if ( 2 !== strlen( $lang ) ) {
				$lang = substr( $lang, 0, 2 );
				if ( is_admin() ) {
					$lang = format_code_lang( $lang );
				}
			}
			$options[ $language_blogid ]['lang']    = $lang;
            $options[ $language_blogid ]['code']    = $language_data[ 'lang' ];
		}

		return $options;
	}

}
