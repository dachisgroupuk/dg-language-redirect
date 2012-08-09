<?php
class LanguageRedirectCore
{
    var $wpdb, $plugin_file, $plugin_path;

    function __construct()
    {
        global $wpdb;
        $this->wpdb         = $wpdb;
        $this->plugin_path  = dirname( dirname( __FILE__ ) ) . '/';
        $this->plugin_url   = plugin_dir_url(dirname( __FILE__ ) );

    }

    function get_plugin_file()
    {
        return $this->plugin_file;
    }

    function get_plugin_path()
    {
        return $this->plugin_path;
    }

    function get_plugin_url()
    {
        return $this->plugin_url;
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


}
