<?php

namespace Kerkness\KoreWP;

/**
 * Generic helper functions
 */
class KoreWP
{
    /**
     * Get the current plugin name
     */
    public static function plugin_name()
    {
        $wp_plugin_dir = WP_PLUGIN_DIR;
        $dir = __DIR__;
        return reset(explode('/', str_replace($wp_plugin_dir . '/', '', $dir)));
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