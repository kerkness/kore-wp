<?php

namespace Kerkness\KoreWP;


/**
 * Generic helper functions
 */
class KoreWP
{
    public $file;

    public static function factory( $file = __FILE__)
    {
        $instance = new KoreWP($file);
        return $instance;
    }

    public function __construct($file = __FILE__) 
    {
        $this->file = $file;
    }

    public function dir()
    {
        return dirname($this->file);
    }

    /**
     * Get the current plugin name
     */
    public function plugin_name()
    {
        $wp_plugin_dir = WP_PLUGIN_DIR;
        $dir = $this->dir();
        $local_path = str_replace($wp_plugin_dir . '/', '', $dir);
        $path_array = explode('/', $local_path);
        return reset($path_array);
    }

    /**
     * Get the current plugin directory
     */
    public function plugin_dir()
    {
        $wp_plugin_dir = WP_PLUGIN_DIR;
        return $wp_plugin_dir . '/' . $this->plugin_name();
    }

    /**
     * Get the current plugin url
     */
    public function plugin_url()
    {
        return plugins_url( $this->plugin_name() );
    }

}