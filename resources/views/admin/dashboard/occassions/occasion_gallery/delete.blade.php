<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('admin.delete_item')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- <div class="swal2-icon-content text-warning h1">!</div> --}}
            <h2 class="swal2-title" id="swal2-title" style="display: flex;">  @lang('admin.are_you_sure')</h2>
        <div class="modal-footer" >
            <form  action="{{ route('admin.occasion_gallery.destroy' ,[ 'occ_id' => $occ_id , 'id' => $item->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.no')</button>
                <button type="submit" class="btn btn-danger">@lang('admin.yes')</button>
            </form>
        </div>
    </div>
    </div>
</div>
