@props(['status'])@if($status)<div {{ $attributes->merge(['style'=>'padding:12px;border-radius:8px;background:#dff5e9;color:#0a5a40']) }}>{{ $status }}</div>@endif
