<?php

namespace Kerkness\KoreWP;

use Kerkness\KoreWP\KoreWP;

class ReactCode
{
    public $components = '';
    public $styles = '';

    public static function factory($components, $styles)
    {
        $instance = new ReactCode();
        $instance->init($components, $styles);
    }

    public function __construct($components, $styles)
    {
        $this->components = $components;
        $this->styles = $styles;
    }

    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'wp_enqueue_scripts_js']);
        add_action('wp_enqueue_scripts', [$this, 'wp_enqueue_scripts_styles']);
        add_shortcode('kore_react', [$this, 'react_short_code']);
    }

    public function wp_enqueue_scripts_styles()
    {

        // Register the CSS like this for a plugin:
        wp_enqueue_style(
            'kore-component',
            KoreWP::plugin_url() . $this->styles,
            [],
            time(),
            'all'
        );
    }

    public function wp_enqueue_scripts_js()
    {

        wp_enqueue_script(
            'kore-component',
            KoreWP::plugin_dir() . $this->components,
            [
                'wp-element',
                'wp-i18n',
                'wp-api-fetch',
                'wp-data',
                'wp-hooks',
                'wp-components',
                'wp-compose',
                'wp-keycodes',
            ],
            time(), // Change this to null for production
            true
        );

        wp_localize_script(
            'kore-component',
            'mfa',
            [
                'query' => $_GET,
                'current_user' => get_current_user(),
                'current_user_id' => get_current_user_id(),
                'has_api_key' => get_option('wp_hubspot_props_api_key') ? true : false,
            ]
        );

    }

    /**
     * Ensure to include a unique $props['id'] and the component name via $props["component"]
     */
    public function react_short_code($props)
    {
        $allProps = $props + [
            'react' => 1
        ];

        $attr = implode(' ', array_map(
            function ($v, $k) {
                return sprintf("%s='%s'", $k, $v);
            },
            $props,
            array_keys($props)
        ));


        return '<div ' . $attr . '></div>';
    }
}