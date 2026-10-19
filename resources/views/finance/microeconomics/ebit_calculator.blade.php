<x-calc.page
    title="EBIT Calculator - SolveKit"
    description="Free EBIT Calculator: EBIT = revenue − COGS − operating expenses. Earnings before interest and taxes is operating profit."
    lede="Work out the EBIT from revenue, cost of goods sold and operating expenses."
    about="Earnings before interest and taxes is operating profit. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ebit', 'fields' => ['revenue', 'cogs', 'opex']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Cost of goods sold, Operating expenses.'],
        ['name' => 'Read the result', 'text' => 'The EBIT appears as you type, with operating margin below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EBIT?', 'answer' => 'EBIT = revenue − COGS − operating expenses.'],
        ['question' => 'What is the EBIT for revenue $2,000,000, cost of goods sold $1,100,000, operating expenses $500,000?', 'answer' => '$400,000.00. Operating margin: 20%.'],
        ['question' => 'And for revenue $500,000, cost of goods sold $300,000, operating expenses $150,000?', 'answer' => '$50,000.00. Operating margin: 10%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'It ignores how the company is financed.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="revenue" label="Revenue" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="cogs" label="Cost of goods sold" value="1100000" step="0.01" suffix="$" />
        <x-calc.field name="opex" label="Operating expenses" value="500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EBIT" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 2000000, 'cogs' => 1100000, 'opex' => 500000],
        'Example B' => ['revenue' => 500000, 'cogs' => 300000, 'opex' => 150000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Operating margin'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EBIT = revenue − COGS − operating expenses</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
