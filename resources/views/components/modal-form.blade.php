@props([
    'id'
    ,'title' => ''
    ,'route' => ''
    ,'route_params' => []
    ,'submit' => 'submit'
    ,'size' => ''
    ,'show_close' => false
    ,'style' => ''
])

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" 
        aria-hidden="true" id="{{ $id }}" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog {{ $size }}" role="document" style="{{ $style }}">
        <div class="modal-content">
            <div class="modal-header">
                @if ($title)
                    <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                @endif

                @if ($show_close !== false)
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                @endif
            </div>

            <form method="post" action="{{ navigateToLink($route, $route_params) }}" id="form_{{ $id }}" autocomplete="off">
                @csrf
                <div id="modal_body" class="modal-body">
                    {{ $slot }}
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ label('cancel') }}</button>
                    <button class="btn btn-danger btn-{{ $id }}" type="submit">{{ label($submit) }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

