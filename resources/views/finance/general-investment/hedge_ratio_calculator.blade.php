<x-calc.page
    title="Hedge Ratio Calculator - SolveKit"
    description="Free Hedge Ratio Calculator: hedge ratio = hedge ÷ exposure. The hedge ratio is the share of a position protected by the hedge."
    lede="Work out the hedge ratio from value of the hedge position and value of the exposure."
    about="The hedge ratio is the share of a position protected by the hedge. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'hedge_ratio', 'fields' => ['hedge', 'exposure']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Value of the hedge position, Value of the exposure.'],
        ['name' => 'Read the result', 'text' => 'The hedge ratio appears as you type, with unhedged below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the hedge ratio?', 'answer' => 'Hedge ratio = hedge ÷ exposure.'],
        ['question' => 'What is the hedge ratio for value of the hedge position $60,000, value of the exposure $100,000?', 'answer' => '60%. Unhedged: $40,000.00.'],
        ['question' => 'And for value of the hedge position $250,000, value of the exposure $400,000?', 'answer' => '62.5%. Unhedged: $150,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => '1 (100%) is fully hedged; 0 is unhedged.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hedge" label="Value of the hedge position" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="exposure" label="Value of the exposure" value="100000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Hedge ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['hedge' => 60000, 'exposure' => 100000],
        'Example B' => ['hedge' => 250000, 'exposure' => 400000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Unhedged'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>hedge ratio = hedge ÷ exposure</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
