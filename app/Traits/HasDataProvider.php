<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait HasDataProvider
{
    public static string $name_column = 'name';
    public static string $sort_by = 'name';
    public static bool $is_active_only = true;
    public static bool $select_all = false;
    public static array $select_keys = [];

    
    public static function getDataProvider(?string ...$ctm_cond): Collection
    {
        return static::getOptions(...$ctm_cond);
    }


    public static function getDataProviderKey(): string
    {
        return 'dp.'. strtolower(str_replace('\\','_', __CLASS__));
    }


    public static function reloadDataProvider(?string ...$ctm_cond): Collection
    {
        static::forgetMe();
        return static::getDataProvider(...$ctm_cond);
    }


    public static function forgetMe(): void
    {
        Cache::forget(static::getDataProviderKey());
    }


    protected static function getOptions(?string ...$ctm_cond): Collection
    {
        $col_name = static::$name_column ?? 'name';
        $sortby = Str::of(static::$sort_by)->is('name') && !Str::of($col_name)->is(static::$sort_by) ? $col_name : static::$sort_by;
        $is_active_only = static::$is_active_only;
        
        $key = $ctm_cond ? ('_'. $ctm_cond[0] .'_'. end($ctm_cond)) : '';
        if (! $is_active_only && empty($key)) {
            $key = '_all';
        }
        $key_cache = static::getDataProviderKey() . $key;

        $select_keys = static::$select_keys ?: [$col_name, 'id'];

        return Cache::rememberForever($key_cache,
                fn() => 
                    static::when($ctm_cond, 
                            fn ($query) => 
                                $query->where(...$ctm_cond))
                        ->when(method_exists(static::class, 'scopeActive'),
                            fn ($query) => 
                                $query->activeOnly($is_active_only))
                        ->orderBy($sortby)
                        ->get(static::$select_all ? ['*'] : ['id', $col_name])
                        ->pluck(...$select_keys)
            );
    }


    protected static function forUpdate($model)
    {
        $col_name = static::$name_column ?? 'name';
        if ($model[$col_name] !== $model->getOriginal($col_name)) {
            // reload data provider if name column has been updated
            static::forgetMe();
        }

        if (method_exists(static::class, 'scopeActive') && $model->is_active != $model->getOriginal('is_active')) {
            // reload if is_active prop has been modified
            static::forgetMe();
        }

        static::onUpdate($model);
    }


    protected static function onUpdate($model)
    {

    }
}