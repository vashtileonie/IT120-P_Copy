@props([
    'title' => ''
    ,'filters' => ''
])

<x-admin.session-flash-message name="formMsg" />
<x-admin.session-flash-message name="errorMsg" type="alert-danger" />

<x-admin.page-section :title="$title" {{ $attributes }}>
    {{ $filters }}

    {{ $slot }}
</x-admin.page-section>