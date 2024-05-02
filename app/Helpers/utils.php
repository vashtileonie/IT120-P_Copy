<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

if (! function_exists('abortNoAccess')) {
    function abortNoAccess(string $name) 
    {
        abort_if(Gate::denies($name), Response::HTTP_FORBIDDEN, 'Forbidden');
    }
}


if (! function_exists('createDateFromFormat')) {
    function createDateFromFormat(string $str_date, string $format = 'Y-m-d') 
    {
        return Carbon::createFromFormat($format, $str_date);
    }
}


if (! function_exists('getFormattedDateTime')) {
    function getFormattedDateTime($dt): string 
    {
        if (! $dt) {
            return '';
        }

        return createDateFromFormat($dt,'Y-m-d H:i:s')?->format('F j, Y h:i:s a');
    }
}


if (! function_exists('getFormattedDate')) {
    function getFormattedDate($dt): string 
    {
        if (! $dt) {
            return '';
        }

        return createDateFromFormat($dt)?->toFormattedDateString();
    }
}


if (! function_exists('currency')) {
    function currency($num): string
    {
        return config('webtool.currency_symbol') .' '
                . number_format($num ?? 0,config('webtool.currency_decimal_place'));
    }
}


if (! function_exists('getUserAccount')) {
    function getUserAccount(): int 
    {
        $auth_user = Auth::user();
        if ($auth_user->account){
            return $auth_user->account->id;
        }
    
        return 0;
    }
}


if (! function_exists('translate')) {
    function translate($key, $param = null, $prefix = '') {
        if (! empty($prefix)) { 
            $key = $prefix.'.'.$key;
        }

        if (is_array($param)) {
            if ($param['plural'] ?? false) {
                unset($param['plural']);
                return trans_choice($key, 2, $param);
            }

            return __($key, $param);
        }

        if (is_numeric($param)) {
            return trans_choice($key, $param);
        }

        return __($key);
    }
}


if (! function_exists('label')) {
    function label($key, $param = null) {
        if (strpos($key, ':plural') !== false) {
            $param['plural'] = true;
            return translate(str_replace(':plural','', $key), $param, 'labels');
        }

        return translate($key, $param ?: 1, 'labels');
    }
}


if (! function_exists('labelByCount')) {
    function labelByCount(string $key, int $count = 0) {
        return label($key . ($count > 1 ? ':plural' : ''), $count > 1 ? ['count' => $count] : 1);
    }
}


if (! function_exists('menuLabel')) {
    function menuLabel($key, $param = null) {
        return translate($key, $param, 'menu');
    }
}


if (! function_exists('message')) {
    function message($key, $param = null) {
        return translate($key, $param, 'messages');
    }
}


if (! function_exists('navigateToLink')) {
    function navigateToLink(string $route, $params = null) {
        if ($params) {
            return Route::has($route) ? route($route, $params) : '#';
        }

        return Route::has($route) ? route($route) : '#';
    }
}


if (! function_exists('debug')) {
    function debug($msg) {
        if (! Config::get('app.debug')) {
            return;
        }

        $msg = !is_string($msg) ? var_export($msg,true) : trim($msg);
        $msg = "{$msg}\r\n";

        logger($msg);
    }
}


if (! function_exists('rememberNav')) {
    function rememberNav(string $main_nav, string $sub_nav = '') {
        Session::put('main_nav', $main_nav);
        Session::put('sub_nav', $sub_nav ?: $main_nav);
    }
}

if (! function_exists('rememberGuestNav')) {
    function rememberGuestNav(string $main_nav = '') {
        Session::put('topbar', $main_nav);
    }
}


if (! function_exists('tool_tip')) {

    /**
     * Returns the data attributes for Tool tip with the content that needs to go within
     *
     * @param string $name
     * @param boolean $text_only
     * @return mixed
     */
    function tool_tip(string $name, bool $text_only = false)
    {
        // get descriptions
        $descriptions = Arr::dot(Config::get('webtool.descriptions'));

        // get label
        if (strpos($name, ':') !== false) {
            $name = strtolower(label($name));
        }

        // check if name is available
        if (array_key_exists($name, $descriptions)
            && !empty($descriptions[$name])
        ) {

            // if text only
            if ($text_only) {
                return $descriptions[$name];
            }

            // get label
            return ' class="bs-tooltip" title="' . $descriptions[$name] . '"';
        }

        return null;
    }
}

if (! function_exists('mapSelectValues')) {

    /**
     * Provides structure for select2
     */
    function mapSelectValues($list, $values = null)
    {
        if (empty($list)) {
            return [];
        }

        return $list->map(
                    function ($value, $key) use ($values) {
                        $data = [
                            'id' => $key, 'text' => $value
                        ];

                        if (is_array($values)
                            && in_array($key, $values)
                        ) {
                            $data['selected'] = true;
                        } else {
                            if ($key == $values) {
                                $data['selected'] = true;
                            }
                        }

                        return $data;
                    })
                ->values();
    }
}

if (! function_exists('generateReferenceNo')) {

    function generateReferenceNo(Model $model)
    {
        // flag for generated reference no.
        $generated = false;
        $reference_no = strtoupper(Str::random(config('webtool.reference_no_length')));

        // perform do while
        do {
            $transaction = $model::where('reference_no', $reference_no)
                            ->count();
            if ($transaction > 0) {
                $reference_no = strtoupper(Str::random(10));
            } else {
                $generated = true;
            }
        } while(!$generated);

        // return reference
        return $reference_no;
    }
}
