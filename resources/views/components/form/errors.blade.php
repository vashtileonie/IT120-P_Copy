@if ($errors->any())
    <x-admin.dismissable-panel class="mx-4 mb-0 mx-4 pb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-admin.dismissable-panel>
@endif