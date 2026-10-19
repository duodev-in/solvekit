<x-calc.page
    title="Equivalent Rate Calculator – AER - SolveKit"
    description="Free Equivalent Rate Calculator – AER: AER = (1 + periodic rate)^n − 1. The UK annual equivalent rate shows what a savings rate would be if interest were paid and compounded once a year."
    lede="Work out the AER from interest rate per period and periods a year."
    about="The UK annual equivalent rate shows what a savings rate would be if interest were paid and compounded once a year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'aer', 'fields' => ['rate', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Interest rate per period, Periods a year.'],
        ['name' => 'Read the result', 'text' => 'The AER appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the AER?', 'answer' => 'AER = (1 + periodic rate)^n − 1.'],
        ['question' => 'What is the AER for interest rate per period 0.4%, periods a year 12?', 'answer' => '4.907%.'],
        ['question' => 'And for interest rate per period 2.25%, periods a year 2?', 'answer' => '4.551%.'],
        ['question' => 'What does the result tell me?', 'answer' => '0.4% a month is 4.91% AER.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="rate" label="Interest rate per period" value="0.4" step="any" suffix="%" />
        <x-calc.field name="n" label="Periods a year" value="12" min="0" step="1" />
    </div>

    <x-calc.result label="AER" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['rate' => 0.4, 'n' => 12],
        'Example B' => ['rate' => 2.25, 'n' => 2],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AER = (1 + periodic rate)^n − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
