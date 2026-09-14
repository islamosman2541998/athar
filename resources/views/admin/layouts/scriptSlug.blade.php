{{-- <div class="row mb-3 slug-section">
    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.' . $locale . '.slug') </label>
    <div class="col-sm-10">
        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug" required>
        @if($errors->has($locale .'.slug'))
            <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
        @endif
    </div>            
</div> --}}
    <script>
        $(document).ready(function(){
            $("#title"+ {{ $key }}).on('keyup', function(){
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g,'-');
                $("#slug"+{{ $key }}).val(Text);
            });

        });
        $(document).ready(function(){
            $("#slug"+ {{ $key }}).on('keyup', function(){
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g,'-');
                $("#slug"+{{ $key }}).val(Text);
            });

        });
    </script>