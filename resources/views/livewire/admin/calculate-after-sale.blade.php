<div>

    {{-- price ------------------------------------------------------------------------------------- --}}
    <div class="row mb-3">
        <label for="example-text-input"
               class="col-sm-4 col-form-label">{{ trans('products.price')   }}</label>
        <div class="col-sm-8">
            <input class="form-control" type="number" step="any"
                   name="price"
                   wire:keyup="updatePrice"
                   wire:model.defer="price"
                   value="{{ @$model->price ?? old( 'price') }}"
                       >
        </div>
        @error('price')

        <span
                class="missiong-spam">{{$message}}</span>
        @enderror
    </div>


    {{-- sale ------------------------------------------------------------------------------------- --}}
    <div class="row mb-3">
        <label for="example-text-input"
               class="col-sm-4 col-form-label">{{ trans('products.sale')   }}</label>
        <div class="col-sm-8">
            <input class="form-control" type="number" step="any"
                   name="sale"
                   wire:keyup="updatePrice"
                   wire:model.defer="sale"
                   value="{{ @$model->sale ?? old( 'sale') }}"
                       >
                   </div>
        @error('sale')
            <span
                class="missiong-spam">{{ $message}}</span>
        @enderror
    </div>


    {{-- after sale ------------------------------------------------------------------------------------- --}}
    <div class="row mb-3">
        <label for="example-text-input"
               class="col-sm-4 col-form-label">{{ trans('products.price_after_sale')   }}</label>
        <div class="col-sm-8">
            <input class="form-control" type="number" step="any" readonly
                   name="price_after_sale"
                   wire:model.defer="price_after_sale"
                   value="{{ old('price_after_sale') }}">
        </div>
        @error('price_after_sale')
            <span
                class="missiong-spam">{{ $message }}</span>
        @enderror
    </div>


</div>
