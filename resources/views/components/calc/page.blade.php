@props([
    'title' => null,
    'description' => '',
    'lede' => null,
    'calc' => [],
    'faqs' => [],
    'howTo' => [],
    'about' => null,
])

@php
    $catalog = app(\App\Services\CalculatorCatalog::class);
    $found = $catalog->forRoute(request()->route()?->getName());
    $section = $found['section'] ?? \App\Services\CalculatorCatalog::SECTIONS['conversion'];
    $current = $found['tool'] ?? [];
    $category = $found['category'] ?? null;

    $toolTitle = $current['title'] ?? 'Calculator';
    $pageTitle = $title ?? "{$toolTitle} - SolveKit";
    $lede ??= $description;

    $relatedTools = $found ? $catalog->related($section, $current) : collect();

    $faqs = collect($faqs)->filter(fn ($faq) => filled($faq['question'] ?? null) && filled($faq['answer'] ?? null))->values();
    $howTo = collect($howTo)->filter(fn ($step) => filled($step['name'] ?? null) && filled($step['text'] ?? null))->values();
    $hasFormula = isset($formula) && trim((string) $formula) !== '';

    $breadcrumbs = collect([
        ['name' => 'Home', 'item' => url('/')],
        ['name' => $section['title'], 'item' => route($section['index'])],
        $category ? ['name' => $category['title'], 'item' => route($section['index']).'#'.$category['slug']] : null,
        ['name' => $toolTitle, 'item' => url()->current()],
    ])->filter()->values();

    $jsonFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG;

    $schemas = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs->map(fn ($crumb, $index) => ['@type' => 'ListItem', 'position' => $index + 1] + $crumb)->all(),
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $toolTitle,
            'description' => $description,
            'url' => url()->current(),
            'applicationCategory' => 'UtilitiesApplication',
            'operatingSystem' => 'Any',
            'isAccessibleForFree' => true,
            'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
        ],
    ];

    if ($faqs->isNotEmpty()) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
            ])->all(),
        ];
    }

    if ($howTo->isNotEmpty()) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'HowTo',
            'name' => "How to use the {$toolTitle}",
            'step' => $howTo->map(fn ($step, $index) => [
                '@type' => 'HowToStep',
                'position' => $index + 1,
                'name' => $step['name'],
                'text' => $step['text'],
            ])->all(),
        ];
    }
@endphp

<x-app-layout :title="$pageTitle" :description="$description" :showFooter="false">
    @push('head')
        @vite('resources/js/calc/index.js')
        @foreach($schemas as $schema)
            <script type="application/ld+json">{!! json_encode($schema, $jsonFlags) !!}</script>
        @endforeach
    @endpush

    <div class="bg-slate-50" data-calc-root data-calc="{{ json_encode($calc, JSON_UNESCAPED_UNICODE) }}">
        <div class="calc-frame mx-auto max-w-7xl px-4 lg:px-8">
            <header class="flex flex-col gap-1 lg:flex-row lg:items-end lg:justify-between lg:gap-8">
                <div class="min-w-0">
                    @if($category)
                        <p class="text-[13px] font-medium text-slate-500">{{ $category['title'] }}</p>
                    @endif
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $toolTitle }}</h1>
                </div>
                @if(filled($lede))
                    <p class="max-w-xl text-sm text-slate-600 lg:text-right">{{ $lede }}</p>
                @endif
            </header>

            <div class="calc-main">
                <section aria-label="Calculator" class="calc-panel p-5">
                    <form data-calc-form novalidate class="flex h-full flex-col gap-5">
                        {{ $slot }}
                    </form>
                </section>

                <section aria-label="Results" class="calc-panel flex flex-col">
                    {{ $panel ?? '' }}
                </section>
            </div>

            <x-ads type="in-article" placement="tool-after-result" class="lg:hidden" />

            <div class="calc-info">
                <section aria-label="About this tool" class="calc-panel calc-tabs flex flex-col" data-calc-tabs>
                    <div role="tablist" aria-label="About this tool" class="flex shrink-0 gap-1 border-b border-slate-200 px-3">
                        <button type="button" role="tab" id="calc-tab-about" aria-controls="calc-panel-about" aria-selected="true" class="calc-tab">How it works</button>
                        @if($hasFormula)
                            <button type="button" role="tab" id="calc-tab-formula" aria-controls="calc-panel-formula" aria-selected="false" tabindex="-1" class="calc-tab">Formula</button>
                        @endif
                        @if($faqs->isNotEmpty())
                            <button type="button" role="tab" id="calc-tab-faq" aria-controls="calc-panel-faq" aria-selected="false" tabindex="-1" class="calc-tab">FAQ</button>
                        @endif
                    </div>
                    <div class="calc-tab-panels px-5 py-4 text-sm leading-6 text-slate-600">
                        <div role="tabpanel" id="calc-panel-about" aria-labelledby="calc-tab-about" class="space-y-2">
                            @if(isset($aboutContent) && trim((string) $aboutContent) !== '')
                                {{ $aboutContent }}
                            @else
                                <p>{{ $about ?? $description }}</p>
                            @endif
                            @if($howTo->isNotEmpty())
                                <ol class="list-decimal space-y-1 pl-5">
                                    @foreach($howTo as $step)
                                        <li><span class="font-medium text-slate-800">{{ $step['name'] }}.</span> {{ $step['text'] }}</li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                        @if($hasFormula)
                            <div role="tabpanel" id="calc-panel-formula" aria-labelledby="calc-tab-formula" hidden class="space-y-2">
                                {{ $formula }}
                            </div>
                        @endif
                        @if($faqs->isNotEmpty())
                            <div role="tabpanel" id="calc-panel-faq" aria-labelledby="calc-tab-faq" hidden class="divide-y divide-slate-100">
                                @foreach($faqs as $faq)
                                    <details class="group py-2">
                                        <summary class="cursor-pointer font-medium text-slate-800">{{ $faq['question'] }}</summary>
                                        <p class="mt-1">{{ $faq['answer'] }}</p>
                                    </details>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>

                <section aria-label="Related tools" class="calc-panel calc-related flex flex-col gap-3">
                    <h2 class="text-sm font-semibold text-slate-900">Related tools</h2>
                    <nav aria-label="Related tools" class="flex flex-wrap gap-2">
                        @foreach($relatedTools as $tool)
                            <a href="{{ route($tool['route_name']) }}" class="max-w-full shrink-0 rounded-lg border border-slate-200 px-3 py-2 text-[13px] font-medium text-slate-700 hover:border-primary-500 hover:text-primary-700 focus-visible:outline-2 focus-visible:outline-primary-600">{{ $tool['title'] }}</a>
                        @endforeach
                        <a href="{{ route($section['index']) }}" class="shrink-0 rounded-lg px-3 py-2 text-[13px] font-medium text-primary-700 hover:underline focus-visible:outline-2 focus-visible:outline-primary-600">All tools</a>
                    </nav>
                    <x-ads type="display" placement="tool-sidebar" class="mt-auto hidden lg:block" />
                </section>
            </div>

            <p class="sr-only" aria-live="polite" data-calc-announcer></p>
        </div>
    </div>

    <x-ads type="multiplex" placement="tool-bottom" class="mx-auto max-w-7xl px-4 pb-6 lg:px-8" />

    <x-footer />
</x-app-layout>
