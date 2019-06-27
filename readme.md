# Global Elementor Buttons

**Standardizes the Elementor Button with global classes that can be managed in a single place.**

Tired of having to update every single button style in your [Elementor](https://elementor.com/) website when the client asks for a change? Not too happy with Elementor's default button Styles or Sizes? Do you wish you were able to modify, add or remove them? Then this plugin is just what you need!

**Global Elementor Buttons** standardizes Elementor Buttons with global classes that can be managed in a single place with custom css (and it works with both Elementor and Elementor Pro!)

### Details ###

This plugin creates a new Elementor Widget, called **Global Button** that contains a simplified UI, just with the necessary controls to keep all of your buttons global and flexible. However, in the need of a special button, you can still add specific ids or classes to them!

**Includes a handful of useful hooks for full flexibility:**
* Set your own custom Style and Size classes (for example, btn-*primary*).
* Add / remove existent Style and Size classes.
* Change or remove the Style and Size prefix (for example, *btn-*primary).
* Edit the default Style and Size class.

For demonstration purposes, this plugin adds a minified version of the [Bootstrap Buttons](https://getbootstrap.com/docs/4.0/components/buttons/) stylesheet. Global Elementor Buttons allows you to remove this stylesheet, for performance and complexity reasons (see **Customization**).

## Installation

1. Make sure you have [Elementor or Elementor Pro](https://elementor.com) installed and activated.
2. Install the plugin through the WordPress plugins screen directly or upload the plugin to the plugins directory.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Go into your Elementor Editor, find the widget **Global Button** under the *Basic* section tab and add it to your website.
5. Within the widget you will find all the necessary fields.

## Customization
This plugin implements hooks for simple, yet useful editing of the classes' names, prefixes and defaults.

#### Modifying the Style & Size Classes
This plugin offers custom hook filters that allow the modification of the Style and Size classes - `tmx_set_button_styles` and `tmx_set_button_sizes` respectively.
The default classes for the Style are:
```php
$styles = [
    'primary' => 'Primary',
    'secondary' => 'Secondary',
    'success' => 'Success',
    'danger' => 'Danger',
    'warning' => 'Warning',
    'info' => 'Info',
    'light' => 'Light',
    'dark' => 'Dark',
    'link' => 'Link',
];
```
And for the sizes:
```php
$sizes = [
	'xs' => 'Extra Small',
	'sm' => 'Small',
	'md' => 'Medium',
	'lg' => 'Large',
	'xl' => 'Extra Large',
];
```

---

If you want to use your own classes, add or remove the existing ones, you can do so by modifying and adding the following code snippets in your `functions.php` file:

##### Replace the Existing Classes:
This snippet replaces the plugin's default classes entirely.

**Styles:**

```php
function replace_button_styles() {
    return [
        'new-class' => 'New Class',
        'another-class' => 'Another Class',
    ];
}
add_filter( 'tmx_set_button_styles', 'replace_button_styles', 10 );
```

**Sizes:**

```php
function replace_button_sizes() {
    return [
        'new-size' => 'New Size',
        'another-size' => 'Another Size',
    ];
}
add_filter( 'tmx_set_button_sizes', 'replace_button_sizes', 10 );
```

---


##### Add to the Existing Classes:
Note that newly added styles will be at the end of the backend's select box!

**Styles:**

```php
function add_button_styles( $styles ) {
    return array_merge( $styles, [
        'new-class' => 'New Class',
        'another-class' => 'Another Class',
    ] );
}
add_filter( 'tmx_set_button_styles', 'add_button_styles', 10, 1 );
```

**Sizes:**

```php
function add_button_sizes( $sizes ) {
    return array_merge( $sizes, [
        'new-size' => 'New Size',
        'another-size' => 'Another Size',
    ] );
}
add_filter( 'tmx_set_button_sizes', 'add_button_sizes', 10, 1 );
```

---

##### Remove Items from the Existing Classes:
You can delete specific elements by *unsetting* them from the array via their key.

**Styles:**

```php
function remove_button_styles( $styles ) {
    unset( $styles['primary'] );
    unset( $styles['secondary'] );
    return $styles;
}
add_filter( 'tmx_set_button_styles', 'remove_button_styles', 10, 1 );
```

**Sizes:**

```php
function remove_button_styles( $sizes ) {
    unset( $sizes['lg'] );
    unset( $sizes['sm'] );
    return $sizes;
}
add_filter( 'tmx_set_button_sizes', 'remove_button_styles', 10, 1 );
```

---


#### Modifying the Prefix Class
By default the button styles are prefixed with `btn btn-` (just like Bootstrap's style) - the button sizes with `elementor-size-` (following Elementor's styles). You can change them with the `tmx_set_button_style_prefix` filter for the styles, and with `tmx_set_button_size_prefix` for the sizes.

If you wish to remove the prefix entirely, you can just return nothing, like `return '';`

**Styles Prefix:**

```php
function change_button_style_prefix( ) {
    return 'new-prefix-';
}
add_filter( 'tmx_set_button_style_prefix', 'change_button_style_prefix', 10 );
```

**Sizes Prefix:**

```php
function change_button_size_prefix( ) {
    return 'new-prefix-';
}
add_filter( 'tmx_set_button_size_prefix', 'change_button_size_prefix', 10 );
```

---

#### Changing the Default Selected Class
The default class for the button style is `primary` and for the size is `sm`. The filters `tmx_set_button_style_default` and `tmx_set_button_size_default` allow us to change the defaults of the style and size respectively.

**Note 1:** your new default must be in the array! If it is not in the array, all your newly created buttons will appear without any styling (naturally, this depends on you css code).

**Note 2:** remember that here you only need the key, not the prefix. For example, `return 'info';` and not `return 'btn btn-info';`

**Style Default:**

```php
function change_button_style_default( ) {
    return 'info';
}
add_filter( 'tmx_set_button_style_default', 'change_button_style_default', 10 );
```

**Size Default:**

```php
function change_button_size_default( ) {
    return 'lg';
}
add_filter( 'tmx_set_button_size_default', 'change_button_size_default', 10 );
```

---

#### Remove the Default Stylesheet
As mentioned before, this plugin adds a minified stylesheet to demonstrate its functionality quickly without having too much setup required. We care about project performance and complexity (nobody wants unknown stylesheets getting loaded from a bunch of different plugins).

You can disable the stylesheet from being enqueued with the filter `tmx_should_enqueue_default_stylesheet`. Its default naturally is set to `true`. The sample code is here below:

```php
function should_enqueue_default_styles() {
    return false;
}
add_filter( 'tmx_should_enqueue_default_stylesheet', 'should_enqueue_default_styles', 10 );
```


## Changelog
* 1.0.0 - Initial Release

## License
This plugin is developed and maintained by [Santiago Degetau](tmx_set_button_size_prefix) (*TausWorks*).

License: [GPL V2 or later](https://www.gnu.org/licenses/gpl-2.0.html).