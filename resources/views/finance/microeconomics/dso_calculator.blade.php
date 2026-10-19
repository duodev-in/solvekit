<x-calc.page
    title="DSO Calculator - SolveKit"
    description="Free DSO Calculator: DSO = receivables ÷ credit sales × days. DSO is the average days to collect payment after a sale."
    lede="Work out the days sales outstanding from accounts receivable, credit sales in the period and days in the period."
    about="DSO is the average days to collect payment after a sale. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dso', 'fields' => ['receivables', 'sales', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Accounts receivable, Credit sales in the period, Days in the period.'],
        ['name' => 'Read the result', 'text' => 'The days sales outstanding appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the days sales outstanding?', 'answer' => 'DSO = receivables ÷ credit sales × days.'],
        ['question' => 'What is the days sales outstanding for accounts receivable $80,000, credit sales in the period $480,000, days in the period 365?', 'answer' => '60.83 days.'],
        ['question' => 'And for accounts receivable $30,000, credit sales in the period $90,000, days in the period 90?', 'answer' => '30 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with your credit terms.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="receivables" label="Accounts receivable" value="80000" step="0.01" suffix="$" />
        <x-calc.field name="sales" label="Credit sales in the period" value="480000" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days in the period" value="365" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Days sales outstanding" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['receivables' => 80000, 'sales' => 480000, 'days' => 365],
        'Example B' => ['receivables' => 30000, 'sales' => 90000, 'days' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DSO = receivables ÷ credit sales × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
