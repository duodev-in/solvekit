<x-calc.page
    title="Return on Assets Calculator - SolveKit"
    description="Free Return on Assets Calculator: ROA = net income ÷ average total assets. Return on assets shows how profitably a company uses everything it owns."
    lede="Work out the ROA from net income and average total assets."
    about="Return on assets shows how profitably a company uses everything it owns. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'roa', 'fields' => ['income', 'assets']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Net income, Average total assets.'],
        ['name' => 'Read the result', 'text' => 'The ROA appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the ROA?', 'answer' => 'ROA = net income ÷ average total assets.'],
        ['question' => 'What is the ROA for net income $600,000, average total assets $8,000,000?', 'answer' => '7.5%.'],
        ['question' => 'And for net income $95,000, average total assets $1,400,000?', 'answer' => '6.786%.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Banks often earn about 1%; asset-light firms far more.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="income" label="Net income" value="600000" step="0.01" suffix="$" />
        <x-calc.field name="assets" label="Average total assets" value="8000000" step="0.01" suffix="$" />
    </div>

    <x-calc.result label="ROA" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['income' => 600000, 'assets' => 8000000],
        'Example B' => ['income' => 95000, 'assets' => 1400000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ROA = net income ÷ average total assets</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
