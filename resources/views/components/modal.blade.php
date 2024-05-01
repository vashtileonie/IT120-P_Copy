@props([
    'id'
    ,'size' => ''
    ,'route' => ''
    ,'title' => ''
    ,'title_params' => []
    ,'form' => ''
    ,'ok' => ''
    ,'route_params' => []
    ,'alert' => false
    ,'btn_ok_class' => 'btn-danger'
])

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="{{ $id }}">
    <div class="modal-dialog {{ ! empty($size) ? 'modal-' . $size : '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($title)
                    <h5 class="modal-title" id="exampleModalLabel">{{ message($title, $title_params) }}</h5>
                @endif

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div id="modal_body" class="modal-body">
                {{ $slot }}
            </div>

            <div class="modal-footer">
                @if ($alert)
                    <button class="btn btn-primary" type="button" data-dismiss="modal">{{ label('ok') }}</button>
                @else
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ label('cancel') }}</button>
                
                    <a class="btn {{ $btn_ok_class }} {{ 'btn_'. $id }}" 
                            id="btn_ok" 
                            href="{{ $route ? route($route, $route_params) : '#' }}" 
                            {{ $attributes }}>
                        {{ label($ok ?: 'ok') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

