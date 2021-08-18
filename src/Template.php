<?php

namespace Kerkness\KoreWP;

use Kerkness\KoreWP\KoreWP;

/**
 * Simple view renderer for cleaner admin templates.
 */
class Template {

    public static $instance;

    public static function factory($template)
    {
        return new Template($template);
    }

    public static function render( $template, $params = [] )
    {
        return self::factory($template)->render_view($params);
    }

    /**
     * Template being rendered.
     */
    protected $template = null;

    /**
     * Initialize a new view context.
     */
    public function __construct($template) {
        $this->set_template($template);
    }

    /**
     * Add extension .php to template name if not included
     */
    public function template_file_name($template)
    {
        return  preg_replace('/'. preg_quote('.php', '/') . '$/', '', $template) . '.php';
    }

    /**
     * Get the default template directory
     */
    public function template_directory() {
        return KoreWP::plugin_dir() . '/src/templates';
    }

    /**
     * Build a bath with base and template name
     */
    public function path( $base, $template ) {
        return $base .'/'. $this->template_file_name($template);
    }

    /**
     * Set the template validating existence of file
     * - first check active theme directory
     * - check default path
     * - check relative path
     * - set 404 if
     */
    public function set_template($template) {


        // Determine if the template file exists in user's theme directory
        if ( is_file($this->path(get_stylesheet_directory(), $template)) ) {
            $this->template = $this->path(get_stylesheet_directory(), $template);
            return;
        }

        // Determine if template in plugin template directory
        if(is_file($this->path($this->template_directory(), $template))) {
            $this->template = $this->path($this->template_directory(), $template);
            return;
        }

        // Assume relative path
        if (is_file($this->template_file_name($template))) {
            $this->template = $this->template_file_name($template);
            return;
        }


        $this->template = $this->path($this->template_directory(), '404');;

    }

    /**
     * Safely escape/encode the provided data.
     */
    // public function h($data) {
    //     return htmlspecialchars((string) $data, ENT_QUOTES, 'UTF-8');
    // }

    /**
     * Render the template, returning it's content.
     * @param array $data Data made available to the view.
     * @return string The rendered template.
     */
    public function render_view(Array $data) {
        extract($data);
        ob_start();
        include($this->template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
