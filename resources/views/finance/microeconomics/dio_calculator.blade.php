<x-calc.page
    title="DIO Calculator - SolveKit"
    description="Free DIO Calculator: DIO = inventory ÷ COGS × days. DIO is the average days inventory is held before being sold."
    lede="Work out the days inventory outstanding from average inventory, cost of goods sold and days in the period."
    about="DIO is the average days inventory is held before being sold. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'dio', 'fields' => ['inventory', 'cogs', 'days']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Average inventory, Cost of goods sold, Days in the period.'],
        ['name' => 'Read the result', 'text' => 'The days inventory outstanding appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the days inventory outstanding?', 'answer' => 'DIO = inventory ÷ COGS × days.'],
        ['question' => 'What is the days inventory outstanding for average inventory $60,000, cost of goods sold $400,000, days in the period 365?', 'answer' => '54.75 days.'],
        ['question' => 'And for average inventory $9,000, cost of goods sold $36,000, days in the period 90?', 'answer' => '22.5 days.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Lower means faster-moving stock.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="inventory" label="Average inventory" value="60000" step="0.01" suffix="$" />
        <x-calc.field name="cogs" label="Cost of goods sold" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="days" label="Days in the period" value="365" min="0" step="any" suffix="days" />
    </div>

    <x-calc.result label="Days inventory outstanding" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['inventory' => 60000, 'cogs' => 400000, 'days' => 365],
        'Example B' => ['inventory' => 9000, 'cogs' => 36000, 'days' => 90],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DIO = inventory ÷ COGS × days</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
