@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.font_setting'))

@section('style')
    {{-- Load every option so the preview cards render in their own font --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?{{ collect($arabicFonts + $englishFonts)->map(fn ($font) => 'family=' . $font['google'])->implode('&') }}&display=swap">
    <style>
        .font-settings__group + .font-settings__group { margin-top: 28px; }
        .font-settings__title { display: flex; align-items: center; gap: 10px; margin: 0 0 14px; font-size: 16px; font-weight: 700; }
        .font-settings__title::before { content: ""; width: 4px; height: 18px; border-radius: 4px; background: #1c5949; }
        .font-settings__grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
        @media (max-width: 991px) { .font-settings__grid { grid-template-columns: 1fr; } }

        .font-settings .font-option { position: relative; display: block; margin: 0; cursor: pointer; }
        .font-settings .font-option input[type="radio"] { position: absolute !important; width: 1px !important; height: 1px !important; margin: 0 !important; opacity: 0 !important; pointer-events: none; }
        .font-settings .font-option__card { display: flex; flex-direction: column; gap: 14px; height: 100%; padding: 16px 18px 20px; background: #fff; border: 2px solid #e9ecef; border-radius: 12px; transition: border-color .2s ease, box-shadow .2s ease, background .2s ease; }
        .font-settings .font-option:hover .font-option__card { border-color: #b7c7c2; }
        .font-settings .font-option input:checked + .font-option__card { background: #f4faf7; border-color: #1c5949; box-shadow: 0 0 0 4px rgba(28, 89, 73, .12); }
        .font-settings .font-option input:focus-visible + .font-option__card { outline: 2px solid #1c5949; outline-offset: 3px; }

        .font-settings .font-option__head { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .font-settings .font-option__name { font-size: 13px; font-weight: 700; color: #495057; letter-spacing: .02em; }
        .font-settings .font-option__check { flex: none; width: 20px; height: 20px; display: grid; place-items: center; border: 2px solid #ced4da; border-radius: 50%; transition: .2s ease; }
        .font-settings .font-option input:checked + .font-option__card .font-option__check { background: #1c5949; border-color: #1c5949; }
        .font-settings .font-option input:checked + .font-option__card .font-option__check::after { content: ""; width: 7px; height: 7px; border-radius: 50%; background: #fff; }

        .font-settings .font-option__sample { display: block; min-height: 72px; padding: 12px 14px; font-size: 22px; line-height: 1.6; color: #212529; background: #f8f9fa; border-radius: 8px; overflow-wrap: anywhere; }
        .font-settings .font-option input:checked + .font-option__card .font-option__sample { background: #fff; }
        .font-settings__actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 28px; padding-top: 20px; border-top: 1px solid #e9ecef; }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body font-settings">
                <p class="text-muted mb-4">{{ __('settings.font_hint') }}</p>

                <form action="{{ route('admin.settings.update-custom', $settingMain->key) }}" method="POST">
                    @csrf

                    @foreach ([
                        ['name' => 'font_ar', 'fonts' => $arabicFonts, 'sample' => 'نصنع أثرك الرقمي بإبداع ١٢٣', 'dir' => 'rtl'],
                        ['name' => 'font_en', 'fonts' => $englishFonts, 'sample' => 'We create your digital impact 123', 'dir' => 'ltr'],
                    ] as $group)
                        <div class="font-settings__group">
                            <h5 class="font-settings__title">{{ __('settings.' . $group['name']) }}</h5>
                            <div class="font-settings__grid">
                                @foreach ($group['fonts'] as $value => $font)
                                    <label class="font-option">
                                        <input type="radio" name="{{ $group['name'] }}" value="{{ $value }}"
                                            {{ ($settings[$group['name']] ?? '') === $value ? 'checked' : '' }} required>
                                        <div class="font-option__card">
                                            <div class="font-option__head">
                                                <div class="font-option__name">{{ $font['label'] }}</div>
                                                <div class="font-option__check" aria-hidden="true"></div>
                                            </div>
                                            <div class="font-option__sample" dir="{{ $group['dir'] }}" style="font-family: '{{ $font['family'] }}', sans-serif !important;">{{ $group['sample'] }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="font-settings__actions">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-danger waves-effect waves-light">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-success">@lang('button.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
