@props([
    'name'
    ,'id' => ''
    ,'value' => ''
    ,'value_set' => []
    ,'label' => ''
    ,'form_group_class' => ''
    ,'text' => ''
])

@php
    $checked = false;

    // check if name is array
    if ((substr($name, -2) == '[]'
            && is_array(old($name))
            && in_array($value, old($name))
        )
        || $value == old($name)
    ) {
        $checked = true;
    }

    // check if we have value set
    if (! empty($value_set)
        && in_array($value, $value_set)
    ) {
        $checked = true;
    }
@endphp

<div class="form-group {{ $form_group_class }}">
    <div class="form-check mb-3">
        <input type="checkbox" 
            name="{{ $name }}" 
            id="{{ $id ?? $name }}" 
            class="form-check-input" {{ $attributes }}
            @checked($checked)
            value="{{ $value }}"
            {{ $attributes }}
            >

        <label class="form-check-label" for="{{ $id ?? $name }}">
            {{ $text ?: label($label ?: $name) }}
        </label>
    </div>
</div>