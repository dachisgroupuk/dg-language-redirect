<?php
class LanguageRedirectAdmin extends LanguageRedirectCore
{
    function init()
    {
        parent::init();

        // There no options at the moment, but we could add them later.
        // add_action( 'admin_menu', array( __CLASS__, 'add_admin_pages' ) );
    }


    /**
     * Add the administration menu for the most viewed plugin
     *
     * @param void
     * @return void
     */
    function add_admin_pages()
    {
        add_submenu_page( 'options-general.php', __('Language Redirect'), __('Language Redirect'), 'manage_options', 'language_redirect', array( __CLASS__, 'index_page' ) );
    }

    /**
     * The most viewed index page
     *
     * @param void
     * @return void
     */
    function index_page()
    {
        $redirectOptions = get_option( 'dg-redirect-options' );

        include( LanguageRedirectAdmin::get_plugin_path() . 'views/admin-index.php' );

        $languages		    = self::get_available_languages( );
        $language_titles    = mlp_get_available_languages_titles( TRUE );
    }
}
