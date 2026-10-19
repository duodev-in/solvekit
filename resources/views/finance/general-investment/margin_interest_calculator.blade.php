<x-calc.page
    title="Margin Interest Calculator - SolveKit"
    description="Free Margin Interest Calculator: interest = loan × rate × days ÷ 360 (most US brokers). Brokers charge margin interest daily on the loan balance, usually on a 360-day year."
    lede="Work out the interest from your figures."
    about="Brokers charge margin interest daily on the loan balance, usually on a 360-day year. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'margin_interest', 'fields' => ['loan', 'rate', 'days', 'basis']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Margin loan balance, Margin rate, Days borrowed, Day count.'],
        ['name' => 'Read the result', 'text' => 'The interest appears as you type, with per day, for a year below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the interest?', 'answer' => 'Interest = loan × rate × days ÷ 360 (most US brokers).'],
        ['question' => 'What is the interest for margin loan balance $25,000, margin rate 11.5%, days borrowed 30, day count 360 days?', 'answer' => '$239.58. Per day: $7.99.'],
        ['question' => 'And for margin loan balance $80,000, margin rate 9%, days borrowed 90, day count 360 days?', 'answer' => '$1,800.00. Per day: $20.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Check your broker\'s rate tiers: rates fall as balances rise.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="loan" label="Margin loan balance" value="25000" step="0.01" suffix="$" />
        <x-calc.field name="rate" label="Margin rate" value="11.5" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="days" label="Days borrowed" value="30" min="0" step="any" suffix="days" />
        <x-calc.select name="basis" label="Day count" :options="['360' => '360 days', '365' => '365 days']" selected="360" />
    </div>

    <x-calc.result label="Interest" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['loan' => 25000, 'rate' => 11.5, 'days' => 30, 'basis' => '360'],
        'Example B' => ['loan' => 80000, 'rate' => 9, 'days' => 90, 'basis' => '360'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Per day'],
            'r2' => ['label' => 'For a year'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>interest = loan × rate × days ÷ 360 (most US brokers)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
