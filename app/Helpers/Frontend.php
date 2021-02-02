<?php

namespace App\Helpers;

use Route;

class Frontend
{
    /**
     * Add class active to menu.
     *
     * @param string $name
     * @param array $currents
     * @return string
     */
    public function menu_active($name, $currents)
    {
        if (in_array($name, $currents)) {
            return 'active';
        }

        return '';
    }

    /**
     * Check the page if it is homepage.
     *
     * @return boolean
     */
    public function is_home()
    {
        $route = Route::currentRouteName();

        return ($route === 'web.home');
    }
}