@props([
    'name'
    ,'rows' => 4
    ,'label' => ''
    ,'inline' => true
    ,'placeholder' => ''
    ,'edit_value' => ''
])

<x-form.form-group :name="$name" :label="$label" :inline="$inline">
    @if ($inline)
        <div class="col-sm-9">
    @endif
        <textarea id="{{ $name }}"
            name="{{ $name }}"
            {{ 
                $attributes([
                    'class' => 'form-control'
                    ,'rows' => $rows
                    ,'placeholder' => label($placeholder ?: $name)
                    ]) 
            }}
            >{!! ($attributes['value'] ?? false) ? old($name, $attributes['value']) : old($name) !!}</textarea>
    @if ($inline)
        </div>
    @endif
</x-form.form-group>