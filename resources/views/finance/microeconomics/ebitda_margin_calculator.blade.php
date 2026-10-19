<x-calc.page
    title="EBITDA Margin Calculator - SolveKit"
    description="Free EBITDA Margin Calculator: EBITDA margin = EBITDA ÷ revenue. EBITDA margin compares operating cash earnings across companies of different size."
    lede="Work out the EBITDA margin from EBITDA and revenue."
    about="EBITDA margin compares operating cash earnings across companies of different size. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'ebitda_margin', 'fields' => ['ebitda', 'revenue']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBITDA, Revenue.'],
        ['name' => 'Read the result', 'text' => 'The EBITDA margin appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EBITDA margin?', 'answer' => 'EBITDA margin = EBITDA ÷ revenue.'],
        ['question' => 'What is the EBITDA margin for EBITDA $500,000, revenue $2,500,000?', 'answer' => '20%.'],
        ['question' => 'And for EBITDA $80,000, revenue $900,000?', 'answer' => '8.889%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare within an industry.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="ebitda" label="EBITDA" value="500000" step="0.01" suffix="$" />
        <x-calc.field name="revenue" label="Revenue" value="2500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EBITDA margin" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebitda' => 500000, 'revenue' => 2500000],
        'Example B' => ['ebitda' => 80000, 'revenue' => 900000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EBITDA margin = EBITDA ÷ revenue</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
