@props([
    'name'
    ,'raw' => false
    ,'details' => []
    ,'type' => 'info'
    ,'icon' => ''
])

<div role="alert" {{ $attributes(['class' => 'alert alert-'. $type]) }}>
    <p class="m-2">
    @if (! empty($icon))
        <i class="fas {{ $icon }}" aria-hidden="true"></i>
    @endif
    @if (filter_var($raw, FILTER_VALIDATE_BOOLEAN))
        {!! message($name) !!}
    @else
        {{ message($name, $details)}}
    @endif
    </p>
</div>