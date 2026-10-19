<x-calc.page
    title="GMROI Calculator — Gross Margin Return on Investment - SolveKit"
    description="Free GMROI Calculator — Gross Margin Return on Investment: GMROI = gross margin ÷ average inventory cost. GMROI shows the gross margin earned for each dollar invested in inventory."
    lede="Work out the GMROI from gross margin and average inventory at cost."
    about="GMROI shows the gross margin earned for each dollar invested in inventory. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gmroi', 'fields' => ['margin', 'inventory']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Gross margin, Average inventory at cost.'],
        ['name' => 'Read the result', 'text' => 'The GMROI appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the GMROI?', 'answer' => 'GMROI = gross margin ÷ average inventory cost.'],
        ['question' => 'What is the GMROI for gross margin $120,000, average inventory at cost $50,000?', 'answer' => '2.4×.'],
        ['question' => 'And for gross margin $45,000, average inventory at cost $30,000?', 'answer' => '1.5×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Above 1 means the stock earns more than it costs; many retailers aim for 3 or more.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="margin" label="Gross margin" value="120000" step="0.01" suffix="$" />
        <x-calc.field name="inventory" label="Average inventory at cost" value="50000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="GMROI" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['margin' => 120000, 'inventory' => 50000],
        'Example B' => ['margin' => 45000, 'inventory' => 30000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>GMROI = gross margin ÷ average inventory cost</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
