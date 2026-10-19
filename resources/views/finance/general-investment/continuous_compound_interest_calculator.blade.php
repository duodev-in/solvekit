<x-calc.page
    title="Continuous Compound Interest Calculator - SolveKit"
    description="Free Continuous Compound Interest Calculator: A = P e^(rt). Continuous compounding is the limit as compounding becomes infinitely frequent."
    lede="Work out the future value from principal, annual rate and years."
    about="Continuous compounding is the limit as compounding becomes infinitely frequent. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'continuous_compound_interest', 'fields' => ['principal', 'rate', 'years']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Principal, Annual rate, Years.'],
        ['name' => 'Read the result', 'text' => 'The future value appears as you type, with interest, effective annual rate below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the future value?', 'answer' => 'A = P e^(rt).'],
        ['question' => 'What is the future value for principal $10,000, annual rate 5%, years 10?', 'answer' => '$16,487.21. Interest: $6,487.21.'],
        ['question' => 'And for principal $2,500, annual rate 3.2%, years 6?', 'answer' => '$3,029.18. Interest: $529.18.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It earns only slightly more than daily compounding.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="principal" label="Principal" value="10000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Annual rate" value="5" step="any" suffix="%" />
        <x-calc.field name="years" label="Years" value="10" min="0" step="any" suffix="years" />
    </div>

    <x-calc.result label="Future value" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['principal' => 10000, 'rate' => 5, 'years' => 10],
        'Example B' => ['principal' => 2500, 'rate' => 3.2, 'years' => 6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Interest'],
            'r2' => ['label' => 'Effective annual rate'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A = P e^(rt)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
