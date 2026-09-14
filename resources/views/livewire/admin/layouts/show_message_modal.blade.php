    <!-- sample modal content -->
    <div id="show{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">{{ $item->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p> @lang('contact_us.name'): {{ $item->name }}</p>
                    <p> @lang('contact_us.email'): {{ $item->email }}</p>
                    <p> @lang('contact_us.phone'): {{ $item->phone }}</p>
                    <p> @lang('contact_us.message'): {{ $item->message }}</p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>