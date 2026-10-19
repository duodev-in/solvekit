<x-calc.page
    title="Total Asset Turnover Calculator - SolveKit"
    description="Free Total Asset Turnover Calculator: turnover = revenue ÷ average total assets. Asset turnover shows sales generated per dollar of assets; it is a DuPont component."
    lede="Work out the asset turnover from revenue and average total assets."
    about="Asset turnover shows sales generated per dollar of assets; it is a DuPont component. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'total_asset_turnover', 'fields' => ['revenue', 'assets']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Average total assets.'],
        ['name' => 'Read the result', 'text' => 'The asset turnover appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the asset turnover?', 'answer' => 'Turnover = revenue ÷ average total assets.'],
        ['question' => 'What is the asset turnover for revenue $3,000,000, average total assets $2,000,000?', 'answer' => '1.5×.'],
        ['question' => 'And for revenue $700,000, average total assets $1,100,000?', 'answer' => '0.6364×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Retailers often turn assets 2–3 times a year; utilities well under 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Revenue" value="3000000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Average total assets" value="2000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Asset turnover" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 3000000, 'assets' => 2000000],
        'Example B' => ['revenue' => 700000, 'assets' => 1100000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turnover = revenue ÷ average total assets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
