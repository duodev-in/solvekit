<aside
    aria-label="{{ $label }}"
    data-ad-unit
    data-ad-type="{{ $type }}"
    data-ad-placement="{{ $placement }}"
    {{ $attributes->class(['ad-unit min-w-0']) }}
>
    @if($isLive())
        @pushOnce('head', 'adsense-loader')
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $client() }}" crossorigin="anonymous"></script>
        @endPushOnce

        <span class="ad-unit-label mb-1 text-center text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $label }}</span>
        <ins
            class="ad-unit-pending"
            style="display:block{{ $type === 'in-article' ? '; text-align:center;' : '' }}"
            data-ad-client="{{ $client() }}"
            data-ad-slot="{{ $adSlot() }}"
            @foreach($unitAttributes() as $attribute => $value)
                {{ $attribute }}="{{ $value }}"
            @endforeach
        ></ins>
    @else
        <div class="flex min-h-24 flex-col items-center justify-center rounded-sm border border-dashed border-slate-300 bg-slate-50 p-4 text-center">
            <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $label }}</span>
            <span class="mt-1 text-xs text-slate-500">{{ $type }} &middot; {{ $placement }}</span>
        </div>
    @endif
</aside>
