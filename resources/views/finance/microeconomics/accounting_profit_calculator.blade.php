<x-calc.page
    title="Accounting Profit Calculator - SolveKit"
    description="Free Accounting Profit Calculator: profit = revenue − explicit costs. Accounting profit counts only costs actually paid (explicit costs)."
    lede="Work out the accounting profit from total revenue and explicit costs."
    about="Accounting profit counts only costs actually paid (explicit costs). Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'accounting_profit', 'fields' => ['revenue', 'explicit']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Total revenue, Explicit costs.'],
        ['name' => 'Read the result', 'text' => 'The accounting profit appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the accounting profit?', 'answer' => 'Profit = revenue − explicit costs.'],
        ['question' => 'What is the accounting profit for total revenue $500,000, explicit costs $380,000?', 'answer' => '$120,000.00.'],
        ['question' => 'And for total revenue $120,000, explicit costs $135,000?', 'answer' => '−$15,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Economic profit also subtracts opportunity costs.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Total revenue" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="explicit" label="Explicit costs" value="380000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Accounting profit" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 500000, 'explicit' => 380000],
        'Example B' => ['revenue' => 120000, 'explicit' => 135000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>profit = revenue − explicit costs</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
