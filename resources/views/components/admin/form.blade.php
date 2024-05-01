@props([
    'route'
    ,'id'
    ,'back_text'
    ,'method' => 'post'
])

<div>
    <x-form.errors />

    <div class="card-body" style="width: 50%">
        {{ Form::open(array('route' => is_array($route) ? $route : [$route], 'id' => $id, 'method' => $method)) }}

            {{ $slot }}
            
            <div class="form-group mt-5">
                <button class="btn btn-secondary" type="button" 
                        onclick="window.history.back()">
                    {{ label('cancel') }}
                </button>
                
                @if (is_array($route) && strpos(reset($route), '.edit') !== false)
                    <a href="{{ navigateToLink(reset($route), $route[1] ?? []) }}" 
                            class="btn btn-primary">
                        {{ label('edit') }}
                    </a>
                @else
                    <button class="btn btn-primary" type="submit">
                        {{ label('save') }}
                    </button>
                @endif
            </div>
        {{ Form::close() }}
    </div>
</div>