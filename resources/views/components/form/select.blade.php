@props([
    'name'
    ,'label' => ''
    ,'list' => []
    ,'inline' => 'true'
    ,'value' => old($name)
    ,'empty_first' => false
    ,'form_group_class' => ''
    ,'id' => ''
    ,'disabled' => false
])

<x-form.form-group :name="$name" :label="$label" :form_group_class="$form_group_class" :inline="$inline">
    @php
        if (! function_exists('isSelected')) { 
            function isSelected($source, $val, $id) {
                if (substr($source,-2) === '[]') {
                    $key = str_replace('[]','', $source);
                    if (is_array(old($key, $val))) {
                        return in_array($id, array_values(old($key, $val)));
                    }
                }

                return (($val ?? false) ? old($source, $val) : old($source)) == $id;
            }
        }
    @endphp

    @if ($inline)
        <div class="col-sm-9">
    @endif
        <select name="{{ $name }}" 
                id="{{ ! empty($id) ? $id : $name }}" 
                {{ $attributes(['class' => 'form-control']) }}
                {{ $disabled ? ' disabled' : '' }}>
            @if ($empty_first)
                <option value="">{{ label('select_w_dash') }}</option>
            @endif

            @foreach ($list as $id => $label)
                <option value="{{ $id }}" @selected(isSelected($name, $value, $id))>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    @if ($inline)
        </div>
    @endif
</x-form.form-group>