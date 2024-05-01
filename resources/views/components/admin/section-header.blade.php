@props([
    'label' => '',
    'title' => ''
])

<div class="d-flex flex-row mb-2">
    <h1 class="my-auto h3 text-gray-800">{{ $title ?: label($label) }}</h1>

    <div class="ml-auto p-2 my-auto">
        {{ $slot }}
    </div>
</div>