<x-calc.page
    title="Cash Flow to Debt Ratio Calculator - SolveKit"
    description="Free Cash Flow to Debt Ratio Calculator: ratio = operating cash flow ÷ total debt. Shows how much of total debt one year of operating cash flow could repay."
    lede="Work out the cash flow to debt from operating cash flow and total debt."
    about="Shows how much of total debt one year of operating cash flow could repay. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'cash_flow_to_debt_ratio', 'fields' => ['ocf', 'debt']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Operating cash flow, Total debt.'],
        ['name' => 'Read the result', 'text' => 'The cash flow to debt appears as you type, with years to repay below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the cash flow to debt?', 'answer' => 'Ratio = operating cash flow ÷ total debt.'],
        ['question' => 'What is the cash flow to debt for operating cash flow $400,000, total debt $1,600,000?', 'answer' => '0.25×. Years to repay: 4 years.'],
        ['question' => 'And for operating cash flow $90,000, total debt $250,000?', 'answer' => '0.36×. Years to repay: 2.778 years.'],
        ['question' => 'What does the result tell me?', 'answer' => 'The inverse is the years needed to repay debt from cash flow.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ocf" label="Operating cash flow" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="debt" label="Total debt" value="1600000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Cash flow to debt" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ocf' => 400000, 'debt' => 1600000],
        'Example B' => ['ocf' => 90000, 'debt' => 250000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Years to repay'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ratio = operating cash flow ÷ total debt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
