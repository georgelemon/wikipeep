# How to create my own theme?
That's kinda easy. You can start from cloning the <code>twentytwentyone</code> theme from <code>themes</code> directory.
Be sure your theme name is lowercase without spacing or special chars. Once you done, you can go to
<code>config/app.php</code> and update the theme settings:

```php
    /**
     * Appearance Settings
     */
    'theme_settings' => [
        /**
         * The name of the theme based on its directory name (lowercase).
         * @var string (Default theme is twentytwentyone)
         */
        'name' => 'twentytwentyone',
        
        /**
         * When is set true, it will try to look for the theme switcher
         * functionality in order to make the theme switchable (light/dark).
         * @var boolean
         */
        'switch_mode' => true
    ],
```