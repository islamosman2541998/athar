@php
    $socialSettings = \App\Settings\SettingSingleton::getInstance();
    $socialLinks = collect([
        'facebook' => $socialSettings->getItem('facebook'),
        'instagram' => $socialSettings->getItem('instagram'),
        'linkedin' => $socialSettings->getItem('linked_in') ?: $socialSettings->getItem('linkedin'),
        'youtube' => $socialSettings->getItem('youtube'),
        'x' => $socialSettings->getItem('twitter'),
        'tiktok' => $socialSettings->getItem('tiktok'),
        'snapchat' => $socialSettings->getItem('snapchat'),
    ])->filter();
@endphp
@if($socialLinks->isNotEmpty())
    <div class="socials {{ $wrapperClass ?? '' }}">
        @foreach($socialLinks as $network => $url)
            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($network) }}">@include('site.includes.icon', ['name' => $network, 'class' => ''])</a>
        @endforeach
    </div>
@endif
