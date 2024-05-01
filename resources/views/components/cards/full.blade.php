@props([
    'title' => ''
    ,'subtitle' => ''
    ,'id' => ''
])

<div class="col-sm-6" id="{{ $id }}">
    <div class="card mb-4 shadow">
        @if ($title)
            <div class="card-header">
                {{ $title }}
            </div>
        @endif
        <div class="card-body">
            {{ $slot }}

            @if ($subtitle)
                <p class="card-text">
                    <small class="text-muted">
                        {{ $subtitle }}
                    </small>
                </p>
            @endif

            <div class="card-footer d-flex flex-row">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>