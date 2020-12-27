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
 * A ready to use Flywheel instance
 * @return App\Core\Flywheel
 */
function flywheel()
{
    return App\Core\Flywheel::instance();
}

/**
 * An instantiated Theme
 * @return App\Core\Theme
 */
function theme()
{
    return App\Core\Theme::instance();
}

function el(string $tag, $attributes = null, $content = null, array $statement = null) : string
{
    /**
     * Checking if there is any statement declared
     */
    if( isset($statement['showif']) && ! $statement['showif'] ) {
        return false;
    }

    unset($statement);

    return Dashboard\Support\HtmlBlocks\HtmlElement::render(...func_get_args());
}


/**
 * Controlling PHP requests
 * @see App\Core\Http\Request
 * @see https://symfony.com/doc/current/components/http_foundation.html#request
 */
function request() {
    return new App\Core\Http\Request;
}

/**
 * Http Responses
 * @see App\Core\Http\Response
 * @see https://symfony.com/doc/current/components/http_foundation.html#response
 */
function response() {
    return new App\Core\Http\Response;
}

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
 * Deterime if the current user is logged in
 * @return bool
 */
function is_loggedin() {
    return call_user_func([new App\Middleware\Auth, 'is_loggedin']);
}

/**
 * Get the current screen based on request
 * @return bool
 */
function screen(string $path) {
    return request()->is($path);
}

/**
 * Show Flash Messages based on user session by using Symfony Session Bag
 *
 * @see Symfony\Component\HttpFoundation\Session\Flash\FlashBag
 * @see https://symfony.com/doc/current/components/http_foundation/sessions.html#flash-messages
 */
function notify() {
    return session()->getFlashBag();
}

/**
 * [notifyMessage description]
 * @return [type] [description]
 */
function notifyMessage()
{

    $messages = session()->getFlashBag()->get('notice');
    if( ! $messages ) {
        return;
    }
    foreach ($messages as $message) {
        echo '<div class="flash-notice">'.$message.'</div>';
    }
}

/**
 * Get database path on disk
 */
if (! function_exists('database_path')) {
    /**
     * Get the database path.
     *
     * @param string $path
     *
     * @return string
     */
    function database_path(string $path = '') : string 
    {
        return STORAGE_PATH . DIRECTORY_SEPARATOR . 'database/' . $path;
    }
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
 * Wraps the Router for the same reason
 * @see App\Core\Router
 */
if( ! function_exists('slugify') ) {
    function slugify($title, $separator = '-', $language = 'en')
    {
        return app()->support()->slug($title, $separator, $language);
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
 * Retrieve the name of the application.
 * 
 * @return string
 */
function app_name()
{
    return app()->config()->get('app.name');
}

/**
 * Retrieve the logo of the application
 * @return string
 */
function app_logo()
{
    return app()->config()->get('app.logo');
}

/**
 * Retrieve the meta title of the application
 * @param  string $title   [description]
 * @param  string $default [description]
 * @return [type]          [description]
 */
function meta_title(string $title = '', $default = '')
{
    return app()->config()->get('app.meta_name');
}

/**
 * Get emoticons from Emoji Builder
 */
if( ! function_exists('emoji') ) {
    function emoji()
    {
        return new App\Core\Components\EmojiBuilder\Emoji;
    }
}

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
 */
function getAsideNavigation()
{

    if( $navigation = flywheel()->getNavigation() ) {
        foreach ($navigation as $key => $nav) {
            
            $icon = $nav->icon ? icon($nav->icon)->size(17) : null;
            $slug = $nav->slug;

            if( $activeCat = getCurrentCategory() )  {
                $activeCat = $activeCat === $slug ? sprintf(' class="%s"', 'active') : null;
            } else {
                $activeCat = null;
            }

            echo sprintf('<li%4$s><a href="/%1$s">%3$s %2$s</a></li>', $slug, $nav->label, $icon, $activeCat);
        }
    }
}
