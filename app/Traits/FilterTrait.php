<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

use App\Models\Brand;
use App\Traits\AuthUserTrait;

trait FilterTrait
{
    use AuthUserTrait;

    public function brandFilter(string $route = null, string $target = null, string $wrapper_class = '', $brand_id = null, $required = false, $disabled = false)
    {
        // if not super admin nor customer service
        if (!$this->isSuperAdmin()
            && !$this->isCustomerService()
        ) {

            // check user brand
            $this->checkUserBrand();

            // if adding or editing
            if (Route::current()->action['as'] != Route::current()->uri() . '.index'
                && !empty($this->user_brands)
            ) {

                return '<input type="hidden" name="brand_id" value="' . $this->user_brands[0] . '">';
            }
            return;
        }

        // filter brand
        $brands = Brand::orderBy('name')
                            ->get();

        $required_attr = $required ? ' required' : '';
        $disabled_attr = $disabled ? ' disabled' : '';

        return view('layouts.filters.brand')
                ->with('wrapper_class', $wrapper_class)
                ->with('route', $route)
                ->with('target', $target)
                ->with('brands', $brands)
                ->with('brand_id', $brand_id)
                ->with('required_attr', $required_attr)
                ->with('disabled_attr', $disabled_attr)
                ->render();
    }
}