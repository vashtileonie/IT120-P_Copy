@props([
    'type' => 'primary'
    ,'badge_class' => ''
])

<span class="badge badge-{{ $type }} {{ $badge_class }}" {{ $attributes }}>{{ $slot }}</span>