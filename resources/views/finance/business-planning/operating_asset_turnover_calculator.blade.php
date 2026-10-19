<x-calc.page
    title="Operating Asset Turnover Calculator - SolveKit"
    description="Free Operating Asset Turnover Calculator: turnover = revenue ÷ operating assets. Operating asset turnover shows how much revenue each dollar of operating assets generates."
    lede="Work out the operating asset turnover from revenue and average operating assets."
    about="Operating asset turnover shows how much revenue each dollar of operating assets generates. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'operating_asset_turnover', 'fields' => ['revenue', 'assets']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Average operating assets.'],
        ['name' => 'Read the result', 'text' => 'The operating asset turnover appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the operating asset turnover?', 'answer' => 'Turnover = revenue ÷ operating assets.'],
        ['question' => 'What is the operating asset turnover for revenue $900,000, average operating assets $600,000?', 'answer' => '1.5×.'],
        ['question' => 'And for revenue $2,400,000, average operating assets $1,500,000?', 'answer' => '1.6×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Higher means the business uses its operating assets more efficiently.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Revenue" value="900000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Average operating assets" value="600000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Operating asset turnover" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 900000, 'assets' => 600000],
        'Example B' => ['revenue' => 2400000, 'assets' => 1500000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>turnover = revenue ÷ operating assets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
