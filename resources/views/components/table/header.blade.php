@props([
    'name'
    ,'value' => null
])

<th {{ $attributes }}>
    @if (is_null($value))
        {{ label($name) }}
    @else
        {{ $value }}
    @endif
</th>