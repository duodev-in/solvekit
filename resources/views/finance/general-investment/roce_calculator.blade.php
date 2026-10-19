<x-calc.page
    title="Return on Capital Employed Calculator (ROCE) - SolveKit"
    description="Free Return on Capital Employed Calculator (ROCE): ROCE = EBIT ÷ (total assets − current liabilities). Return on capital employed measures the operating return on the long-term capital in the business."
    lede="Work out the ROCE from EBIT, total assets and current liabilities."
    about="Return on capital employed measures the operating return on the long-term capital in the business. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'roce', 'fields' => ['ebit', 'assets', 'liabilities']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'EBIT, Total assets, Current liabilities.'],
        ['name' => 'Read the result', 'text' => 'The ROCE appears as you type, with capital employed below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ROCE?', 'answer' => 'ROCE = EBIT ÷ (total assets − current liabilities).'],
        ['question' => 'What is the ROCE for EBIT $400,000, total assets $2,500,000, current liabilities $500,000?', 'answer' => '20%. Capital employed: $2,000,000.00.'],
        ['question' => 'And for EBIT $90,000, total assets $800,000, current liabilities $150,000?', 'answer' => '13.85%. Capital employed: $650,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Compare with the cost of capital: ROCE above it creates value.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="ebit" label="EBIT" value="400000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Total assets" value="2500000" step="0.01" suffix="$" />
        <x-calc.field name="liabilities" label="Current liabilities" value="500000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="ROCE" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['ebit' => 400000, 'assets' => 2500000, 'liabilities' => 500000],
        'Example B' => ['ebit' => 90000, 'assets' => 800000, 'liabilities' => 150000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Capital employed'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROCE = EBIT ÷ (total assets − current liabilities)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
