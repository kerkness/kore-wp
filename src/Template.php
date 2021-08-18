<?php

namespace Kerkness\KoreWP;

use Kerkness\KoreWP\KoreWP;

/**
 * Simple view renderer for cleaner admin templates.
 */
class Template {

    public $kore;

    /**
     * Factory method creates instance of class
     */
    public static function factory($template = "", $file = __FILE__)
    {
        return new Template($kore, $template, $file);
    }

    /**
     * Static method for rendering template file
     */
    public static function render( $template, $params = [], $file = __FILE__ )
    {
        echo self::factory($template, $file)->render_view($params);
    }

    /**
     * Template being rendered.
     */
    protected $template = null;

    /**
     * Initialize a new view context.
     */
    public function __construct($template = "", $file) {

        $this->kore = KoreWP::factory($file);

        if ($template) {
            $this->set_template($template);
        }
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
        return $this->kore->plugin_dir() . '/templates';
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

        // Set the template location
        $this->template = $this->path($this->template_directory(), '404');;

    }

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
