<?php

/**
 * A ready to use Flywheel instance
 * 
 * @return App\Core\Flywheel
 */
function flywheel()
{
    return app()->flywheel();
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
    $items = '';
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

            $items .= sprintf('<li%4$s %5$s><a href="%1$s">%3$s %2$s</a></li>', $slug, $nav->label, $icon, $activeCat, $separator);
        }

        return $items;
    }
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

/**
 * Get a basic, readable formatted date.
 * 
 * @return string
 */
function get_date($strDate)
{
    $date = new DateTime($strDate);
    return $date->format(config()->get('app.date_format'));
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


    // Try get the version of the search results from disk
    // if( $filesystem->exists(STORAGE_PATH . '') ) {
    //     // $version = 
    // }

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