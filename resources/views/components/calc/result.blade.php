@props([
    'label' => 'Result',
])

<div data-calc-result data-state="empty" aria-live="polite" class="flex min-w-0 flex-col gap-1.5 rounded-xl border border-primary-100 bg-primary-50 px-5 py-4 data-[state=error]:border-red-200 data-[state=error]:bg-red-50">
    <div class="flex items-center justify-between gap-3">
        <span data-result-label class="text-[13px] font-semibold text-primary-700">{{ $label }}</span>
        <button type="button" data-copy-result class="flex h-8 shrink-0 items-center gap-1.5 rounded-lg border border-primary-100 bg-white px-3 text-[13px] font-semibold text-primary-700 hover:border-primary-500 focus-visible:outline-2 focus-visible:outline-primary-600 data-[copied=true]:border-primary-500">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></svg>
            Copy
        </button>
    </div>
    <p class="min-w-0 font-mono text-[clamp(1.75rem,3.2vw,2.75rem)] leading-tight font-semibold tracking-tight text-slate-900 [overflow-wrap:anywhere] in-data-[long=true]:text-xl in-data-[long=true]:leading-snug in-data-[long=true]:font-medium">
        <span data-result-value class="in-data-[long=true]:whitespace-pre-wrap">—</span>
        <span data-result-unit class="text-[0.5em] font-medium text-slate-500"></span>
    </p>
    <p data-result-sub class="min-w-0 text-sm text-slate-600 [overflow-wrap:anywhere] in-data-[state=error]:text-red-700">Enter a value to see the result.</p>
    {{ $slot }}
</div>
