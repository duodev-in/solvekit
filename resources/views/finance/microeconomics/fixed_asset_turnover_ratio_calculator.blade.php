<x-calc.page
    title="Fixed Asset Turnover Ratio Calculator - SolveKit"
    description="Free Fixed Asset Turnover Ratio Calculator: FAT = revenue ÷ average net fixed assets. Shows how much revenue each dollar of property, plant and equipment generates."
    lede="Work out the fixed asset turnover from revenue and average net fixed assets."
    about="Shows how much revenue each dollar of property, plant and equipment generates. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'fixed_asset_turnover_ratio', 'fields' => ['revenue', 'assets']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Revenue, Average net fixed assets.'],
        ['name' => 'Read the result', 'text' => 'The fixed asset turnover appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the fixed asset turnover?', 'answer' => 'FAT = revenue ÷ average net fixed assets.'],
        ['question' => 'What is the fixed asset turnover for revenue $2,000,000, average net fixed assets $800,000?', 'answer' => '2.5×.'],
        ['question' => 'And for revenue $450,000, average net fixed assets $600,000?', 'answer' => '0.75×.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Capital-heavy industries have lower ratios.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="revenue" label="Revenue" value="2000000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Average net fixed assets" value="800000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="Fixed asset turnover" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['revenue' => 2000000, 'assets' => 800000],
        'Example B' => ['revenue' => 450000, 'assets' => 600000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>FAT = revenue ÷ average net fixed assets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
