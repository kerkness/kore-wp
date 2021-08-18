<?php

namespace Kerkness\KoreWP;

class KoreWP
{
    public static function plugin_name()
    {
        return reset(explode('/', str_replace(WP_PLUGIN_DIR . '/', '', __DIR__)));
    }

    public static function plugin_dir()
    {
        return WP_PLUGIN_DIR . '/' . self::plugin_name();
    }

    public static function plugin_url()
    {
        return plugins_url( self::plugin_name() );
    }

}