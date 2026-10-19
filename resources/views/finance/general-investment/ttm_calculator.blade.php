<x-calc.page
    title="TTM Calculator – Trailing Twelve Months - SolveKit"
    description="Free TTM calculator: trailing twelve months revenue or earnings from four quarters, or from the last annual report plus year-to-date figures."
    lede="Work out trailing twelve months figures."
    about="TTM sums the latest four quarters. From reports: TTM = last fiscal year + current year-to-date − the same period a year earlier. Analysts use TTM figures for P/E and other ratios. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-invest', 'tool' => 'ttm', 'fields' => ['mode', 'q1', 'q2', 'q3', 'q4', 'annual', 'ytd', 'prior']]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Quarters or annual + YTD.'],
        ['name' => 'Enter the figures', 'text' => 'From the reports.'],
    ]"
    :faqs="[
        ['question' => 'What is TTM revenue from quarters of 2.40, 2.55, 2.61 and 2.80 million?', 'answer' => '$10,360,000.00.'],
        ['question' => 'And from 9.8 million last year with 5.41 million YTD against 4.90 million?', 'answer' => '$10,310,000.00.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['quarters' => 'Four quarters', 'annual' => 'Annual + YTD']" selected="quarters" />

    <div data-show-when="mode:quarters">
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <x-calc.field name="q1" label="Quarter 1" value="2400000" step="0.01" suffix="$" />
            <x-calc.field name="q2" label="Quarter 2" value="2550000" step="0.01" suffix="$" />
            <x-calc.field name="q3" label="Quarter 3" value="2610000" step="0.01" suffix="$" />
            <x-calc.field name="q4" label="Quarter 4 (latest)" value="2800000" step="0.01" suffix="$" />
        </div>
    </div>

    <div data-show-when="mode:annual" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="annual" label="Last fiscal year" value="9800000" step="0.01" suffix="$" />
            <x-calc.field name="ytd" label="This year to date" value="5410000" step="0.01" suffix="$" />
            <x-calc.field name="prior" label="Same period last year" value="4900000" step="0.01" suffix="$" />
        </div>
    </div>

    <x-calc.result label="Trailing twelve months" />

    <x-calc.options :decimals="false" :examples="[
        'Quarters' => ['mode' => 'quarters', 'q1' => 2400000, 'q2' => 2550000, 'q3' => 2610000, 'q4' => 2800000, 'annual' => '', 'ytd' => '', 'prior' => ''],
        'Annual + YTD' => ['mode' => 'annual', 'q1' => '', 'q2' => '', 'q3' => '', 'q4' => '', 'annual' => 9800000, 'ytd' => 5410000, 'prior' => 4900000],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:quarters">
            <x-calc.rows heading="Details" :rows="[
                'average' => ['label' => 'Average quarter'],
                'runrate' => ['label' => 'Run rate (latest quarter × 4)'],
            ]" />
        </div>
        <div data-show-when="mode:annual" hidden>
            <x-calc.rows heading="Details" :rows="[
                'change' => ['label' => 'Change on the fiscal year'],
                'ytd' => ['label' => 'Year-to-date change'],
            ]" />
        </div>
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TTM = Q₁ + Q₂ + Q₃ + Q₄</li>
            <li>TTM = FY + YTD − prior YTD</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
