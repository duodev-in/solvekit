<x-calc.page
    title="Revenue Growth Calculator - SolveKit"
    description="Free Revenue Growth Calculator: growth = (current − prior) ÷ prior. Revenue growth compares sales between periods."
    lede="Work out the revenue growth from prior period revenue and current period revenue."
    about="Revenue growth compares sales between periods. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'revenue_growth', 'fields' => ['prior', 'current']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Prior period revenue, Current period revenue.'],
        ['name' => 'Read the result', 'text' => 'The revenue growth appears as you type, with change below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the revenue growth?', 'answer' => 'Growth = (current − prior) ÷ prior.'],
        ['question' => 'What is the revenue growth for prior period revenue $800,000, current period revenue $940,000?', 'answer' => '17.5%. Change: $140,000.00.'],
        ['question' => 'And for prior period revenue $2,400,000, current period revenue $2,150,000?', 'answer' => '−10.42%. Change: −$250,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare like periods to avoid seasonality.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prior" label="Prior period revenue" value="800000" step="0.01" suffix="$" />
        <x-calc.field name="current" label="Current period revenue" value="940000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Revenue growth" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['prior' => 800000, 'current' => 940000],
        'Example B' => ['prior' => 2400000, 'current' => 2150000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Change'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>growth = (current − prior) ÷ prior</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
