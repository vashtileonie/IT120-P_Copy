@props([
    'route'
    ,'id'
    ,'method' => 'post'
    ,'back' => false
    ,'extra_buttons' => ''
    ,'submit_btn_text' => ''
    ,'show_errors' => true
    ,'form_class' => ''
])

<div>
    @if ($errors->any()
        && $show_errors
    )
        <x-admin.dismissable-panel class="mx-4 mb-0 mx-4 pb-0">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-admin.dismissable-panel>
    @endif

    {{ Form::open(array('route' => is_array($route) ? $route : [$route], 'id' => $id, 'class' => 'form-inline mb-4 ' . $form_class, 'method' => $method)) }}

        {{ $slot }}
        
        @if (is_array($route) && strpos(reset($route), '.edit') !== false)
            <a href="{{ navigateToLink(reset($route), $route[1] ?? []) }}" 
                    class="btn btn-primary">
                {{ label('edit') }}
            </a>
        @else
            <button class="btn btn-primary" type="submit">
                {{ label(!empty($submit_btn_text) ? $submit_btn_text : 'save') }}
            </button>
        @endif
    {{ Form::close() }}
</div>