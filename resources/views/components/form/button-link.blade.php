@props([
    'name'
    ,'route' => ''
    ,'link' => ''
    ,'icon' => ''
    ,'route_params' => []
    ,'back' => false
    ,'label' => ''
    ,'modal' => false
])

@php
    $anchor = $back ? 'javascript:window.history.back();' : navigateToLink($route, $route_params);

    if ($modal) {
        $anchor = '#';
    }
@endphp

<a href="{{ $anchor }}" {{ $attributes(['class' => 'd-sm-inline-block btn btn-primary shadow-lg'])}}>
    <i class="{{ $icon ?: '' }} fa-sm text-white-50"></i> {{ $label ?: label($name) }}
</a>