@props(['value'])<label {{ $attributes->merge(['style'=>'display:block;font-weight:700;margin-bottom:6px']) }}>{{ $value ?? $slot }}</label>
