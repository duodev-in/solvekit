<x-calc.page
    title="Average Collection Period Calculator - SolveKit"
    description="Free Average Collection Period Calculator: ACP = 365 × average receivables ÷ credit sales (= 365 ÷ receivables turnover). The average collection period is how many days it takes to collect a credit sale."
    lede="Work out the average collection period from average accounts receivable and annual credit sales."
    about="The average collection period is how many days it takes to collect a credit sale. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'average_collection_period', 'fields' => ['receivables', 'sales']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Average accounts receivable, Annual credit sales.'],
        ['name' => 'Read the result', 'text' => 'The average collection period appears as you type, with receivables turnover below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the average collection period?', 'answer' => 'ACP = 365 × average receivables ÷ credit sales (= 365 ÷ receivables turnover).'],
        ['question' => 'What is the average collection period for average accounts receivable $50,000, annual credit sales $500,000?', 'answer' => '36.5 days. Receivables turnover: 10×.'],
        ['question' => 'And for average accounts receivable $120,000, annual credit sales $900,000?', 'answer' => '48.67 days. Receivables turnover: 7.5×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Shorter is better; compare with the credit terms you give.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="receivables" label="Average accounts receivable" value="50000" step="0.01" suffix="$" />
        <x-calc.field name="sales" label="Annual credit sales" value="500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Average collection period" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['receivables' => 50000, 'sales' => 500000],
        'Example B' => ['receivables' => 120000, 'sales' => 900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Receivables turnover'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ACP = 365 × average receivables ÷ credit sales (= 365 ÷ receivables turnover)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
