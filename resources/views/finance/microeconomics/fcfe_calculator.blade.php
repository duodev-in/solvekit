<x-calc.page
    title="FCFE Calculator - SolveKit"
    description="Free FCFE Calculator: FCFE = FCFF − interest × (1 − t) + net borrowing. Free cash flow to equity is the cash available to shareholders after debt holders are paid."
    lede="Work out the FCFE from your figures."
    about="Free cash flow to equity is the cash available to shareholders after debt holders are paid. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'fcfe', 'fields' => ['fcff', 'interest', 'tax', 'borrowing']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Free cash flow to firm, Interest expense, Tax rate, Net borrowing.'],
        ['name' => 'Read the result', 'text' => 'The FCFE appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the FCFE?', 'answer' => 'FCFE = FCFF − interest × (1 − t) + net borrowing.'],
        ['question' => 'What is the FCFE for free cash flow to firm $1,000,000, interest expense $100,000, tax rate 21%, net borrowing $50,000?', 'answer' => '$971,000.00.'],
        ['question' => 'And for free cash flow to firm $300,000, interest expense $40,000, tax rate 25%, net borrowing −$60,000?', 'answer' => '$210,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Used to value equity directly with the cost of equity.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="fcff" label="Free cash flow to firm" value="1000000" step="0.01" suffix="$" />
        <x-calc.field name="interest" label="Interest expense" value="100000" step="0.01" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="tax" label="Tax rate" value="21" step="any" suffix="%" />
        <x-calc.field name="borrowing" label="Net borrowing" value="50000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="FCFE" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['fcff' => 1000000, 'interest' => 100000, 'tax' => 21, 'borrowing' => 50000],
        'Example B' => ['fcff' => 300000, 'interest' => 40000, 'tax' => 25, 'borrowing' => -60000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FCFE = FCFF − interest × (1 − t) + net borrowing</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
