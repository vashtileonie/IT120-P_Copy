@props([
    'name'
    ,'label' => ''
    ,'placeholder' => ''
    ,'form_group_class' => ''
])

<x-form.input :name="$name" 
        :label="$label"
        :placeholder="$placeholder ?: '0.0000'"
        type="number" 
        min="0.0000"
        max="{{ config('admin.max_currency') }}" 
        step="0.0001" 
        {{ $attributes }}
        :form_group_class="$form_group_class"
        />