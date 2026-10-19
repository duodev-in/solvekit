<x-calc.page
    title="A/R Days Calculator - SolveKit"
    description="Free A/R Days Calculator: A/R days = receivables ÷ credit sales × days. Accounts receivable days estimate how long customers take on average to pay."
    lede="Work out the A/R days from accounts receivable, credit sales in the period and days in the period."
    about="Accounts receivable days estimate how long customers take on average to pay. The same figure is called days sales outstanding (DSO). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'a_r_days', 'fields' => ['receivables', 'revenue', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Accounts receivable, Credit sales in the period, Days in the period.'],
        ['name' => 'Read the result', 'text' => 'The A/R days appears as you type, with receivables turnover below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the A/R days?', 'answer' => 'A/R days = receivables ÷ credit sales × days.'],
        ['question' => 'What is the A/R days for accounts receivable $85,000, credit sales in the period $600,000, days in the period 365?', 'answer' => '51.71 days. Receivables turnover: 7.059×.'],
        ['question' => 'And for accounts receivable $40,000, credit sales in the period $120,000, days in the period 90?', 'answer' => '30 days. Receivables turnover: 3×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare it with your payment terms: 52 days on 30-day terms means customers pay late.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="receivables" label="Accounts receivable" value="85000" step="0.01" suffix="$" />
        <x-calc.field name="revenue" label="Credit sales in the period" value="600000" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days in the period" value="365" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="A/R days" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['receivables' => 85000, 'revenue' => 600000, 'days' => 365],
        'Example B' => ['receivables' => 40000, 'revenue' => 120000, 'days' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Receivables turnover'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>A/R days = receivables ÷ credit sales × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
