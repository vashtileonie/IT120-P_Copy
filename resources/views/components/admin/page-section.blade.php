@props([
    'title' => ''
    ,'text' => ''
])

<div {{ $attributes(['class' => 'card shadow mb-4']) }}>
    @if ($title || $text)
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $text ?: label($title) }}</h6>
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>
</div>