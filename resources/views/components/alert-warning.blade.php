@props([
    'show' => false
    ,'show_close_btn' => false
])

@if ($show)
    <div class="alert alert-warning" role="alert">
        @if ($show_close_btn)
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        @endif
        <p class="m-2">
            {{ $slot }}
        </p>
    </div>
@endif