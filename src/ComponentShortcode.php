<?php

namespace Kerkness\KoreWP;

use Kerkness\KoreWP\KoreWP;

/**
 * Creates a short code which will enable the embedding of custom react components
 */
class ComponentShortcode
{
    public $kore;
    public $components = '';
    public $styles = '';
    public $localized = [];

    /**
     * Static class factory
     */
    public static function init($components, $styles, $localized = [], $file = __FILE__)
    {
        $instance = new ComponentShortcode($components, $styles, $localized, $file);
        $instance->actions();
    }

    /**
     * Create the class
     */
    public function __construct($components, $styles, $localized = [], $file = __FILE__)
    {
        $this->kore = KoreWP::factory($file);
        $this->components = $components;
        $this->styles = $styles;
        $this->localized = $localized;
    }

    public function actions()
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
            $this->kore->plugin_url() . $this->styles,
            [],
            time(),
            'all'
        );
    }

    public function wp_enqueue_scripts_js()
    {

        wp_enqueue_script(
            'kore-component',
            $this->kore->plugin_url() . $this->components,
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

        if ($this->localized) {
            wp_localize_script(
                'kore-component',
                'kore',
                $this->localized
            );    
        }

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