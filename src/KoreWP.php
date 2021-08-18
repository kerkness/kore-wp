<?php

namespace Kerkness\KoreWP;

use Kerkness\KoreWP\Template;

/**
 * Generic helper functions
 */
class KoreWP
{
    public $file;
    public $template;

    public static function factory($file)
    {
        $instance = new KoreWP($file);

        return $instance;
    }

    public function __construct($file) 
    {
        $this->file = $file;
        $this->template = new Template();
    }


    public static function reflection()
    {
    }

    /**
     * Get the current plugin name
     */
    public static function plugin_name()
    {
        $wp_plugin_dir = WP_PLUGIN_DIR;
        $dir = __DIR__;
        $local_path = str_replace($wp_plugin_dir . '/', '', $dir);
        $path_array = explode('/', $local_path);
        return reset($path_array);
    }

    /**
     * Get the current plugin directory
     */
    public static function plugin_dir()
    {
        $wp_plugin_dir = WP_PLUGIN_DIR;
        return $wp_plugin_dir . '/' . self::plugin_name();
    }

    /**
     * Get the current plugin url
     */
    public static function plugin_url()
    {
        return plugins_url( self::plugin_name() );
    }

}