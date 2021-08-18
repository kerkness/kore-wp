<?php

namespace Kerkness\KoreWP;

use Kerkness\KoreWP\Template;
use ReflectionClass;

/**
 * Generic helper functions
 */
class KoreWP
{
    const FILE = __FILE__;
    public $template;

    public static function factory()
    {
        $instance = new KoreWP();
        return $instance;
    }

    public function __construct() 
    {
        $this->template = new Template();
    }

    public function dir()
    {
        return dirname($this::FILE);
    }

    /**
     * Get the current plugin name
     */
    public static function plugin_name()
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