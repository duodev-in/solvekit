<x-calc.page
    title="Fisher Effect Calculator - SolveKit"
    description="Free Fisher Effect Calculator: (1 + i) = (1 + r)(1 + π). Irving Fisher showed nominal rates rise with expected inflation to keep real returns steady."
    lede="Work out the nominal interest rate from real interest rate and expected inflation."
    about="Irving Fisher showed nominal rates rise with expected inflation to keep real returns steady. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'fisher_effect', 'fields' => ['real', 'inflation']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Real interest rate, Expected inflation.'],
        ['name' => 'Read the result', 'text' => 'The nominal interest rate appears as you type, with approximation below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the nominal interest rate?', 'answer' => '(1 + i) = (1 + r)(1 + π); approximately i ≈ r + π.'],
        ['question' => 'What is the nominal interest rate for real interest rate 2%, expected inflation 3%?', 'answer' => '5.06%. Approximation: 5%.'],
        ['question' => 'And for real interest rate 1%, expected inflation 8%?', 'answer' => '9.08%. Approximation: 9%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The approximation is close for low rates.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="real" label="Real interest rate" value="2" step="any" suffix="%" />
        <x-calc.field name="inflation" label="Expected inflation" value="3" step="any" suffix="%" />
    </div>

    <x-calc.result label="Nominal interest rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['real' => 2, 'inflation' => 3],
        'Example B' => ['real' => 1, 'inflation' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Approximation'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>(1 + i) = (1 + r)(1 + π)</li>
            <li>approximately i ≈ r + π</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
