@props([
    'table_class' => ''
    ,'bordered' => true
])

<table 
    class="table {{ $bordered ? 'table-bordered' : '' }} {{ $table_class }}" 
    {{ $attributes }}>
    {{ $slot }}
</table>