<?php

namespace App\Console\BuildConcerns;

trait NavigationDetails
{

    /**
     * Stores directories in order to create the main navigation menu
     * 
     * @param  string  $key             When available, is used for ordering the array
     * @param  string  $label           The name of the page, based on dir name, or by _settings.yaml
     * @param  string  $slug            The URI of the page
     * @param  string  $icon            When provided, prepends an SVG icon
     * @param  array|null $separator    When available it can add a visual separator before/after the item
     * 
     * @return  void
     */
    protected function storeInNavigation($key, $label, $slug, $icon, $separator = null)
    {
        $this->menuItems[$key] = [
            'label' => $label,
            'slug' => $slug,
            'icon' => $icon,
            'separator' => $separator
        ];
    }

    /**
     * Store articles as sub items in the main navigation menu
     * 
     * @param  [type] $parentKey [description]
     * @param  [type] $label     [description]
     * @param  [type] $slug      [description]
     * 
     * @return [type]            [description]
     */
    protected function storeInNavigationSubItems($parentKey, $slug, $label)
    {
        $this->menuSubItems[$parentKey] [] = [
            'label' => $label,
            'slug' => $slug
        ];
    }

    /**
     * Retrieve already stored and sorted items for navigation menu.
     * 
     * @return  array
     */
    protected function getNavigationItems()
    {
        ksort($this->menuItems); // Sort the items based on their specified order
        return $this->menuItems;
    }

    /**
     * Retrieve stored navigation sub items.
     * 
     * @return array
     */
    protected function getNavigationSubItems($parent)
    {
        return $this->menuSubItems[$parent] ?? null;
    }
}