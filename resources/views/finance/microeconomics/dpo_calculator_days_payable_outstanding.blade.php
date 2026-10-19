<x-calc.page
    title="DPO Calculator — Days Payable Outstanding - SolveKit"
    description="Free DPO Calculator — Days Payable Outstanding: DPO = payables ÷ COGS × days. DPO is the average days a company takes to pay its suppliers."
    lede="Work out the days payable outstanding from accounts payable, cost of goods sold and days in the period."
    about="DPO is the average days a company takes to pay its suppliers. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dpo_calculator_days_payable_outstanding', 'fields' => ['payables', 'cogs', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Accounts payable, Cost of goods sold, Days in the period.'],
        ['name' => 'Read the result', 'text' => 'The days payable outstanding appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the days payable outstanding?', 'answer' => 'DPO = payables ÷ COGS × days.'],
        ['question' => 'What is the days payable outstanding for accounts payable $45,000, cost of goods sold $400,000, days in the period 365?', 'answer' => '41.06 days.'],
        ['question' => 'And for accounts payable $12,000, cost of goods sold $60,000, days in the period 90?', 'answer' => '18 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Paying later preserves cash but can strain suppliers.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="payables" label="Accounts payable" value="45000" step="0.01" suffix="$" />
        <x-calc.field name="cogs" label="Cost of goods sold" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days in the period" value="365" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Days payable outstanding" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['payables' => 45000, 'cogs' => 400000, 'days' => 365],
        'Example B' => ['payables' => 12000, 'cogs' => 60000, 'days' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DPO = payables ÷ COGS × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
