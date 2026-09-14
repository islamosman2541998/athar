<div>
    {{-- The Master doesn't talk, he acts. --}}
    <h1>{{ $message }}</h1>


    {{-- title ------------------------------------------------------------------------------------- --}}
    <div class="row mb-3">
        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
        <div class="col-sm-10">
            <input class="form-control" required type="text" wire:keyup="updateSlug" wire:model="title" name="{{ $locale }}[title]" value="{{ $model->trans[0]->title ??  old($locale . '.title') }}"  >
        </div>
        @if ($errors->has($locale . '.title'))
        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
        @endif
    </div>



    {{-- slug ------------------------------------------------------------------------------------- --}}
    <div class="row mb-3">
        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.slug') .  trans('lang.' .Locale::getDisplayName(@$locale)) }}</label>
        <div class="col-sm-10">
            <input class="form-control"   name="{{ @$locale }}[slug]" wire:model="slug" type="text" value="{{  $model->trans[0]->slug ??  old($locale . '.slug')}}" value="{{$slug}}">
        </div>
        @if ($errors->has($locale . '.slug'))
        <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
        @endif
    </div>

</div>
