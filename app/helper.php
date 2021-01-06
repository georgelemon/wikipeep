<?php

/**
 * Wraps a singleton version of the Application class for quick calls
 * @see App\Core\Application
 */
if( ! function_exists('app') ) {
    
    function app()
    {
        return App\Core\Kernel\Application::instance();
    }
}

/**
 * Retrieve the instantiated Config class
 * @return Config Array Access
 */
function config()
{
    return app()->config();
}

/**
 * A ready to use Flywheel instance
 * 
 * @return App\Core\Flywheel
 */
function flywheel()
{
    return App\Core\Flywheel::instance();
}

/**
 * An instantiated Theme
 * 
 * @return App\Core\Theme
 */
function theme()
{
return App\Core\Theme::instance();
}

/**
 * Retrieve the public path to current theme stylesheet css.
 * 
 * @return string
 */
function getStylesheetTag()
{
    return theme()->getStylesheetTag();
}

/**
 * Retrieve the preferred protocol.
 * 
 * @return string
 */
function ssl()
{
    return $protocol = env('SSL') ? 'https://' : 'http://';
}

/**
 * Get the URL of the application.
 * 
 * @return string
 */
function app_url()
{
    echo ssl() . env('APP_URL');
}

/**
 * Retrieve asset path.
 * 
 * @param string $asset_path
 * 
 * @return string
 */
function asset($asset_path)
{
    return ssl() . env('APP_URL') . DS . $asset_path;
}

/**
 * Controlling PHP requests
 * 
 * @see App\Core\Http\Request
 * @see https://symfony.com/doc/current/components/http_foundation.html#request
 */
function request() {
    return new App\Core\Http\Request;
}

/**
 * Http Responses
 * 
 * @see App\Core\Http\Response
 * @see https://symfony.com/doc/current/components/http_foundation.html#response
 */
function response($content = '', $status = 200, array $headers = []) {
    return new App\Core\Http\Response($content, $status, $headers);
}

/**
 * URI Handler
 * 
 * @return UriGenerator;
 */
function uri() {
    return new App\Core\Http\UriGenerator;
}


/**
 * Creates specific User Session
 * @see Symfony\Component\HttpFoundation\Session\Session
 * @see https://symfony.com/doc/current/components/http_foundation/sessions.html
 */
function session() {
    return new Symfony\Component\HttpFoundation\Session\Session(new App\Core\Http\NativeSessionStorage);
}

/**
 * Get the current screen based on request
 * @return bool
 */
function screen(string $path) {
    return request()->is($path);
}

/**
 * Wraps the Router for the same reason
 * @see App\Core\Router
 */
if( ! function_exists('route') ) {
    function route()
    {
        return app()->route();
    }
}

/**
 * Retrieve an SVG icon from Library Collections.
 *
 * @param string $key           the identifier of the svg icon
 * @param array $attr           optional
 * @param string $library       (default: feather)
 */
function icon(string $key = null, array $attr = [], $library = 'feather') {   
    return Ethos\Dessert\Library::getInstance($library)->render($key, $attr);
}

/**
 * Retrieve the name of the application.
 * 
 * @return string
 */
function app_name()
{
    return config()->get('app.name');
}

/**
 * Retrieve the logo of the application
 * @return string
 */
function app_logo()
{
    return config()->get('app.logo');
}

/**
 * Retrieve the meta title of the application
 * 
 * @param  string $title   
 * @param  string $default
 * 
 * @return string
 */
function meta_title(string $title = '', $default = '')
{
    return config()->get('app.meta_name');
}

/**
 * Get the current category from Request
 * 
 * @return string
 */
function getCurrentCategory()
{
    $currentCategory = request()->segment(1);

    if( ! $currentCategory ) {
        return;
    }

    return $currentCategory;
}

/**
 * Retrieves the main navigation menu
 *
 * @return string
 */
function getAsideNavigation()
{

    if( $navigation = flywheel()->getNavigation() ) {
        foreach ($navigation as $key => $nav) {
            
            // Get icon if provided
            $icon = $nav->icon ? icon($nav->icon)->size(17) : null;

            // Get slug uri and check if this is an internal or external link
            $slug = strpos($nav->slug, 'http') === 0 ? $nav->slug : uri()->base($nav->slug);

            if( $activeCat = getCurrentCategory() )  {
                $activeCat = $activeCat === str_replace('/', '', $slug) ? sprintf(' class="%s"', 'active') : null;
            } else {
                $activeCat = null;
            }

            if( $separator = $nav->separator ) {
                $separator = $separator->before ? 'before' : ($separator->after ? 'after' : null);
                $separator = sprintf('item-separator="%s"', $separator);
            }

            echo sprintf('<li%4$s %5$s><a href="%1$s">%3$s %2$s</a></li>', $slug, $nav->label, $icon, $activeCat, $separator);
        }
    }
}

/**
 * When enabled retrieves all cookie settings from config/cookie.php
 * 
 * @return array
 */
function getCookieSettings()
{
    $cookie = config()->get('cookie');
    return $cookie['enabled'] && $cookie['settings'] ? $cookie['settings'] : null;
}

/**
 * When avilable, it will return the cookie disclaimer from config/cookie.php
 * 
 * @return string
 */
function getCookeDisclaimer()
{
    return config()->has('cookie.disclaimer') ? htmlspecialchars(config()->get('cookie.disclaimer')) : null;
}

/**
 *
 * It injects an inline JavaScript array in the head of your WikiPeep,
 * in order to create a simple bridge that will be used via JavaScript
 * by search related functionality.
 * 
 * @return string
 */
function getApplicationSettings()
{
    $api = config()->get('api');
    $vers = glob(STORAGE_PATH . '/__search--version--*');
    if( $vers ) {
        $vers = $vers[0];
        $vers = explode(STORAGE_PATH , $vers)[1];
        if( str_contains($vers, '/') ) {
            $vers = str_replace('/__search--version--', '', $vers);
        } else {
            $vers = str_replace('__search--version--', '', $vers);
        }
    } else {
        $vers = 10; // default version
    }

    return sprintf('<script>const __settings = %s</script>', json_encode([
                // The URL of the app
                'app_url' => uri()->base(),
                // // Whether to serve the app over https protocol
                // 'app_ssl' => env('SSL'),
                // The base API endpoint.
                'api_base' => $api['base'],
                // Search Results API Endpoint is used by the search
                // to fetch data via JavaScript. For changing the default endpoint
                // go to configs/api.php
                'search_endpoint' => $api['search'],
                // The latest search update is used for keeping the track
                // of builds so people who visited your WikiPeep before
                // can get the latest version of search results directly to their IndexedDB.
                // Gets filled with the date of the last build.
                'latest_search_update' => $vers,
                // The only thing related to cookies that WikiPeep
                // does by default is to set a cookie for theme preference.
                'cookie_settings' => getCookieSettings(),
                // Retrieve the cookie disclaimer message
                'cookie_disclaimer' => getCookeDisclaimer()
        ]));
}

/**
 * [excerpt description]
 * @param  string $content [description]
 * @param  string $slug    [description]
 * @return [type]          [description]
 */
function excerpt(string $content, string $slug)
{
    if (strlen($content) > 120) {
        
       return substr($content, 0, 120) . '...';
    }

    return $content;
}

/**
 * Format dates from one type to other.
 * 
 * @return string
 */
function get_formatted_date($strDate, $fromFormat, $toFormat, string $timezone = null)
{
    $date = DateTime::createFromFormat($fromFormat, $strDate);
    $date->setTimezone( new DateTimeZone( $timezone ?? config()->get('app.timezone') ) );
    return $date->format(config()->get('app.date_format'));
}