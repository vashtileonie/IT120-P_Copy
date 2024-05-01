@props([
    'name'
    ,'icon'
])

@php($main_nav = session()->get('main_nav'))

<li @class(['nav-item', 'active' => $main_nav === $name])>
    <a @class(['nav-link', 'collapsed' => $main_nav === $name]) 
            href="#" 
            data-toggle="collapse" 
            data-target="#collapse{{ $name }}" 
            aria-expanded="true" 
            aria-controls="collapse{{ $name }}"
            >
        <i class="{{ $icon }}" aria-hidden="true"></i>
        <span>{{ $name }}</span>
    </a>

    <div id="collapse{{ $name }}" @class(['collapse', 'show' => $main_nav === $name]) aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            {{ $slot }}
        </div>
    </div>
</li>