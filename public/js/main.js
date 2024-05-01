$(document).ready(function() {

    if ($('.dataTable').length) {
        $('.dataTable').each(function() {
            let table = $(this);
            table.DataTable({
                processing: true,
                serverSide: true,
                ajax: table.data('source'),
                columns: table.data('columns'),
                dom: '<"row"<"col-sm-6"B><"col-sm-6"f>><"row"<"col-sm-12"t>><"row"<"col-md-3"i><"col-sm-4"l><"col-md-5"p>>',
                buttons: [
                    'csv'
                ],
                order: [],
            });
        });
    }

    if ($('select').length) {
        $('select').select2({
            theme: 'bootstrap'
        });
    }

    // destroy select2 within dataTable
    if ($('.dataTables_length').length) {
        $('.dataTables_length').find('select').select2('destroy');
    }

    // tool tip selector
    $('body').tooltip({
        'html': true,
        'placement': 'top',
        'selector': '.bs-tooltip'
    });
});

function showSpinner(input, is_loading, spinner_class, input_class) {
    $(is_loading ? '.' + spinner_class : '.' + input_class)
        .removeClass('invisible')
        .removeClass('d-none')
        .addClass('visible');

    $(is_loading ? '.' + input_class : '.' + spinner_class)
        .removeClass('visible')
        .addClass('d-none')
        .addClass('invisible');
    
    $('#' + input).next(".select2-container").toggle();
}

function resetField(elementId, disabled = true) {
    $(`#${elementId}`).empty().attr('disabled', disabled);
}