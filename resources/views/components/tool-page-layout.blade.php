@props([
    'title' => 'Tool Calculator',
    'description' => '',
    'subtitle' => null,
    'faqSchema' => [],
    'howToSchema' => [],
])

@php
$routeName = request()->route()?->getName();
$categories = config('conversion.categories', []);
$calculatorMap = config('conversion.calculators', []);

$currentCalculator = null;
foreach ($calculatorMap as $calculatorConfig) {
    if (($calculatorConfig['route_name'] ?? null) === $routeName) {
        $currentCalculator = $calculatorConfig;
        break;
    }
}

$toolTitle = (is_string($currentCalculator['title'] ?? null) && trim($currentCalculator['title']) !== '')
    ? trim($currentCalculator['title'])
    : trim((string) $title);

$toolDescription = trim((string) $description);
$toolSubtitle = is_string($subtitle) && trim($subtitle) !== ''
    ? trim($subtitle)
    : ($toolDescription !== '' ? $toolDescription : 'Use this professional tool for accurate and fast calculations.');

$categoryTitle = null;
$categorySlug = $currentCalculator['category_slug'] ?? null;
if (is_string($categorySlug) && $categorySlug !== '') {
    foreach ($categories as $category) {
        if (($category['slug'] ?? null) === $categorySlug) {
            $categoryTitle = $category['title'] ?? null;
            break;
        }
    }
}

$isPhaseOne = $categorySlug === 'length-and-area-conversions';
$isPhaseTwo = $categorySlug === 'volume-and-weight-conversions';
$isPhaseThree = $categorySlug === 'engineering-and-technical-conversions';
$isPhaseFour = $categorySlug === 'geographic-and-mapping-tools';
$isPhaseFive = $categorySlug === 'number-conversion-tools';
$isPhaseSix = $categorySlug === 'number-system-conversion-tools';
$isPhaseSeven = $categorySlug === 'data-and-technical-conversion-tools';
$isPhaseEight = $categorySlug === 'speed-and-motion-conversion-tools';
$isPhaseNine = $categorySlug === 'specialized-measurement-conversion-tools';
$isEnergyPowerPhase = $categorySlug === 'energy-and-power-conversion-tools';
$isCurrencyFinancialPhase = $categorySlug === 'currency-and-financial-conversion-tools';
$isDigitalTechnicalPhase = $categorySlug === 'digital-and-technical-conversion-tools';
$isUtilityGeneralPhase = $categorySlug === 'utility-and-general-conversion-tools';
$isTimeDatePhase = $categorySlug === 'time-and-date-conversion-tools';
$isNormalizedPhase = $isPhaseOne || $isPhaseTwo || $isPhaseThree || $isPhaseFour || $isPhaseFive || $isPhaseSix || $isPhaseSeven || $isPhaseEight || $isPhaseNine || $isEnergyPowerPhase || $isCurrencyFinancialPhase || $isDigitalTechnicalPhase || $isUtilityGeneralPhase || $isTimeDatePhase;

$breadcrumbs = [
    ['label' => 'Home', 'url' => url('/')],
    ['label' => 'Conversion Tools', 'url' => route('conversion.index')],
];

if (is_string($categoryTitle) && trim($categoryTitle) !== '') {
    $breadcrumbs[] = [
        'label' => trim($categoryTitle),
        'url' => route('conversion.index'),
    ];
}

$breadcrumbs[] = ['label' => $toolTitle];

$toolUiContent = isset($toolUi) ? $toolUi : $slot;
$aboutContentSlot = isset($aboutContent) ? $aboutContent : null;
$showLegacyAboutContent = $aboutContentSlot && ! $isNormalizedPhase;
$relatedTools = collect($calculatorMap)
    ->filter(function ($tool) use ($currentCalculator, $routeName): bool {
        return is_array($tool)
            && ($tool['route_name'] ?? null) !== $routeName
            && ($tool['category_slug'] ?? null) === ($currentCalculator['category_slug'] ?? null)
            && is_string($tool['route_name'] ?? null)
            && \Illuminate\Support\Facades\Route::has($tool['route_name']);
    })
    ->take(3)
    ->values()
    ->all();

$breadcrumbSchemaItems = [];
foreach ($breadcrumbs as $index => $item) {
    $label = $item['label'] ?? null;

    if (!is_string($label) || trim($label) === '') {
        continue;
    }

    $itemUrl = $item['url'] ?? null;
    if (!is_string($itemUrl) || trim($itemUrl) === '') {
        $itemUrl = url()->current();
    }

    $breadcrumbSchemaItems[] = [
        '@type' => 'ListItem',
        'position' => count($breadcrumbSchemaItems) + 1,
        'name' => trim($label),
        'item' => $itemUrl,
    ];
}

$webApplicationSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => $toolTitle,
    'description' => $toolDescription !== '' ? $toolDescription : ('Use ' . $toolTitle . ' for accurate online calculations.'),
    'url' => url()->current(),
    'applicationCategory' => 'UtilitiesApplication',
    'operatingSystem' => 'Any',
    'isAccessibleForFree' => true,
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
    ],
];

$faqSchemaPayload = [];
if (is_array($faqSchema)) {
    foreach ($faqSchema as $item) {
        $question = is_array($item) ? ($item['question'] ?? null) : null;
        $answer = is_array($item) ? ($item['answer'] ?? null) : null;

        if (!is_string($question) || trim($question) === '' || !is_string($answer) || trim($answer) === '') {
            continue;
        }

        $faqSchemaPayload[] = [
            '@type' => 'Question',
            'name' => trim($question),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => trim($answer),
            ],
        ];
    }
}

$howToSchemaPayload = [];
if (is_array($howToSchema)) {
    foreach ($howToSchema as $index => $step) {
        $name = is_array($step) ? ($step['name'] ?? null) : null;
        $text = is_array($step) ? ($step['text'] ?? null) : null;

        if (!is_string($name) || trim($name) === '' || !is_string($text) || trim($text) === '') {
            continue;
        }

        $howToSchemaPayload[] = [
            '@type' => 'HowToStep',
            'position' => $index + 1,
            'name' => trim($name),
            'text' => trim($text),
        ];
    }
}
@endphp

