@props([
    'route'
    ,'id'
    ,'back_text'
    ,'method' => 'post'
    ,'no_back' => false
    ,'back' => false
    ,'extra_buttons' => ''
    ,'submit_btn_text' => ''
    ,'basecontrol' => true
    ,'show_errors' => true
    ,'upload' => false
    ,'full_form' => false
    ,'has_submit_btn' => true
    ,'autocomplete' => ''
])

@php
    $form_props = [
        'route' => is_array($route) ? $route : [$route]
        ,'id' => $id
        ,'method' => $method
        ,'autocomplete' => $autocomplete
    ];

    if ($upload) {
        $form_props['enctype'] = 'multipart/form-data';
    }

    $url_segments = request()->segments();
@endphp

<div>
    <x-form.errors />

    <div class="card-body" @if(! $full_form) style="width: 50%;" @endif>
        {{ Form::open($form_props) }}

            {{ $slot }}
            
            <div class="form-group @if($basecontrol) mt-5 @endif">
                @if ($basecontrol)
                    @if (! filter_var($no_back, FILTER_VALIDATE_BOOLEAN))
                        @if ($back)
                            <a class="btn btn-secondary mr-2"
                                    href="{{ 
                                        navigateToLink(
                                                is_array($back) 
                                                ? reset($back) 
                                                : $back
                                            ,is_array($back) 
                                                ? ($back[1] ?? null) 
                                                : []) 
                                    }}"
                                    >
                                {{ label($back_text ?? 'cancel') }}
                            </a>
                        @else
                            <a href="{{ $url_segments[0] ? route($url_segments[0] . '.index') : 'javascript:window.history.back();'  }}"
                                class="btn btn-secondary mr-2">
                                {{ label($back_text ?? 'cancel') }}
                            </a>
                        @endif
                    @endif
                    
                    @if (is_array($route) && strpos(reset($route), '.edit') !== false)
                        <a href="{{ navigateToLink(reset($route), $route[1] ?? []) }}" 
                                class="btn btn-primary mr-2">
                            {{ label('edit') }}
                        </a>
                    @elseif($has_submit_btn)
                        <button class="btn btn-primary mr-2" type="submit">
                            {{ label(!empty($submit_btn_text) ? $submit_btn_text : 'save') }}
                        </button>
                    @endif
                @endif

                {{ $extra_buttons }}
            </div>
        {{ Form::close() }}
    </div>
</div>