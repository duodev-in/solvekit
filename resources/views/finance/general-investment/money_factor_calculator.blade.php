<x-calc.page
    title="Money Factor Calculator - SolveKit"
    description="Free Money Factor Calculator: APR ≈ money factor × 2,400. Car leases quote a money factor instead of an interest rate; multiplying by 2,400 gives the approximate APR."
    lede="Work out the equivalent APR from the money factor."
    about="Car leases quote a money factor instead of an interest rate; multiplying by 2,400 gives the approximate APR. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'money_factor', 'fields' => ['mf']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Money factor.'],
        ['name' => 'Read the result', 'text' => 'The equivalent APR appears as you type, with APR to money factor (for the same APR) below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the equivalent APR?', 'answer' => 'APR ≈ money factor × 2,400.'],
        ['question' => 'What is the equivalent APR for money factor 0.00125?', 'answer' => '3%. APR to money factor (for the same APR): 0.00125.'],
        ['question' => 'And for money factor 0.0029?', 'answer' => '6.96%. APR to money factor (for the same APR): 0.0029.'],
        ['question' => 'What does the result tell me?', 'answer' => 'A money factor of 0.00125 is about 3%.'],
    ]"
>
    <x-calc.field name="mf" label="Money factor" value="0.00125" step="any" />

    <x-calc.result label="Equivalent APR" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['mf' => 0.00125],
        'Example B' => ['mf' => 0.0029],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'APR to money factor (for the same APR)'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>APR ≈ money factor × 2,400</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
