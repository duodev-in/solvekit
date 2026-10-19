<x-calc.page
    title="PVIFA Calculator - SolveKit"
    description="Free PVIFA Calculator: PVIFA = [1 − (1 + r)^−n] ÷ r. The present value interest factor of an annuity turns a level payment into a present value: PV = PMT × PVIFA."
    lede="Work out the PVIFA from rate per period and number of periods."
    about="The present value interest factor of an annuity turns a level payment into a present value: PV = PMT × PVIFA. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'pvifa', 'fields' => ['rate', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Rate per period, Number of periods.'],
        ['name' => 'Read the result', 'text' => 'The PVIFA appears as you type, with FVIFA below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the PVIFA?', 'answer' => 'PVIFA = [1 − (1 + r)^−n] ÷ r.'],
        ['question' => 'What is the PVIFA for rate per period 6%, number of periods 10?', 'answer' => '7.36. FVIFA: 13.18.'],
        ['question' => 'And for rate per period 0.5%, number of periods 360?', 'answer' => '166.79. FVIFA: 1,004.52.'],
        ['question' => 'What does the result tell me?', 'answer' => 'At 6% for 10 periods, each $1 a period is worth $7.36 today.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Rate per period" value="6" step="any" suffix="%" />
        <x-calc.field name="n" label="Number of periods" value="10" min="0" step="1" />
    </div>

    <x-calc.result label="PVIFA" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 6, 'n' => 10],
        'Example B' => ['rate' => 0.5, 'n' => 360],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'FVIFA'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>PVIFA = [1 − (1 + r)^−n] ÷ r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
