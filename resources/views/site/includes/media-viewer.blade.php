<dialog class="media-viewer" data-media-viewer aria-label="{{ app()->getLocale() === 'ar' ? 'عارض الميديا' : 'Media viewer' }}">
    <div class="media-viewer__panel">
        <button class="media-viewer__close" type="button" data-media-close aria-label="{{ app()->getLocale() === 'ar' ? 'إغلاق' : 'Close' }}">×</button>
        <video class="media-viewer__video" data-media-video controls playsinline preload="metadata" hidden></video>
        <iframe class="media-viewer__pdf" data-media-pdf title="PDF" loading="lazy" hidden></iframe>
        <iframe class="media-viewer__embed" data-media-embed title="{{ __('athar.media.play') }}" loading="lazy"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen hidden></iframe>
    </div>
</dialog>
