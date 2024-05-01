<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="" id="deleteForm">
            @method('delete')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ trans('Are you sure you want to proceed with deletion?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">{{ trans('Select "Delete" below if you are ready.') }}</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ trans('Cancel') }}</button>
                    <button id="deleteBtn" class="btn btn-danger" type="submit">{{ trans('Delete') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('body').on('click', '.deleteIcon', function () {
            var url = $(this).data('url');
            $('#deleteForm').attr('action', url);
        });
    });
</script>