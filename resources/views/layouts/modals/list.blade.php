<!-- List Modal-->
@php
    if (isset($id)) {
        $listModalId = 'id='.$id.'';
    } else {
        $listModalId = 'id=listModal';
    }
@endphp

<div class="modal fade" {{ $listModalId }} tabindex="-1" role="dialog" aria-labelledby="listModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="" id="deleteForm">
            @method('delete')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    @if (isset($title))
                        <h5 class="modal-title" id="listModalLabel">{{ label($title) }}</h5>
                    @endif

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </form>
    </div>
</div>