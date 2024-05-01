@props([
    'label'
])

<x-table.row>
    <x-table.column :name="$label" />
    <td>
        {{ $slot }}
    </td>
</x-table.row>