<x-app-layout :title="$title" :description="$description" :showFooter="false">
    <style>
        #toolUiRoot :where(label) {
            font-size: 0.8125rem;
            line-height: 1.15rem;
        }

        #toolUiRoot :where(input:not([type='checkbox']):not([type='radio']), select, textarea) {
            padding: 0.48rem 0.72rem !important;
            font-size: 0.84rem !important;
            line-height: 1.2rem !important;
            border-width: 1px !important;
            border-color: #cbd5e1 !important;
        }

        #toolUiRoot :where(button) {
            padding: 0.48rem 0.72rem !important;
            font-size: 0.8rem !important;
            line-height: 1.1rem !important;
            border-width: 1px !important;
        }

        #toolUiRoot :where(input, select, textarea, button):focus {
            outline: none !important;
            box-shadow: none !important;
        }

        #toolUiRoot :where(.focus-within\:ring-2):focus-within {
            box-shadow: none !important;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .rounded-md,
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .rounded-lg,
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .bg-white {
            background-color: transparent;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool) .text-indigo-700,
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool) .text-indigo-800 {
            color: var(--color-primary-600);
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool) .bg-indigo-50,
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool) .bg-indigo-100 {
            background-color: var(--color-primary-50);
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [id="calculatorForm"] {
            max-width: none;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .font-serif[id],
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .font-mono[id],
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [id$="Output"],
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [id="output"],
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [id="convertedTorque"],
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [id="displayRpm"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [class*="rounded-lg"],
        #toolUiRoot:is(.phase-one-tool, .phase-two-tool, .phase-three-tool, .phase-four-tool) [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot:is(.phase-three-tool, .phase-four-tool) #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.phase-five-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.phase-five-tool .rounded-md,
        #toolUiRoot.phase-five-tool .rounded-lg,
        #toolUiRoot.phase-five-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.phase-five-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.phase-five-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.phase-five-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.phase-five-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.phase-five-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.phase-five-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.phase-five-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-five-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.phase-five-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.phase-five-tool .font-serif[id],
        #toolUiRoot.phase-five-tool .font-mono[id],
        #toolUiRoot.phase-five-tool [id$="Output"],
        #toolUiRoot.phase-five-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.phase-five-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.phase-five-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-five-tool [class*="rounded-lg"],
        #toolUiRoot.phase-five-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.phase-five-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.phase-six-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.phase-six-tool .rounded-md,
        #toolUiRoot.phase-six-tool .rounded-lg,
        #toolUiRoot.phase-six-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.phase-six-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.phase-six-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.phase-six-tool > :first-child > :first-child :is(h1, h2),
        #toolUiRoot.phase-six-tool > :first-child > :first-child p {
            color: #ffffff;
        }

        #toolUiRoot.phase-six-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.phase-six-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.phase-six-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-six-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.phase-six-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.phase-six-tool .font-serif[id],
        #toolUiRoot.phase-six-tool .font-mono[id],
        #toolUiRoot.phase-six-tool [id$="Display"],
        #toolUiRoot.phase-six-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1rem, 3vw, 1.75rem);
            line-height: 1.1;
        }

        #toolUiRoot.phase-six-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.phase-six-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-six-tool [class*="rounded-lg"],
        #toolUiRoot.phase-six-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.phase-six-tool #calculatorForm + section > :nth-child(2) {
            display: none;
        }

        #toolUiRoot.phase-seven-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.phase-seven-tool .rounded-md,
        #toolUiRoot.phase-seven-tool .rounded-lg,
        #toolUiRoot.phase-seven-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.phase-seven-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.phase-seven-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.phase-seven-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.phase-seven-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.phase-seven-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.phase-seven-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.phase-seven-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-seven-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.phase-seven-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.phase-seven-tool .font-serif[id],
        #toolUiRoot.phase-seven-tool .font-mono[id],
        #toolUiRoot.phase-seven-tool [id$="Display"],
        #toolUiRoot.phase-seven-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.phase-seven-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.phase-seven-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-seven-tool [class*="rounded-lg"],
        #toolUiRoot.phase-seven-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.phase-seven-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.phase-eight-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.phase-eight-tool .rounded-md,
        #toolUiRoot.phase-eight-tool .rounded-lg,
        #toolUiRoot.phase-eight-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.phase-eight-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.phase-eight-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.phase-eight-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.phase-eight-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.phase-eight-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.phase-eight-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.phase-eight-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-eight-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.phase-eight-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.phase-eight-tool .font-serif[id],
        #toolUiRoot.phase-eight-tool .font-mono[id],
        #toolUiRoot.phase-eight-tool [id$="Display"],
        #toolUiRoot.phase-eight-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.phase-eight-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.phase-eight-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-eight-tool [class*="rounded-lg"],
        #toolUiRoot.phase-eight-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.phase-eight-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.phase-nine-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.phase-nine-tool .rounded-md,
        #toolUiRoot.phase-nine-tool .rounded-lg,
        #toolUiRoot.phase-nine-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.phase-nine-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.phase-nine-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.phase-nine-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.phase-nine-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.phase-nine-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.phase-nine-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.phase-nine-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-nine-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.phase-nine-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.phase-nine-tool .font-serif[id],
        #toolUiRoot.phase-nine-tool .font-mono[id],
        #toolUiRoot.phase-nine-tool [id$="Display"],
        #toolUiRoot.phase-nine-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.phase-nine-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.phase-nine-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.phase-nine-tool [class*="rounded-lg"],
        #toolUiRoot.phase-nine-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.phase-nine-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.energy-power-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.energy-power-tool .rounded-md,
        #toolUiRoot.energy-power-tool .rounded-lg,
        #toolUiRoot.energy-power-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.energy-power-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.energy-power-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.energy-power-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.energy-power-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.energy-power-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.energy-power-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.energy-power-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.energy-power-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.energy-power-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.energy-power-tool .font-serif[id],
        #toolUiRoot.energy-power-tool .font-mono[id],
        #toolUiRoot.energy-power-tool [id$="Display"],
        #toolUiRoot.energy-power-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.energy-power-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.energy-power-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.energy-power-tool [class*="rounded-lg"],
        #toolUiRoot.energy-power-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.energy-power-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.currency-financial-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.currency-financial-tool .rounded-md,
        #toolUiRoot.currency-financial-tool .rounded-lg,
        #toolUiRoot.currency-financial-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.currency-financial-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.currency-financial-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.currency-financial-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.currency-financial-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.currency-financial-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.currency-financial-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.currency-financial-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.currency-financial-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.currency-financial-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.currency-financial-tool .font-serif[id],
        #toolUiRoot.currency-financial-tool .font-mono[id],
        #toolUiRoot.currency-financial-tool [id$="Display"],
        #toolUiRoot.currency-financial-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.currency-financial-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.currency-financial-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.currency-financial-tool [class*="rounded-lg"],
        #toolUiRoot.currency-financial-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.currency-financial-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.digital-technical-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.digital-technical-tool .rounded-md,
        #toolUiRoot.digital-technical-tool .rounded-lg,
        #toolUiRoot.digital-technical-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.digital-technical-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.digital-technical-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.digital-technical-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.digital-technical-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.digital-technical-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.digital-technical-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.digital-technical-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.digital-technical-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.digital-technical-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.digital-technical-tool .font-serif[id],
        #toolUiRoot.digital-technical-tool .font-mono[id],
        #toolUiRoot.digital-technical-tool [id$="Display"],
        #toolUiRoot.digital-technical-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.digital-technical-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.digital-technical-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.digital-technical-tool [class*="rounded-lg"],
        #toolUiRoot.digital-technical-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.digital-technical-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.utility-general-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.utility-general-tool .rounded-md,
        #toolUiRoot.utility-general-tool .rounded-lg,
        #toolUiRoot.utility-general-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.utility-general-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.utility-general-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.utility-general-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.utility-general-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.utility-general-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.utility-general-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.utility-general-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.utility-general-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.utility-general-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.utility-general-tool .font-serif[id],
        #toolUiRoot.utility-general-tool .font-mono[id],
        #toolUiRoot.utility-general-tool [id$="Display"],
        #toolUiRoot.utility-general-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.utility-general-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.utility-general-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.utility-general-tool [class*="rounded-lg"],
        #toolUiRoot.utility-general-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.utility-general-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.time-date-tool .shadow-sm {
            box-shadow: none;
        }

        #toolUiRoot.time-date-tool .rounded-md,
        #toolUiRoot.time-date-tool .rounded-lg,
        #toolUiRoot.time-date-tool .rounded-xl {
            border-radius: 0.125rem;
        }

        #toolUiRoot.time-date-tool .bg-white {
            background-color: transparent;
        }

        #toolUiRoot.time-date-tool > :first-child > :first-child {
            background: #0f172a;
            border-color: #1e293b;
            color: #ffffff;
        }

        #toolUiRoot.time-date-tool > :first-child > :first-child :is(h1, h2) {
            color: #ffffff;
        }

        #toolUiRoot.time-date-tool [class*="bg-slate-50"] {
            background-color: #f8fafc;
        }

        #toolUiRoot.time-date-tool [class*="lg:grid-cols-"] {
            display: block;
        }

        #toolUiRoot.time-date-tool [class*="lg:col-span-"] {
            width: 100%;
        }

        #toolUiRoot.time-date-tool [class*="lg:col-span-"] + [class*="lg:col-span-"] {
            margin-top: 1rem;
        }

        #toolUiRoot.time-date-tool #calculatorForm {
            max-width: none;
        }

        #toolUiRoot.time-date-tool #calculatorForm label {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #toolUiRoot.time-date-tool .font-serif[id],
        #toolUiRoot.time-date-tool .font-mono[id],
        #toolUiRoot.time-date-tool [id$="Display"],
        #toolUiRoot.time-date-tool [id="output"] {
            min-width: 0;
            max-width: 100%;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-size: clamp(1.25rem, 4vw, 2rem);
            line-height: 1.1;
        }

        #toolUiRoot.time-date-tool .text-right {
            min-width: 0;
            max-width: 100%;
        }

        #toolUiRoot.time-date-tool .mt-8 {
            margin-top: 1rem;
        }

        #toolUiRoot.time-date-tool [class*="rounded-lg"],
        #toolUiRoot.time-date-tool [class*="rounded-xl"] {
            box-shadow: none;
        }

        #toolUiRoot.time-date-tool [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.phase-four-tool #calculatorForm > * {
            min-width: 0;
        }

        #toolUiRoot.phase-four-tool #calculatorForm [class*="grid-cols-"] {
            min-width: 0;
        }

        #toolUiRoot.phase-three-tool [class~="lg:col-span-7"] > [class~="mt-8"] {
            margin-top: 0;
        }

        #toolUiRoot.phase-three-tool [class~="lg:col-span-7"] > [class~="mt-8"] > [class~="grid"] {
            display: none;
        }

        #toolUiRoot.phase-three-tool [class~="lg:col-span-7"] > [class~="mt-8"] > [class*="bg-gradient"] {
            padding: 0.625rem;
            border-left-width: 0;
            border-radius: 0.125rem;
            background: #f8fafc;
        }

        @media (min-width: 768px) {
            #toolUiRoot.phase-three-tool #calculatorForm {
                display: grid;
                grid-template-columns: repeat(12, minmax(0, 1fr));
                align-items: start;
                column-gap: 1rem;
                row-gap: 0.75rem;
            }

            #toolUiRoot.phase-three-tool #calculatorForm > * {
                grid-column: span 3;
                min-width: 0;
            }

            #toolUiRoot.phase-three-tool #calculatorForm > :has(> .grid > div > select) {
                display: contents;
            }

            #toolUiRoot.phase-three-tool #calculatorForm > :has(input[type="radio"]),
            #toolUiRoot.phase-three-tool #calculatorForm > :has(> button) {
                grid-column: 1 / -1;
            }

            #toolUiRoot.phase-three-tool #calculatorForm > :has(input[type="radio"]) > .grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            #toolUiRoot.phase-three-tool #calculatorForm > :has(> button) {
                justify-content: flex-start;
            }
        }

        @media (min-width: 1024px) {
            .tool-right-scroll {
                scroll-behavior: smooth;
                scrollbar-width: thin;
                scrollbar-color: #94a3b8 transparent;
                scrollbar-gutter: stable both-edges;
            }

            .tool-right-scroll::-webkit-scrollbar {
                width: 6px;
            }

            .tool-right-scroll::-webkit-scrollbar-track {
                background: transparent;
            }

            .tool-right-scroll::-webkit-scrollbar-thumb {
                border-radius: 9999px;
                border: 1px solid transparent;
                background: linear-gradient(180deg, #94a3b8 0%, #64748b 100%);
            }

            .tool-right-scroll::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(180deg, #64748b 0%, #475569 100%);
            }
        }

        @media (min-width: 1024px) {
            body.tool-layout-lock {
                overflow-x: hidden;
            }

            .tool-layout-viewport {
                min-height: calc(100dvh - var(--cp-nav-height, 0px) - var(--cp-breadcrumb-height, 0px));
                height: auto;
                overflow: visible;
            }

            .tool-layout-grid {
                min-height: calc(100dvh - var(--cp-nav-height, 0px) - var(--cp-breadcrumb-height, 0px));
                height: auto;
                overflow: visible;
            }
        }
        #quickReferenceTarget [class*="grid-cols-"] {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        #quickReferenceTarget :where(p, span, div, li, dt, dd) {
            min-width: 0;
            overflow-wrap: anywhere;
        }
    </style>


    <section class="tool-layout-viewport bg-slate-50 py-2 sm:py-3 lg:py-1">
        <div class="mx-auto h-full max-w-7xl px-3 sm:px-4 lg:px-6">
            <div class="tool-layout-grid grid h-full gap-4 lg:min-h-0 lg:grid-cols-12 lg:grid-rows-[minmax(0,1fr)] lg:items-stretch">
                <div class="space-y-3 lg:col-span-8 lg:h-auto lg:min-h-0 lg:sticky lg:top-[calc(var(--cp-nav-height,4rem)+1rem)] lg:self-start">
                        <section id="toolUiRoot" aria-label="Tool Interface" class="tool-ui-shell tool-ui-compact {{ $isPhaseOne ? 'phase-one-tool' : '' }} {{ $isPhaseTwo ? 'phase-two-tool' : '' }} {{ $isPhaseThree ? 'phase-three-tool' : '' }} {{ $isPhaseFour ? 'phase-four-tool' : '' }} {{ $isPhaseFive ? 'phase-five-tool' : '' }} {{ $isPhaseSix ? 'phase-six-tool' : '' }} {{ $isPhaseSeven ? 'phase-seven-tool' : '' }} {{ $isPhaseEight ? 'phase-eight-tool' : '' }} {{ $isPhaseNine ? 'phase-nine-tool' : '' }} {{ $isEnergyPowerPhase ? 'energy-power-tool' : '' }} {{ $isCurrencyFinancialPhase ? 'currency-financial-tool' : '' }} {{ $isDigitalTechnicalPhase ? 'digital-technical-tool' : '' }} {{ $isUtilityGeneralPhase ? 'utility-general-tool' : '' }} {{ $isTimeDatePhase ? 'time-date-tool' : '' }} rounded-sm bg-white p-2.5 shadow-sm sm:p-3">
                        {{ $toolUiContent }}
                    </section>

                    <x-ads type="in-article" placement="tool-after-result" class="lg:hidden" />
                </div>

                <div class="tool-right-scroll space-y-4 lg:col-span-4 lg:h-full lg:min-h-0 lg:self-stretch lg:overflow-y-auto lg:pr-1">
                    <section id="quickReferenceColumn" aria-label="Quick Reference" class="hidden rounded-sm bg-white p-3 shadow-sm">
                        <h2 class="mb-3 text-base font-semibold text-slate-900">Quick Reference</h2>
                        <div id="quickReferenceTarget" class="space-y-4"></div>
                    </section>

                    <section aria-label="About This Tool" class="rounded-sm border border-slate-200 bg-white p-3 shadow-sm sm:p-4">
                        <x-tool-content
                            :title="$toolTitle"
                            :description="$toolDescription"
                            :category-title="$categoryTitle"
                            :related-tools="$relatedTools"
                        />
                    </section>

                    @if($showLegacyAboutContent)
                        <section aria-label="Tool reference notes" class="rounded-sm border border-slate-200 bg-white p-3 shadow-sm sm:p-4">
                            <div id="aboutContentStack" class="space-y-4">
                                {{ $aboutContentSlot }}
                            </div>
                        </section>
                    @endif

                    <x-ads type="display" placement="tool-sidebar" class="hidden lg:block" />
                </div>
            </div>
        </div>
    </section>

    <x-ads type="multiplex" placement="tool-bottom" class="mx-auto max-w-7xl px-3 pb-6 sm:px-4 lg:px-6" />

    <x-footer />

    <x-slot name="scripts">
        @if(isset($scripts) && trim((string) $scripts) !== '')
            {{ $scripts }}
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const syncToolLayoutViewport = function () {
                    const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
                    const nav = document.querySelector('header.sticky.top-0.z-40');
                    const breadcrumb = document.querySelector('nav[aria-label="Breadcrumb"]');

                    const navHeight = nav ? nav.offsetHeight : 0;
                    const breadcrumbHeight = breadcrumb ? breadcrumb.offsetHeight : 0;

                    document.documentElement.style.setProperty('--cp-nav-height', navHeight + 'px');
                    document.documentElement.style.setProperty('--cp-breadcrumb-height', breadcrumbHeight + 'px');

                    if (isDesktop) {
                        document.body.classList.add('tool-layout-lock');
                    } else {
                        document.body.classList.remove('tool-layout-lock');
                    }
                };

                syncToolLayoutViewport();
                window.addEventListener('resize', syncToolLayoutViewport);

                const toolUiRoot = document.getElementById('toolUiRoot');
                const aboutContentStack = document.getElementById('aboutContentStack');
                const isVolumeWeightPage = window.location.pathname.includes('/volume-and-weight-conversions/');
                const isEngineeringTechnicalPage = window.location.pathname.includes('/engineering-and-technical-conversions/');
                const isGeographicMappingPage = window.location.pathname.includes('/geographic-and-mapping-tools/');
                const isNumberConversionToolsPage = window.location.pathname.includes('/number-conversion-tools/');
                const isDataTechnicalPage = window.location.pathname.includes('/data-and-technical-conversion-tools/');
                const isTimeDatePage = window.location.pathname.includes('/time-and-date-conversion-tools/');
                const isGeographicScaleCalculatorPage = window.location.pathname.includes('/geographic-and-mapping-tools/scale-calculator');
                const hasEnhancedConvertedValues = isVolumeWeightPage || isEngineeringTechnicalPage || isGeographicMappingPage || isNumberConversionToolsPage || isDataTechnicalPage || isTimeDatePage;

                const isCtrlMShortcut = function (e) {
                    const key = typeof e.key === 'string' ? e.key.toLowerCase() : '';
                    return e.ctrlKey && key === 'm';
                };

                const isCtrlShiftCClearShortcut = function (e) {
                    const key = typeof e.key === 'string' ? e.key.toLowerCase() : '';
                    return e.ctrlKey && e.shiftKey && key === 'c';
                };

                if (hasEnhancedConvertedValues && toolUiRoot && aboutContentStack) {
                    const inferConvertedValueSubtitle = function (titleText) {
                        const text = (titleText || '').toLowerCase().trim();

                        if (text.includes('total')) {
                            return 'Combined measurement';
                        }

                        if (text.includes('weight') || text.includes('mass')) {
                            return 'Calculated weight';
                        }

                        if (text.includes('volume')) {
                            return 'Calculated volume';
                        }

                        if (text.includes('density')) {
                            return 'Reference value';
                        }

                        if (text.includes('cups') || text.includes('ounces') || text.includes('teaspoons') || text.includes('tablespoons')) {
                            return 'Kitchen equivalent';
                        }

                        if (text.includes('liters') || text.includes('meters') || text.includes('grams') || text.includes('kilograms')) {
                            return 'Metric equivalent';
                        }

                        return 'Converted measurement';
                    };

                    const inferUnitLabel = function (titleText, valueId) {
                        const key = ((titleText || '') + ' ' + (valueId || '')).toLowerCase();

                        if (key.includes('fluid ounce') || key.includes('floz')) return 'fl oz';
                        if (key.includes('teaspoon') || key.includes('tsp')) return 'tsp';
                        if (key.includes('tablespoon') || key.includes('tbsp')) return 'tbsp';
                        if (key.includes('cubic meter') || key.includes('m3')) return 'm³';
                        if (key.includes('cubic feet') || key.includes('ft3')) return 'ft³';
                        if (key.includes('millilit') || key.includes('ml')) return 'mL';
                        if (key.includes('decilit') || key.includes('dl')) return 'dL';
                        if (key.includes('centilit') || key.includes('cl')) return 'cL';
                        if (key.includes('kilolit') || key.includes('kl')) return 'kL';
                        if (key.includes('liter') || key.includes('litre')) return 'L';
                        if (key.includes('kilogram') || key.includes('kg')) return 'kg';
                        if (key.includes('milligram') || key.includes('mg')) return 'mg';
                        if (key.includes('microgram') || key.includes('mcg')) return 'mcg';
                        if (key.includes('nanogram') || key.includes('ng')) return 'ng';
                        if (key.includes('gram') || key.includes('gramsoutput')) return 'g';
                        if (key.includes('quart') || key.includes('qt')) return 'qt';
                        if (key.includes('pint') || key.includes('pt')) return 'pt';
                        if (key.includes('gallon') || key.includes('gal')) return 'gal';
                        if (key.includes('ounces') || key.includes('oz')) return 'oz';
                        if (key.includes('ton') || key.includes('tonne') || key.includes('toutput')) return 't';
                        if (key.includes('stone')) return 'st';
                        if (key.includes('cups') || key.includes('cup')) return 'cups';
                        if (key.includes('kilonewton') || key.includes('kn')) return 'kN';
                        if (key.includes('newton') || key.includes('noutput')) return 'N';
                        if (key.includes('pound-force') || key.includes('lbf')) return 'lbf';
                        if (key.includes('kilogram-force') || key.includes('kgf')) return 'kgf';
                        if (key.includes('dyne') || key.includes('dyn')) return 'dyn';
                        if (key.includes('kip')) return 'kip';
                        if (key.includes('horsepower') || key.includes('hp')) return 'HP';
                        if (key.includes('kilowatt') || key.includes('kw')) return 'kW';
                        if (key.includes('watt') || key.includes('watts')) return 'W';
                        if (key.includes('psi')) return 'psi';
                        if (key.includes('pascal')) return 'Pa';
                        if (key.includes('torr')) return 'Torr';
                        if (key.includes('atm')) return 'atm';
                        if (key.includes('bar')) return 'bar';
                        if (key.includes('gpm')) return 'GPM';
                        if (key.includes('lpm')) return 'LPM';
                        if (key.includes('cfs')) return 'CFS';
                        if (key.includes('cms')) return 'CMS';
                        if (key.includes('gph')) return 'GPH';
                        if (key.includes('lps')) return 'LPS';
                        if (key.includes('ftlb') || key.includes('ft-lb') || key.includes('lbf·ft')) return 'ft-lbs';
                        if (key.includes('inlb') || key.includes('in-lb') || key.includes('lbf·in')) return 'in-lbs';
                        if (key.includes('n·m') || key.includes('nmoutput')) return 'N·m';

                        return '';
                    };

                    const convertedValueSelector = ':scope .font-serif[id], :scope [id].font-serif, :scope .font-mono[id], :scope [id].font-mono, :scope [id$="Output"], :scope [id="output"]';
                    const centeredConvertedValueSelector = ':scope > .font-serif[id], :scope > [id].font-serif, :scope > .font-mono[id], :scope > [id].font-mono, :scope > [id$="Output"], :scope > [id="output"]';
                    const directConvertedValueSelector = ':scope > .font-serif[id], :scope > [id].font-serif, :scope > .font-mono[id], :scope > [id].font-mono, :scope > [id$="Output"], :scope > [id="output"]';

                    const moveInlineUnitToLabel = function (valueElement, unitElement, fallbackUnit) {
                        const text = (valueElement.textContent || '').trim();

                        if (text === '' || text === '--') {
                            unitElement.textContent = fallbackUnit;
                            return;
                        }

                        const unitMatch = text.match(/^(.+?)\s+([a-zA-Z0-9µ°/%²³·⋅-]+(?:\s+[a-zA-Z0-9µ°/%²³·⋅-]+)*)$/);
                        if (!unitMatch) {
                            unitElement.textContent = fallbackUnit;
                            return;
                        }

                        const numberPart = unitMatch[1].trim();
                        const parsedUnit = unitMatch[2].trim();

                        if (numberPart === '' || parsedUnit === '') {
                            unitElement.textContent = fallbackUnit;
                            return;
                        }

                        valueElement.textContent = numberPart;
                        unitElement.textContent = parsedUnit;
                    };

                    const getConvertedValueCards = function (section) {
                        return Array.from(section.querySelectorAll('div')).filter((card) => {
                            const centeredBody = card.querySelector(':scope > .text-center');
                            const rowBody = card.querySelector(':scope > .flex.items-center.justify-between');
                            const body = centeredBody || rowBody;

                            if (!body) {
                                return false;
                            }

                            const title = body.querySelector(':scope h4');
                            const value = body.querySelector(convertedValueSelector) || card.querySelector(directConvertedValueSelector);

                            return !!(title && value);
                        });
                    };

                    const getConvertedValueSections = function () {
                        return Array.from(toolUiRoot.querySelectorAll('div.mt-8.space-y-4')).filter((section) => {
                            const heading = section.querySelector(':scope > h3');
                            const headingText = (heading?.textContent || '').toLowerCase();
                            return heading && (headingText.includes('converted values') || headingText.includes('results'));
                        });
                    };

                    const getCardCopyMeta = function (card) {
                        const rowBody = card.querySelector(':scope > .flex.items-center.justify-between');
                        const centeredBody = card.querySelector(':scope > .text-center');
                        const body = rowBody || centeredBody || card;

                        const titleElement = body.querySelector(':scope h4');
                        const subtitleElement = body.querySelector(':scope p') || card.querySelector(':scope > .text-xs');
                        const valueElement = body.querySelector(convertedValueSelector) || card.querySelector(directConvertedValueSelector);

                        if (!titleElement || !valueElement) {
                            return null;
                        }

                        const unitElement = rowBody
                            ? rowBody.querySelector(':scope > .text-right > .text-xs.text-slate-500.font-medium')
                            : (body.querySelector(':scope .text-xs.text-slate-500.font-medium') || card.querySelector(':scope > .text-xs.text-slate-500.font-medium'));

                        return {
                            titleElement,
                            subtitleElement,
                            valueElement,
                            unitElement,
                        };
                    };

                    const splitValueAndUnit = function (valueText, fallbackUnit) {
                        const value = (valueText || '').trim();
                        const unit = (fallbackUnit || '').trim();

                        if (value === '' || value === '--') {
                            return {
                                value,
                                unit,
                            };
                        }

                        if (unit !== '' && !value.toLowerCase().endsWith(unit.toLowerCase())) {
                            return {
                                value,
                                unit,
                            };
                        }

                        if (unit !== '') {
                            const suffixPattern = new RegExp('\\\\s+' + unit.replace(/[.*+?^${}()|[\\]\\]/g, '\\\\$&') + '$', 'i');
                            const stripped = value.replace(suffixPattern, '').trim();

                            return {
                                value: stripped === '' ? value : stripped,
                                unit,
                            };
                        }

                        const parsed = value.match(/^(.+?)\s+([a-zA-Z0-9µ°/%²³·⋅-]+(?:\s+[a-zA-Z0-9µ°/%²³·⋅-]+)*)$/);
                        if (!parsed) {
                            return {
                                value,
                                unit,
                            };
                        }

                        return {
                            value: parsed[1].trim(),
                            unit: parsed[2].trim(),
                        };
                    };

                    const buildCopyPayload = function (meta) {
                        const titleText = (meta.titleElement.textContent || '').trim();
                        const valueText = (meta.valueElement.textContent || '').trim();
                        const unitText = meta.unitElement ? (meta.unitElement.textContent || '').trim() : '';
                        const parts = splitValueAndUnit(valueText, unitText);
                        const combinedValue = parts.unit && parts.value && parts.value !== '--'
                            ? (parts.value + ' ' + parts.unit)
                            : parts.value;

                        return titleText
                            ? (titleText + ': ' + combinedValue)
                            : combinedValue;
                    };

                    const copyTextToClipboard = async function (text) {
                        if (!text) {
                            return false;
                        }

                        if (navigator.clipboard && window.isSecureContext) {
                            try {
                                await navigator.clipboard.writeText(text);
                                return true;
                            } catch (error) {
                                // Fall through to legacy copy path.
                            }
                        }

                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        textarea.style.position = 'fixed';
                        textarea.style.left = '-9999px';
                        textarea.style.top = '-9999px';
                        document.body.appendChild(textarea);
                        textarea.focus();
                        textarea.select();

                        let success = false;
                        try {
                            success = document.execCommand('copy');
                        } catch (error) {
                            success = false;
                        }

                        textarea.remove();
                        return success;
                    };

                    const showCopyFeedback = function (button, success) {
                        const originalText = button.textContent;
                        button.textContent = success ? 'Copied' : 'Failed';

                        window.setTimeout(function () {
                            button.textContent = originalText;
                        }, 1200);
                    };

                    const attachCopyButtonToCard = function (card) {
                        if (card.dataset.copyButtonAttached === 'true') {
                            return;
                        }

                        const meta = getCardCopyMeta(card);
                        if (!meta) {
                            return;
                        }

                        const existingCopyButton = card.querySelector(':scope button.copy-btn, :scope button#copyResult');
                        if (existingCopyButton) {
                            existingCopyButton.type = 'button';
                            existingCopyButton.classList.add('inline-flex', 'items-center', 'justify-center', 'rounded-md', 'border', 'border-slate-300', 'bg-white', 'px-2', 'py-1', 'text-[10px]', 'font-semibold', 'text-slate-700', 'hover:bg-slate-100');
                            if ((existingCopyButton.textContent || '').trim() === '') {
                                existingCopyButton.textContent = 'Copy';
                            }
                            card.dataset.copyButtonAttached = 'true';
                            return;
                        }

                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'mt-1 inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-2 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-100';
                        button.textContent = 'Copy';

                        button.addEventListener('click', async function (event) {
                            event.preventDefault();
                            event.stopPropagation();

                            const payload = buildCopyPayload(meta);
                            const success = await copyTextToClipboard(payload);
                            showCopyFeedback(button, success);
                        });

                        const rightColumn = card.querySelector(':scope > .flex.items-center.justify-between > .text-right');

                        if (rightColumn) {
                            rightColumn.appendChild(button);
                        } else {
                            card.classList.add('relative');
                            button.className = 'absolute right-2 top-2 inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-2 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-100';
                            card.appendChild(button);
                        }

                        card.dataset.copyButtonAttached = 'true';
                    };

                    const getOrCreateValuesModal = function (section, cards) {
                        if (section._convertedValuesModal) {
                            return section._convertedValuesModal;
                        }

                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4';
                        modal.innerHTML = [
                            '<div class="w-full max-w-2xl rounded-xl border border-slate-200 bg-white shadow-xl">',
                            '  <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">',
                            '    <h3 class="text-sm font-semibold text-slate-900">All Conversion Values</h3>',
                            '    <button type="button" class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-100" data-converted-modal-close>Close</button>',
                            '  </div>',
                            '  <div class="max-h-[70vh] overflow-y-auto p-4">',
                            '    <div class="space-y-3" data-converted-modal-list></div>',
                            '  </div>',
                            '</div>',
                        ].join('');

                        document.body.appendChild(modal);

                        const closeButton = modal.querySelector('[data-converted-modal-close]');
                        const listRoot = modal.querySelector('[data-converted-modal-list]');

                        const closeModal = function () {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                            document.body.classList.remove('overflow-hidden');
                        };

                        const openModal = function () {
                            listRoot.innerHTML = '';

                            cards.forEach((card) => {
                                const meta = getCardCopyMeta(card);
                                if (!meta) {
                                    return;
                                }

                                const titleText = (meta.titleElement.textContent || '').trim();
                                const subtitleText = meta.subtitleElement
                                    ? (meta.subtitleElement.textContent || '').trim()
                                    : inferConvertedValueSubtitle(titleText);

                                const valueText = (meta.valueElement.textContent || '').trim();
                                const unitText = meta.unitElement ? (meta.unitElement.textContent || '').trim() : '';
                                const parts = splitValueAndUnit(valueText, unitText);

                                const rowCard = document.createElement('div');
                                rowCard.className = 'rounded-md border border-slate-200 bg-slate-50 p-3';

                                const row = document.createElement('div');
                                row.className = 'flex items-center justify-between';

                                const left = document.createElement('div');

                                const title = document.createElement('h4');
                                title.className = 'text-xs font-semibold text-slate-900';
                                title.textContent = titleText;
                                left.appendChild(title);

                                const subtitle = document.createElement('p');
                                subtitle.className = 'text-[11px] text-slate-500';
                                subtitle.textContent = subtitleText;
                                left.appendChild(subtitle);

                                const right = document.createElement('div');
                                right.className = 'text-right';

                                const value = document.createElement('div');
                                value.className = 'font-serif text-3xl font-bold leading-none text-indigo-700';
                                value.textContent = parts.value || '--';
                                right.appendChild(value);

                                const unit = document.createElement('div');
                                unit.className = 'text-xs text-slate-500 font-medium';
                                unit.textContent = parts.unit;
                                right.appendChild(unit);

                                const copyButton = document.createElement('button');
                                copyButton.type = 'button';
                                copyButton.className = 'mt-1 inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-2 py-1 text-[10px] font-semibold text-slate-700 hover:bg-slate-100';
                                copyButton.textContent = 'Copy';
                                copyButton.addEventListener('click', async function () {
                                    const payload = buildCopyPayload(meta);
                                    const success = await copyTextToClipboard(payload);
                                    showCopyFeedback(copyButton, success);
                                });
                                right.appendChild(copyButton);

                                row.appendChild(left);
                                row.appendChild(right);
                                rowCard.appendChild(row);
                                listRoot.appendChild(rowCard);
                            });

                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                            document.body.classList.add('overflow-hidden');
                        };

                        closeButton.addEventListener('click', closeModal);

                        modal.addEventListener('click', function (event) {
                            if (event.target === modal) {
                                closeModal();
                            }
                        });

                        section._convertedValuesModal = {
                            open: openModal,
                            close: closeModal,
                        };

                        return section._convertedValuesModal;
                    };

                      const enhanceConvertedValuesSections = function () {
                          const resultSections = getConvertedValueSections();

                          resultSections.forEach((section) => {
                              const cards = getConvertedValueCards(section);

                              if (!cards.length) {
                                  return;
                              }

                              cards.forEach((card) => {
                                  attachCopyButtonToCard(card);
                              });

                              const heading = section.querySelector(':scope > h3');
                              let visibleCardsHost = section.querySelector('[data-converted-visible-cards]');

                              if (!visibleCardsHost) {
                                  visibleCardsHost = document.createElement('div');
                                  visibleCardsHost.dataset.convertedVisibleCards = 'true';
                                  visibleCardsHost.className = 'space-y-3';

                                  if (heading) {
                                      heading.insertAdjacentElement('afterend', visibleCardsHost);
                                  } else {
                                      section.prepend(visibleCardsHost);
                                  }
                              }

                              cards.slice(0, 3).forEach((card) => {
                                  card.classList.remove('hidden');
                                  visibleCardsHost.appendChild(card);
                              });

                              cards.slice(3).forEach((card) => {
                                  card.classList.add('hidden');
                              });

                              let showMoreButton = section.querySelector('[data-converted-show-more]');

                              if (cards.length > 3) {
                                  if (!showMoreButton) {
                                      showMoreButton = document.createElement('button');
                                      showMoreButton.type = 'button';
                                      showMoreButton.dataset.convertedShowMore = 'true';
                                      showMoreButton.className = 'inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-100';
                                      showMoreButton.textContent = 'Show More';
                                      section.appendChild(showMoreButton);
                                  }

                                  showMoreButton.classList.remove('hidden');

                                  if (showMoreButton.previousElementSibling !== visibleCardsHost) {
                                      visibleCardsHost.insertAdjacentElement('afterend', showMoreButton);
                                  }

                                  if (!showMoreButton.dataset.bound) {
                                      const modalController = getOrCreateValuesModal(section, cards);

                                      showMoreButton.addEventListener('click', function () {
                                          modalController.open();
                                      });

                                      showMoreButton.dataset.bound = 'true';
                                  } else {
                                      getOrCreateValuesModal(section, cards);
                                  }
                              } else if (showMoreButton) {
                                  showMoreButton.classList.add('hidden');
                              }

                              const preservedElements = new Set([heading, visibleCardsHost, showMoreButton].filter(Boolean));

                              Array.from(section.children).forEach((child) => {
                                  if (preservedElements.has(child)) {
                                      return;
                                  }

                                  const hasVisibleDirectChild = !!child.querySelector(':scope > :not(.hidden)');

                                  if (!hasVisibleDirectChild) {
                                      if ((child.children || []).length > 0) {
                                          child.classList.add('hidden');
                                          return;
                                      }

                                      if ((child.textContent || '').trim() === '') {
                                          child.classList.add('hidden');
                                      }
                                  }
                              });
                          });
                      };

                    const applyUniformConvertedValueTypography = function (section) {
                        const heading = section.querySelector(':scope > h3');
                        if (heading) {
                            heading.className = 'text-lg font-semibold text-slate-900 text-center mb-4';
                            heading.textContent = 'Converted Values';
                        }

                        const convertedCards = getConvertedValueCards(section);

                        convertedCards.forEach((card) => {
                            card.className = 'rounded-md border border-slate-200 bg-slate-50 p-2.5';

                            const row = card.querySelector(':scope > .flex.items-center.justify-between');
                            if (!row) {
                                return;
                            }

                            const left = row.querySelector(':scope > div:first-child');
                            const right = row.querySelector(':scope > .text-right');

                            if (left) {
                                const title = left.querySelector(':scope > h4');
                                if (title) {
                                    title.className = 'text-xs font-semibold text-slate-900';
                                }

                                const subtitle = left.querySelector(':scope > p');
                                if (subtitle) {
                                    subtitle.className = 'text-[11px] text-slate-500';
                                }
                            }

                            if (right) {
                                const value = right.querySelector(':scope > .font-serif, :scope > .font-mono, :scope > [id$="Output"], :scope > [id="output"]');
                                if (value) {
                                    value.className = 'font-serif text-3xl font-bold leading-none text-indigo-700';
                                }

                                const unit = right.querySelector(':scope > .text-xs.text-slate-500.font-medium');
                                if (unit) {
                                    unit.className = 'text-xs text-slate-500 font-medium';
                                }
                            }
                        });
                    };

                    const normalizeMultiConvertedValueCards = function () {
                        const resultSections = getConvertedValueSections();

                        resultSections.forEach((section) => {
                            const convertedCards = getConvertedValueCards(section);

                            if (convertedCards.length <= 1) {
                                return;
                            }

                            const cardsToTransform = convertedCards.filter((card) => {
                                if (card.dataset.convertedCardNormalized === 'true') {
                                    return false;
                                }

                                const centeredBody = card.querySelector(':scope > .text-center');
                                if (centeredBody) {
                                    const title = centeredBody.querySelector(':scope > h4');
                                    const value = centeredBody.querySelector(centeredConvertedValueSelector);
                                    return !!(title && value);
                                }

                                const stackedHeader = card.querySelector(':scope > .flex.items-center.justify-between');
                                const stackedTitle = stackedHeader ? stackedHeader.querySelector(':scope > h4') : null;
                                const stackedValue = card.querySelector(directConvertedValueSelector);

                                return !!(stackedHeader && stackedTitle && stackedValue);
                            });

                            const cardParents = new Set(cardsToTransform.map((card) => card.parentElement).filter(Boolean));
                            cardParents.forEach((parent) => {
                                if (!parent.classList.contains('grid')) {
                                    return;
                                }

                                parent.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2', 'md:grid-cols-3', 'gap-4');
                                parent.classList.add('space-y-3');
                            });

                            cardsToTransform.forEach((card) => {
                                const centeredBody = card.querySelector(':scope > .text-center');
                                const stackedHeader = card.querySelector(':scope > .flex.items-center.justify-between');

                                const title = centeredBody
                                    ? centeredBody.querySelector(':scope > h4')
                                    : (stackedHeader ? stackedHeader.querySelector(':scope > h4') : null);
                                const value = centeredBody
                                    ? centeredBody.querySelector(centeredConvertedValueSelector)
                                    : card.querySelector(directConvertedValueSelector);

                                if (!title || !value) {
                                    return;
                                }

                                const stackedSubtitle = centeredBody
                                    ? null
                                    : card.querySelector(':scope > .text-xs');

                                const existingCopyButton = centeredBody
                                    ? centeredBody.querySelector(':scope > button.copy-btn, :scope > button#copyResult')
                                    : (stackedHeader ? stackedHeader.querySelector(':scope > button.copy-btn, :scope > button#copyResult') : null);

                                const fallbackUnit = inferUnitLabel(title.textContent || '', value.id || '');

                                const left = document.createElement('div');
                                title.className = 'text-xs font-semibold text-slate-900';
                                left.appendChild(title);

                                const subtitle = document.createElement('p');
                                subtitle.className = 'text-[11px] text-slate-500';
                                subtitle.textContent = stackedSubtitle
                                    ? (stackedSubtitle.textContent || '').trim()
                                    : inferConvertedValueSubtitle(title.textContent || '');
                                left.appendChild(subtitle);

                                const right = document.createElement('div');
                                right.className = 'text-right';
                                value.className = 'font-serif text-3xl font-bold leading-none text-indigo-700';
                                right.appendChild(value);

                                const unit = document.createElement('div');
                                unit.className = 'text-xs text-slate-500 font-medium';
                                unit.textContent = fallbackUnit;
                                right.appendChild(unit);

                                if (existingCopyButton) {
                                    right.appendChild(existingCopyButton);
                                }

                                moveInlineUnitToLabel(value, unit, fallbackUnit);

                                const observer = new MutationObserver(() => {
                                    moveInlineUnitToLabel(value, unit, fallbackUnit);
                                });
                                observer.observe(value, { childList: true, characterData: true, subtree: true });

                                const row = document.createElement('div');
                                row.className = 'flex items-center justify-between';
                                row.appendChild(left);
                                row.appendChild(right);

                                if (centeredBody) {
                                    centeredBody.replaceWith(row);
                                } else {
                                    card.innerHTML = '';
                                    card.appendChild(row);
                                }

                                card.dataset.convertedCardNormalized = 'true';
                            });

                            applyUniformConvertedValueTypography(section);
                        });
                    };

                    const normalizeEngineeringToolShell = function () {
                        if (!isEngineeringTechnicalPage && !isGeographicMappingPage && !isNumberConversionToolsPage && !isDataTechnicalPage && !isTimeDatePage) {
                            return;
                        }

                        const normalizeEngineeringClearActionBar = function (form) {
                            let clearButton = form.querySelector('#clearButton');
                            if (!clearButton) {
                                clearButton = document.createElement('button');
                                clearButton.type = 'button';
                                clearButton.id = 'clearButton';
                                clearButton.dataset.generatedClearButton = 'true';
                                clearButton.addEventListener('click', function () {
                                    const clearEvent = new KeyboardEvent('keydown', {
                                        key: 'Escape',
                                        bubbles: true,
                                        cancelable: true,
                                    });
                                    document.dispatchEvent(clearEvent);
                                });
                            }

                            const directionCount = form.querySelectorAll('input[name="direction"]').length;
                            const modeCount = form.querySelectorAll('input[name="mode"]').length;
                            const hasDirectionToggle = directionCount > 1 || modeCount > 1;

                            const shortcutLabel = hasDirectionToggle
                                ? 'Shortcut: Ctrl + M to switch mode'
                                : 'Shortcut: Ctrl + Shift + C to clear';

                            const shortcutText = document.createElement('p');
                            shortcutText.className = 'text-[11px] text-slate-500';
                            shortcutText.textContent = shortcutLabel;

                            const currentWrapper = clearButton.parentElement;

                            clearButton.textContent = 'Clear';
                            clearButton.className = 'rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700';

                            const actionRow = document.createElement('div');
                            actionRow.dataset.clearActionRow = 'true';
                            actionRow.className = 'flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5';
                            actionRow.appendChild(shortcutText);
                            actionRow.appendChild(clearButton);

                            if (currentWrapper && currentWrapper !== form && currentWrapper.parentElement === form) {
                                currentWrapper.replaceWith(actionRow);
                            } else {
                                form.appendChild(actionRow);
                            }
                        };

                        const calculatorShell = toolUiRoot.firstElementChild;
                        if (!calculatorShell) {
                            return;
                        }

                        calculatorShell.className = 'space-y-2';

                        const shellSections = Array.from(calculatorShell.children).filter((node) => node.tagName && node.tagName.toLowerCase() === 'div');
                        const headerSection = shellSections[0];
                        const bodySection = shellSections[1];

                        if (headerSection) {
                            headerSection.className = 'rounded-md bg-white p-2.5 shadow-sm';

                            const title = headerSection.querySelector('h1, h2');
                            if (title) {
                                title.className = 'text-sm font-semibold text-slate-900';
                            }
                        }

                        if (bodySection) {
                            bodySection.className = 'rounded-md bg-white p-3 shadow-sm';

                            const bodyGrid = bodySection.querySelector(':scope > .grid');
                            if (bodyGrid) {
                                bodyGrid.classList.remove('gap-6', 'lg:grid-cols-12');
                                bodyGrid.classList.add('gap-3', 'lg:grid-cols-9');

                                const columns = Array.from(bodyGrid.children).filter((node) => node.tagName && node.tagName.toLowerCase() === 'div');
                                const leftColumn = columns[0];
                                const rightColumn = columns[1];

                                if (leftColumn) {
                                    leftColumn.classList.remove('lg:col-span-6');
                                    leftColumn.classList.add('lg:col-span-5');

                                    const form = leftColumn.querySelector('form');
                                    if (form) {
                                        form.className = 'space-y-3';
                                        normalizeEngineeringClearActionBar(form);
                                    }
                                }

                                if (rightColumn) {
                                    rightColumn.className = 'space-y-4 lg:col-span-4';
                                }
                            }
                        }

                        toolUiRoot.querySelectorAll('.text-gray-900').forEach((node) => {
                            node.classList.remove('text-gray-900');
                            node.classList.add('text-slate-900');
                        });

                        toolUiRoot.querySelectorAll('.text-gray-800').forEach((node) => {
                            node.classList.remove('text-gray-800');
                            node.classList.add('text-slate-900');
                        });

                        toolUiRoot.querySelectorAll('.text-gray-700').forEach((node) => {
                            node.classList.remove('text-gray-700');
                            node.classList.add('text-slate-700');
                        });

                        toolUiRoot.querySelectorAll('.text-gray-600').forEach((node) => {
                            node.classList.remove('text-gray-600');
                            node.classList.add('text-slate-600');
                        });

                        toolUiRoot.querySelectorAll('.text-gray-500').forEach((node) => {
                            node.classList.remove('text-gray-500');
                            node.classList.add('text-slate-500');
                        });

                        const swapButtons = Array.from(toolUiRoot.querySelectorAll('#swapUnits'));
                        swapButtons.forEach((swapButton) => {
                            const wrapper = swapButton.parentElement;
                            if (wrapper && wrapper !== toolUiRoot && wrapper.tagName.toLowerCase() === 'div' && wrapper.childElementCount === 1) {
                                wrapper.remove();
                            } else {
                                swapButton.remove();
                            }
                        });
                    };

                    normalizeEngineeringToolShell();

                    const helperBlocks = Array.from(toolUiRoot.children).filter((node) => {
                        return node.classList && node.classList.contains('mt-6') && node.classList.contains('space-y-4');
                    });

                    helperBlocks.forEach((block) => {
                        block.classList.remove('mt-6');

                        const cards = Array.from(block.querySelectorAll(':scope > div'));
                        cards.forEach((card) => {
                            card.classList.remove('p-4');
                            card.classList.add('p-3', 'shadow-sm');

                            card.querySelectorAll('.mt-6').forEach((node) => node.classList.remove('mt-6'));
                            card.querySelectorAll('.bg-gray-50').forEach((node) => {
                                node.classList.remove('bg-gray-50');
                                node.classList.add('bg-slate-50');
                            });
                            card.querySelectorAll('.rounded-lg').forEach((node) => {
                                if (node.tagName.toLowerCase() === 'div') {
                                    node.classList.remove('rounded-lg');
                                    node.classList.add('rounded-md');
                                }
                            });
                            card.querySelectorAll('.text-gray-700').forEach((node) => {
                                node.classList.remove('text-gray-700');
                                node.classList.add('text-slate-700');
                            });
                            card.querySelectorAll('.text-gray-600').forEach((node) => {
                                node.classList.remove('text-gray-600');
                                node.classList.add('text-slate-600');
                            });
                        });

                        aboutContentStack.appendChild(block);
                    });

                    normalizeMultiConvertedValueCards();
                    enhanceConvertedValuesSections();

                    if (isGeographicScaleCalculatorPage) {
                        const adjustScaleCalculatorRows = function (root) {
                            const rows = root.querySelectorAll('.flex.items-center.justify-between');

                            rows.forEach((row) => {
                                row.className = 'flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between';

                                const left = row.querySelector(':scope > div:first-child');
                                if (left) {
                                    left.classList.add('min-w-0', 'flex-1');
                                }

                                const right = row.querySelector(':scope > .text-right, :scope > div:last-child');
                                if (right) {
                                    right.classList.remove('text-right');
                                    right.classList.add('w-full', 'text-left', 'sm:w-auto', 'sm:text-right');

                                    const value = right.querySelector(':scope > .font-serif');
                                    if (value) {
                                        value.classList.add('break-words');
                                    }

                                    right.querySelectorAll('button').forEach((button) => {
                                        button.classList.add('self-start', 'sm:self-auto');
                                    });
                                }
                            });
                        };

                        const resultSections = getConvertedValueSections();
                        resultSections.forEach((section) => {
                            adjustScaleCalculatorRows(section);
                        });
                    }

                    document.addEventListener('keydown', function (e) {
                        if (e.defaultPrevented) {
                            return;
                        }

                        if (isCtrlShiftCClearShortcut(e)) {
                            const clearButton = toolUiRoot.querySelector('#clearButton');
                            if (clearButton) {
                                e.preventDefault();
                                clearButton.click();
                            }
                            return;
                        }

                        if (!isCtrlMShortcut(e)) {
                            return;
                        }

                        const directionRadios = Array.from(toolUiRoot.querySelectorAll('input[name="direction"]'));
                        const modeRadios = Array.from(toolUiRoot.querySelectorAll('input[name="mode"]'));
                        const toggleGroup = directionRadios.length > 1 ? directionRadios : modeRadios;

                        if (toggleGroup.length <= 1) {
                            return;
                        }

                        e.preventDefault();

                        const currentIndex = toggleGroup.findIndex((radio) => radio.checked);
                        const nextIndex = currentIndex >= 0
                            ? (currentIndex + 1) % toggleGroup.length
                            : 0;

                        toggleGroup[nextIndex].checked = true;
                        toggleGroup[nextIndex].dispatchEvent(new Event('change', { bubbles: true }));
                    });
                }

                const quickReferenceColumn = document.getElementById('quickReferenceColumn');
                const quickReferenceTarget = document.getElementById('quickReferenceTarget');

                if (hasEnhancedConvertedValues) {
                    return;
                }

                if (!toolUiRoot || !quickReferenceColumn || !quickReferenceTarget) {
                    return;
                }

                const headingNodes = Array.from(toolUiRoot.querySelectorAll('h2, h3, h4, h5, h6'));
                const referenceCards = [];

                headingNodes.forEach((heading) => {
                    const headingText = (heading.textContent || '').toLowerCase().replace(/\s+/g, ' ').trim();

                    if (!headingText.includes('reference') || headingText.includes('impedance')) {
                        return;
                    }

                    if (heading.closest('form')) {
                        return;
                    }

                    const cardCandidate = heading.closest('section.rounded-xl, section.rounded-lg, div.rounded-xl, div.rounded-lg');

                    if (!cardCandidate || cardCandidate.id === 'toolUiRoot' || !toolUiRoot.contains(cardCandidate)) {
                        return;
                    }

                    referenceCards.push(cardCandidate);
                });

                const uniqueReferenceCards = Array.from(new Set(referenceCards));

                if (!uniqueReferenceCards.length) {
                    return;
                }

                const isEmptyWrapper = (element) => (element.textContent || '').trim() === ''
                    && !element.querySelector('input, select, textarea, button, canvas, img, svg, table');

                uniqueReferenceCards.forEach((card) => {
                    let formerParent = card.parentElement;

                    quickReferenceTarget.appendChild(card);

                    while (formerParent && formerParent !== toolUiRoot && toolUiRoot.contains(formerParent) && isEmptyWrapper(formerParent)) {
                        const nextParent = formerParent.parentElement;
                        formerParent.remove();
                        formerParent = nextParent;
                    }
                });

                quickReferenceColumn.classList.remove('hidden');
            });
        </script>

        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbSchemaItems,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        <script type="application/ld+json">{!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Related tools for ' . $toolTitle,
            'itemListElement' => collect($relatedTools)->map(fn (array $tool, int $index): array => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $tool['title'],
                'url' => route($tool['route_name']),
            ])->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        <script type="application/ld+json">{!! json_encode($webApplicationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        @if(!empty($faqSchemaPayload))
            <script type="application/ld+json">{!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faqSchemaPayload,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif

        @if(!empty($howToSchemaPayload))
            <script type="application/ld+json">{!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'HowTo',
                'name' => $toolTitle,
                'step' => $howToSchemaPayload,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif
    </x-slot>
</x-app-layout>
