# kore-wp

Common classes and features for wordpress plugin development

## Kerkness\KoreWP\KoreWP ##

Some useful generic helper functions

```
// Get the current plugin name
KoreWP::plugin_name()
```

```
// Get the current plugin directory
KoreWP::plugin_dir()
```

```
// Get the current plugin url
KoreWP::plugin_url()
```

## Kerkness\KoreWP\Template ##

Renders PHP template files with options on where to keep your template files.

* Stick your php template in active Theme folder
* Stick your php template in `wp-content/plugins/my-plugin/templates`
* Provide a relative path to your template file

### Basic Usage ###

template-file.php
```
<h1>Hello World</h1>
```
```
Template::render('template-file');
```

### With Dynamic Properties ###

template-file.php
```
<h1>Hello <?php echo $name ?></h1>
```
```
Template::render('template-file', [ 'name' => 'World' ]);
```

### Advanced usage ###

my-folder/custom-path/template-file.php
```
<h1>Hello <?php echo $name ?></h1>
```
```
$template = Template::factory();
$template->set_template('my-folder/custom-path/template-file');
$content = $template->render([ 'name' => 'World' ]);
echo $content;
```

## Kerkness\KoreWP\ReactCode ##

Creates a shortcode for embedding a react component in Wordpress.

Full examples to follow..

```
// enqueue components and styles and localized data
ComponentShortcode::init('assets/components.js', 'assets/style.css', [
    'query_vars' => $_GET,
    'current_user' => wp_get_current_user()
]);

// Use the shortcode
[kore_react component="component_name" id="unique-id" other_prop="my other prop"]
```
