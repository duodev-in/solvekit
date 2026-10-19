<x-calc.page
    title="Economic Value Added Calculator - SolveKit"
    description="Free Economic Value Added Calculator: EVA = NOPAT − WACC × capital. Economic value added is the profit left after charging for all capital, debt and equity."
    lede="Work out the EVA from NOPAT, WACC and invested capital."
    about="Economic value added is the profit left after charging for all capital, debt and equity. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'economic_value_added', 'fields' => ['nopat', 'wacc', 'capital']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'NOPAT, WACC, Invested capital.'],
        ['name' => 'Read the result', 'text' => 'The EVA appears as you type, with capital charge below.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the EVA?', 'answer' => 'EVA = NOPAT − WACC × capital.'],
        ['question' => 'What is the EVA for NOPAT $1,500,000, WACC 9%, invested capital $12,000,000?', 'answer' => '$420,000.00. Capital charge: $1,080,000.00.'],
        ['question' => 'And for NOPAT $400,000, WACC 10%, invested capital $5,000,000?', 'answer' => '−$100,000.00. Capital charge: $500,000.00.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Positive EVA means the company earns more than its cost of capital.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="nopat" label="NOPAT" value="1500000" step="0.01" suffix="$" />
        <x-calc.field name="wacc" label="WACC" value="9" step="any" suffix="%" />
        <x-calc.field name="capital" label="Invested capital" value="12000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="EVA" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['nopat' => 1500000, 'wacc' => 9, 'capital' => 12000000],
        'Example B' => ['nopat' => 400000, 'wacc' => 10, 'capital' => 5000000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'r1' => ['label' => 'Capital charge'],
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>EVA = NOPAT − WACC × capital</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
