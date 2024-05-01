@props([
    'label'
    ,'key' => null
])

@php
    $tool_tip = tool_tip($label);
    if (is_null($key)
        || empty($key)
    ) {
        $key = $label;
    }
@endphp

@if (! is_null($tool_tip))
    <span {!! $tool_tip !!}>
        {{ label($label) }}
        <i class="fas fa-info-circle"></i>
    </span>
@else
    {{ label($label) }}
@endif