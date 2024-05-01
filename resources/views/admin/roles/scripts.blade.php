<script>
$(document).ready(function () {
    checkedPermissions();

    $(document).on('change', '#permissions :checkbox', function() {
        checkedPermissions();
    });

    $(document).on('click', '#flexCheck_all', function () {
        if ($(this).is(':checked')) {
            $('#permissions').find(':checkbox').prop('checked', true);
        } else {
            $('#permissions').find(':checkbox').prop('checked', false);
        }
    });
});

function checkedPermissions()
{
    let checkedPermissions = $('#permissions').find(':checkbox:checked').length;
    if (checkedPermissions > 0
        && checkedPermissions == $('#permissions').find(':checkbox').length
    ) {
        $('#flexCheck_all').attr('checked', true);
    } else {
        $('#flexCheck_all').attr('checked', false);
    }
}
</script>