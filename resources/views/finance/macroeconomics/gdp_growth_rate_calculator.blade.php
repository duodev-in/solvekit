<x-calc.page
    title="GDP Growth Rate Calculator - SolveKit"
    description="Free GDP Growth Rate Calculator: growth = (GDP₁ − GDP₀) ÷ GDP₀. Use real GDP for growth in output; nominal GDP growth includes inflation."
    lede="Work out the GDP growth from GDP in the earlier period and GDP in the later period."
    about="Use real GDP for growth in output; nominal GDP growth includes inflation. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'gdp_growth_rate', 'fields' => ['previous', 'current']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'GDP in the earlier period, GDP in the later period.'],
        ['name' => 'Read the result', 'text' => 'The GDP growth appears as you type, with annualized if quarterly below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the GDP growth?', 'answer' => 'Growth = (GDP₁ − GDP₀) ÷ GDP₀.'],
        ['question' => 'What is the GDP growth for GDP in the earlier period $21,000, GDP in the later period $21,630?', 'answer' => '3%. Annualized if quarterly: 12.55%.'],
        ['question' => 'And for GDP in the earlier period $1,000, GDP in the later period $985?', 'answer' => '−1.5%. Annualized if quarterly: −5.866%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'US quarterly figures are reported at an annualized rate: (1 + q)^4 − 1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="previous" label="GDP in the earlier period" value="21000" step="0.01" suffix="$" />
        <x-calc.field name="current" label="GDP in the later period" value="21630" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="GDP growth" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['previous' => 21000, 'current' => 21630],
        'Example B' => ['previous' => 1000, 'current' => 985],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Annualized if quarterly'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>growth = (GDP₁ − GDP₀) ÷ GDP₀</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
