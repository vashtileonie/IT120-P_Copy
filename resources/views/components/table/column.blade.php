@props([
    'name'
    ,'width' => '30%'
    ,'label' => ''
])

<td width="{{ $width }}" style="vertical-align: middle;" {{ $attributes }}>
    {{ $label ?: label($name) }}
</td>