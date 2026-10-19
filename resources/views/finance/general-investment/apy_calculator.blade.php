<x-calc.page
    title="APY Calculator - SolveKit"
    description="Free APY Calculator: APY = (1 + r/n)^n − 1. Annual percentage yield is the yearly return including compounding; US banks must quote it under Regulation DD (Truth in Savings)."
    lede="Work out the APY from nominal rate (APR) and compounding periods a year."
    about="Annual percentage yield is the yearly return including compounding; US banks must quote it under Regulation DD (Truth in Savings). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'apy', 'fields' => ['apr', 'n']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Nominal rate (APR), Compounding periods a year.'],
        ['name' => 'Read the result', 'text' => 'The APY appears as you type, with with continuous compounding below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the APY?', 'answer' => 'APY = (1 + r/n)^n − 1.'],
        ['question' => 'What is the APY for nominal rate 4.5%, compounding periods a year 12?', 'answer' => '4.594%. With continuous compounding: 4.603%.'],
        ['question' => 'And for nominal rate 5%, compounding periods a year 365?', 'answer' => '5.127%. With continuous compounding: 5.127%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Daily compounding (365) at 4.5% gives 4.6025%.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="apr" label="Nominal rate (APR)" value="4.5" step="any" suffix="%" />
        <x-calc.field name="n" label="Compounding periods a year" value="12" min="0" step="1" />
    </div>

    <x-calc.result label="APY" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['apr' => 4.5, 'n' => 12],
        'Example B' => ['apr' => 5, 'n' => 365],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'With continuous compounding'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>APY = (1 + r/n)^n − 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
