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
 * Get a basic, readable formatted date 
 * @return string
 */
function get_date($strDate)
{
    $date = new DateTime($strDate);
    return $date->format(config()->get('app.date_format'));
}
