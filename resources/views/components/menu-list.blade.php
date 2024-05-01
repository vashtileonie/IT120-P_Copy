@props([
    'name'
    ,'icon'
    ,'from'
    ,'to'
])

@php
    $control_name = 'collapse'. $name;
@endphp


@if (Auth::user()->role->permissions->whereBetween('id', [$from, $to])->count())
    <li class="nav-item {{ session()->get('main_nav') === $name ? 'active' : '' }}" style="width: 18rem;">
        <a class="nav-link {{ session()->get('main_nav') != $name ? 'collapsed' : '' }}" 
                href="#" 
                data-toggle="collapse" 
                data-target="#{{ $control_name }}" 
                aria-expanded="true" 
                aria-controls="{{ $control_name }}"
                style="width: 18rem !important;">
            <i class="pr-2 {{ $icon }}" style="width: 1rem !important;"></i>
            <span>{{ menuLabel($name) }}</span>
        </a>

        <div id="{{ $control_name }}" 
                class="collapse {{ session()->get('main_nav') === $name ? 'show' : '' }}" 
                aria-labelledby="headingTwo" 
                data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{ $slot }}
            </div>
        </div>
    </li>
@endif