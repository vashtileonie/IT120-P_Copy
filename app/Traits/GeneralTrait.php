<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Country;
use App\Models\Province;

trait GeneralTrait
{
    /**
     * Sets active link on the Sidebar according to feature/function
     *
     * @param string $main_nav
     * @param string $sub_nav
     */
    public function setSidebarActiveLink(string $main_nav, string $sub_nav = '')
    {
        $this->middleware(function ($request, $next) use ($main_nav, $sub_nav) {

            rememberNav($main_nav, $sub_nav);

            return $next($request);
        });
    }
}