@props([
    'name'
    ,'icon'
    ,'text' => ''
])

<div class="col-xl-3 mb-2">
    <div class="card shadow">
        <div class="card-header d-flex flex-row bg-primary">
            <i class="{{ $icon }} fa-1x text-white my-auto mr-2"></i>
            <div class="text-white font-weight-bold my-auto">
                {{ $text ?: label($name) }}
            </div>
        </div>
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
</div>