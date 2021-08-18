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
        return reset(explode('/', str_replace(WP_PLUGIN_DIR . '/', '', __DIR__)));
    }

    /**
     * Get the current plugin directory
     */
    public static function plugin_dir()
    {
        return WP_PLUGIN_DIR . '/' . self::plugin_name();
    }

    /**
     * Get the current plugin url
     */
    public static function plugin_url()
    {
        return plugins_url( self::plugin_name() );
    }

}