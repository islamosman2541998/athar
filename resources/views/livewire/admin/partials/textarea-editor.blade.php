<label for="example-text-input" class="col-sm-2 "> @lang('admin.description_in')  {{ Locale::getDisplayName($locale)}} </label>
<div class="col-sm-10 mb-2">
    <textarea id="description{{ $key }}" wire:model="description.{{ $locale }}" class="form-control description" @if(@$showMode == true) disabled @endif> </textarea>
    @error('description.{{ $locale }}') 
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
@if(@$showMode != true)  
    <script type="text/javascript">
        $(function () {
            CKEDITOR.replace('description{{$key}}');
            $('.textarea').wysihtml5()
        })
    </script>
@endif