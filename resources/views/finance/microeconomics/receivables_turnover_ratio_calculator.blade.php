<x-calc.page
    title="Receivables Turnover Ratio Calculator - SolveKit"
    description="Free Receivables Turnover Ratio Calculator: turnover = credit sales ÷ average receivables. How many times a year receivables are collected."
    lede="Work out the receivables turnover from net credit sales and average accounts receivable."
    about="How many times a year receivables are collected. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'receivables_turnover_ratio', 'fields' => ['sales', 'receivables']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net credit sales, Average accounts receivable.'],
        ['name' => 'Read the result', 'text' => 'The receivables turnover appears as you type, with average collection period below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the receivables turnover?', 'answer' => 'Turnover = credit sales ÷ average receivables.'],
        ['question' => 'What is the receivables turnover for net credit sales $1,200,000, average accounts receivable $150,000?', 'answer' => '8×. Average collection period: 45.63 days.'],
        ['question' => 'And for net credit sales $300,000, average accounts receivable $60,000?', 'answer' => '5×. Average collection period: 73 days.'],
        ['question' => 'What does the result tell me?', 'answer' => '365 ÷ turnover is the average collection period.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="sales" label="Net credit sales" value="1200000" step="0.01" suffix="$" />
        <x-calc.field name="receivables" label="Average accounts receivable" value="150000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Receivables turnover" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['sales' => 1200000, 'receivables' => 150000],
        'Example B' => ['sales' => 300000, 'receivables' => 60000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Average collection period'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turnover = credit sales ÷ average receivables</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
