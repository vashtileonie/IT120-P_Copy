@props([
    'name'
    ,'label'
    ,'route' => ''
])

@if (! Gate::denies($name))
    <a @class(['collapse-item', 'active' => session()->get('sub_nav') === $label]) 
            href="{{ navigateToLink($route) }}">
        {{ $label }}
    </a>
@endif