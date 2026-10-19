<x-calc.page
    title="DART Rate Calculator - SolveKit"
    description="Free DART Rate Calculator: DART = cases × 200,000 ÷ hours worked. OSHA's DART rate counts serious injuries per 100 full-time workers (200,000 hours = 100 workers × 2,000 hours)."
    lede="Work out the DART rate from days away, restricted or transferred cases and total hours worked."
    about="OSHA's DART rate counts serious injuries per 100 full-time workers (200,000 hours = 100 workers × 2,000 hours). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dart_rate', 'fields' => ['cases', 'hours']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Days away, restricted or transferred cases, Total hours worked.'],
        ['name' => 'Read the result', 'text' => 'The DART rate appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the DART rate?', 'answer' => 'DART = cases × 200,000 ÷ hours worked.'],
        ['question' => 'What is the DART rate for days away, restricted or transferred cases 4, total hours worked 400,000?', 'answer' => '2.'],
        ['question' => 'And for days away, restricted or transferred cases 2, total hours worked 120,000?', 'answer' => '3.333.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with the BLS industry average.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cases" label="Days away, restricted or transferred cases" value="4" min="0" step="1" />
        <x-calc.field name="hours" label="Total hours worked" value="400000" step="any" />
    </div>

    <x-calc.result label="DART rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cases' => 4, 'hours' => 400000],
        'Example B' => ['cases' => 2, 'hours' => 120000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DART = cases × 200,000 ÷ hours worked</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
