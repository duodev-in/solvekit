<x-calc.page
    title="Cash On Cash Return Calculator - SolveKit"
    description="Free Cash On Cash Return Calculator: CoC = annual pre-tax cash flow ÷ cash invested. Cash-on-cash is the yearly cash return on the money you put in, after mortgage payments."
    lede="Work out the cash-on-cash return from annual pre-tax cash flow and total cash invested."
    about="Cash-on-cash is the yearly cash return on the money you put in, after mortgage payments. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cash_on_cash_return', 'fields' => ['cashflow', 'invested']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Annual pre-tax cash flow, Total cash invested.'],
        ['name' => 'Read the result', 'text' => 'The cash-on-cash return appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cash-on-cash return?', 'answer' => 'CoC = annual pre-tax cash flow ÷ cash invested.'],
        ['question' => 'What is the cash-on-cash return for annual pre-tax cash flow $12,000, total cash invested $100,000?', 'answer' => '12%.'],
        ['question' => 'And for annual pre-tax cash flow $4,800, total cash invested $65,000?', 'answer' => '7.385%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It ignores appreciation and principal paydown.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="cashflow" label="Annual pre-tax cash flow" value="12000" step="0.01" suffix="$" />
        <x-calc.field name="invested" label="Total cash invested" value="100000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cash-on-cash return" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['cashflow' => 12000, 'invested' => 100000],
        'Example B' => ['cashflow' => 4800, 'invested' => 65000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CoC = annual pre-tax cash flow ÷ cash invested</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
