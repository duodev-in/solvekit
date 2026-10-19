<x-calc.page
    title="Earnings Per Share Growth Calculator - SolveKit"
    description="Free Earnings Per Share Growth Calculator: growth = (EPS₁ − EPS₀) ÷ |EPS₀|. EPS growth shows how fast earnings per share are rising."
    lede="Work out the EPS growth from previous EPS and current EPS."
    about="EPS growth shows how fast earnings per share are rising. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'earnings_per_share_growth', 'fields' => ['previous', 'current']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Previous EPS, Current EPS.'],
        ['name' => 'Read the result', 'text' => 'The EPS growth appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EPS growth?', 'answer' => 'Growth = (EPS₁ − EPS₀) ÷ |EPS₀|.'],
        ['question' => 'What is the EPS growth for previous EPS $2.50, current EPS $3.10?', 'answer' => '24%.'],
        ['question' => 'And for previous EPS −$0.50, current EPS $0.40?', 'answer' => '180%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Using |EPS₀| keeps the sign meaningful when earnings were negative.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="previous" label="Previous EPS" value="2.5" step="0.01" suffix="$" />
        <x-calc.field name="current" label="Current EPS" value="3.1" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EPS growth" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['previous' => 2.5, 'current' => 3.1],
        'Example B' => ['previous' => -0.5, 'current' => 0.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>growth = (EPS₁ − EPS₀) ÷ |EPS₀|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
